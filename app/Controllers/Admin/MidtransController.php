<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PesananModel;
use App\Models\TransactionModel;
use Midtrans\Config;
use Midtrans\Transaction;

class MidtransController extends BaseController
{
    protected $pesananModel;
    protected $transactionModel;
    protected $db;

    public function __construct()
    {
        $this->pesananModel = new PesananModel();
        $this->transactionModel = new TransactionModel();
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        // Ambil transaksi terbaru (limit 10)
        $transactions = $this->transactionModel
            ->select('transactions.*, pesanan.nama_penerima, pesanan.email, pesanan.no_telepon, users.nama_lengkap as customer_name')
            ->join('pesanan', 'pesanan.id = transactions.pesanan_id', 'left')
            ->join('users', 'users.id = pesanan.user_id', 'left')
            ->orderBy('transactions.created_at', 'DESC')
            ->limit(10)
            ->find();

        // Statistik
        $stats = [
            'success_count' => $this->transactionModel->where('transaction_status', 'settlement')->countAllResults(false),
            'pending_count' => $this->transactionModel->where('transaction_status', 'pending')->countAllResults(false),
            'failed_count' => $this->transactionModel->whereIn('transaction_status', ['cancel', 'deny', 'expire'])->countAllResults(false),
            'total_revenue' => $this->db->table('transactions')
                ->selectSum('gross_amount')
                ->where('transaction_status', 'settlement')
                ->get()
                ->getRow()
                ->gross_amount ?? 0
        ];

        // Midtrans Config
        $config = [
            'server_key' => getenv('MIDTRANS_SERVER_KEY') ?: '',
            'client_key' => getenv('MIDTRANS_CLIENT_KEY') ?: '',
            'merchant_id' => getenv('MIDTRANS_MERCHANT_ID') ?: '',
            'is_production' => getenv('MIDTRANS_IS_PRODUCTION') === 'true'
        ];

        $data = [
            'title' => 'Midtrans Payment Gateway',
            'pageTitle' => 'Midtrans',
            'transactions' => $transactions,
            'stats' => $stats,
            'config' => $config
        ];

        return view('admin/midtrans/index', $data);
    }

    public function detail($transaction_id)
    {
        $transaction = $this->transactionModel
            ->select('transactions.*, pesanan.*, users.nama_lengkap as customer_name, users.email as user_email')
            ->join('pesanan', 'pesanan.id = transactions.pesanan_id', 'left')
            ->join('users', 'users.id = pesanan.user_id', 'left')
            ->where('transactions.id', $transaction_id)
            ->first();

        if (!$transaction) {
            return redirect()->to('admin/midtrans')->with('error', 'Transaksi tidak ditemukan');
        }

        // Ambil items pesanan
        $items = $this->db->table('pesanan_items')
            ->select('pesanan_items.*, produk.nama_produk, produk.gambar')
            ->join('produk', 'produk.id = pesanan_items.produk_id')
            ->where('pesanan_items.pesanan_id', $transaction['pesanan_id'])
            ->get()
            ->getResultArray();

        $data = [
            'title' => 'Detail Transaksi',
            'pageTitle' => 'Detail Transaksi',
            'transaction' => $transaction,
            'items' => $items
        ];

        return view('admin/midtrans/detail', $data);
    }

    public function checkStatus($order_id)
    {
        // Load Midtrans Config
        Config::$serverKey = getenv('MIDTRANS_SERVER_KEY');
        Config::$isProduction = getenv('MIDTRANS_IS_PRODUCTION') === 'true';

        try {
            /** @var \stdClass $status */
            $status = Transaction::status($order_id);

            // Update status di database
            $transaction = $this->transactionModel->where('order_id', $order_id)->first();

            if ($transaction) {
                $this->transactionModel->update($transaction['id'], [
                    'transaction_id' => $status->transaction_id,
                    'transaction_status' => $status->transaction_status,
                    'payment_type' => $status->payment_type,
                    'transaction_time' => $status->transaction_time,
                    'updated_at' => date('Y-m-d H:i:s')
                ]);

                // Update status pesanan
                if ($status->transaction_status == 'settlement') {
                    $this->pesananModel->update($transaction['pesanan_id'], [
                        'payment_status' => 'paid'
                    ]);
                }

                return redirect()->to('admin/midtrans/detail/' . $transaction['id'])
                    ->with('success', 'Status transaksi berhasil diperbarui');
            }

            return redirect()->to('admin/midtrans')->with('error', 'Transaksi tidak ditemukan');

        } catch (\Exception $e) {
            return redirect()->to('admin/midtrans')->with('error', 'Gagal memeriksa status: ' . $e->getMessage());
        }
    }

    public function updateConfig()
    {
        $request = service('request');
        if ($request->getMethod() === 'post') {
            $validation = \Config\Services::validation();

            $validation->setRules([
                'server_key' => 'required',
                'client_key' => 'required',
                'is_production' => 'required|in_list[0,1]'
            ]);

            if ($validation->withRequest($request)->run()) {
                // Simpan ke .env file
                $envPath = ROOTPATH . '.env';
                if (!file_exists($envPath)) {
                    return redirect()->back()->with('error', 'File .env tidak ditemukan');
                }

                if (!is_writable($envPath)) {
                    return redirect()->back()->with('error', 'File .env tidak dapat ditulis');
                }

                $envContent = file_get_contents($envPath);

                $isProd = $request->getPost('is_production') === '1' ? 'true' : 'false';

                $updates = [
                    'MIDTRANS_SERVER_KEY' => $request->getPost('server_key'),
                    'MIDTRANS_CLIENT_KEY' => $request->getPost('client_key'),
                    'MIDTRANS_MERCHANT_ID' => $request->getPost('merchant_id') ?: '',
                    'MIDTRANS_IS_PRODUCTION' => $isProd
                ];

                foreach ($updates as $key => $value) {
                    if (preg_match("/^{$key}=/m", $envContent)) {
                        $envContent = preg_replace("/^{$key}=.*/m", "{$key}={$value}", $envContent);
                    } else {
                        $envContent .= "\n{$key}={$value}";
                    }
                }

                if (file_put_contents($envPath, $envContent) === false) {
                    return redirect()->back()->with('error', 'Gagal menyimpan konfigurasi ke file .env');
                }

                return redirect()->to('admin/midtrans')->with('success', 'Konfigurasi Midtrans berhasil disimpan');
            }

            return redirect()->back()->with('error', 'Validasi gagal')->withInput();
        }

        return redirect()->to('admin/midtrans');
    }
}
