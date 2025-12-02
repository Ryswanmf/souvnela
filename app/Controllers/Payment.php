<?php

namespace App\Controllers;

use App\Models\PesananModel;
use App\Models\PesananItemModel;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;

class Payment extends BaseController
{
    protected $pesananModel;
    protected $itemModel;

    public function __construct()
    {
        $this->pesananModel = new PesananModel();
        $this->itemModel = new PesananItemModel();

        // NOTE: Jangan panggil env() di sini — gunakan getenv() agar konsisten di CI4
        $this->initMidtrans();
    }

    /**
     * Initialize Midtrans configuration
     */
    private function initMidtrans()
    {
        Config::$serverKey = getenv('MIDTRANS_SERVER_KEY') ?: '';
        Config::$clientKey = getenv('MIDTRANS_CLIENT_KEY') ?: '';
        Config::$isProduction = (getenv('MIDTRANS_IS_PRODUCTION') === 'true');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    /**
     * Process AJAX checkout request, create order, and return Snap token
     */
    public function process()
    {
        // Ensure JSON response header
        $this->response->setHeader('Content-Type', 'application/json');

        try {
            // Only accept AJAX request
            if (!$this->request->isAJAX()) {
                return $this->response->setJSON(['success' => false, 'message' => 'Invalid request type']);
            }

            $cart = session()->get('cart') ?? [];
            if (empty($cart)) {
                return $this->response->setJSON(['success' => false, 'message' => 'Keranjang kosong']);
            }

            // ... (rest of the logic) ...

            // Get form data (sanitize/trim)
            $nama_penerima = trim($this->request->getPost('nama_penerima'));
            $telepon_raw   = trim($this->request->getPost('telepon'));
            $email         = trim($this->request->getPost('email'));
            $alamat        = trim($this->request->getPost('alamat'));
            $kota          = trim($this->request->getPost('kota'));
            $kode_pos      = trim($this->request->getPost('kode_pos'));
            $catatan       = trim($this->request->getPost('catatan'));
            $shipping_method = trim($this->request->getPost('shipping_method'));
            $total_post    = $this->request->getPost('total');
            $voucher_id    = $this->request->getPost('voucher_id');
            $shipping_cost  = $this->request->getPost('shipping_cost') ?: 0;
            $discount_amount = $this->request->getPost('discount_amount') ?: 0;
            $latitude = $this->request->getPost('latitude');
            $longitude = $this->request->getPost('longitude');

            // Normalize numeric values
            $shipping_cost = (int) $shipping_cost;
            $discount_amount = (int) $discount_amount;
            $total = (int) $total_post;

            // Calculate subtotal from cart using 'jumlah'
            $subtotal = 0;
            foreach ($cart as $item) {
                $jumlah = isset($item['jumlah']) ? (int)$item['jumlah'] : (int)($item['quantity'] ?? 0);
                $harga  = isset($item['harga']) ? (int)$item['harga'] : 0;
                $subtotal += $harga * $jumlah;
            }

            // Basic validation
            if (empty($nama_penerima) || empty($telepon_raw) || empty($email)) {
                throw new \Exception('Nama, telepon, dan email wajib diisi.');
            }

            // Normalize phone number
            $telepon = $this->normalizePhone($telepon_raw);

            // Ensure total sanity
            $expectedTotal = $subtotal + $shipping_cost - $discount_amount;
            if ($total <= 0 || $total !== $expectedTotal) {
                $total = $expectedTotal;
            }

            if ($total <= 0) {
                throw new \Exception('Total pembayaran tidak valid.');
            }

            // Build order data
            $orderData = [
                'user_id' => session()->get('id'),
                'nama_penerima' => $nama_penerima,
                'pelanggan' => session()->get('nama_lengkap') ?? $nama_penerima,
                'no_telepon' => $telepon,
                'email' => $email,
                'alamat_lengkap' => $alamat . ', ' . $kota . ', ' . $kode_pos,
                'latitude' => $latitude,
                'longitude' => $longitude,
                'catatan' => $catatan,
                
                // REMOVED 'subtotal' as column does not exist in DB
                
                'ongkir' => $shipping_cost,
                'discount_amount' => $discount_amount,
                'diskon' => $discount_amount,
                
                'total_harga' => $total,
                'final_amount' => $total,
                
                'kode' => 'INV-' . strtoupper(uniqid()),
                
                'status' => 'pending',
                'payment_status' => 'pending',
                'shipping_method' => $shipping_method,
                'voucher_id' => $voucher_id ?: null,
                'created_at' => date('Y-m-d H:i:s')
            ];

            // Begin DB transaction
            $db = \Config\Database::connect();
            $db->transStart();

            // Insert order
            $orderId = $this->pesananModel->insert($orderData);
            if (!$orderId) {
                $errors = $this->pesananModel->errors();
                $db->transRollback();
                throw new \Exception('Gagal menyimpan pesanan: ' . json_encode($errors));
            }

            // Insert items and update stock
            $produkModel = new \App\Models\ProdukModel();
            foreach ($cart as $item) {
                $itemJumlah = isset($item['jumlah']) ? (int)$item['jumlah'] : (int)($item['quantity'] ?? 0);
                $itemHarga  = isset($item['harga']) ? (int)$item['harga'] : 0;

                $this->itemModel->insert([
                    'pesanan_id' => $orderId,
                    'produk_id'  => $item['id'],
                    'jumlah'     => $itemJumlah,
                    'harga'      => $itemHarga,
                    'subtotal'   => $itemHarga * $itemJumlah,
                    'created_at' => date('Y-m-d H:i:s')
                ]);

                // Update stock
                $produk = $produkModel->find($item['id']);
                if ($produk) {
                    $newStock = max(0, $produk['stok'] - $itemJumlah);
                    $produkModel->update($item['id'], ['stok' => $newStock]);
                }
            }

            // Commit DB transaction
            $db->transComplete();
            if ($db->transStatus() === false) {
                throw new \Exception('Gagal menyelesaikan transaksi database.');
            }

            // Prepare item_details for Midtrans
            $itemDetails = [];
            foreach ($cart as $item) {
                $qty = isset($item['jumlah']) ? (int)$item['jumlah'] : (int)($item['quantity'] ?? 0);
                $price = isset($item['harga']) ? (int)$item['harga'] : 0;
                $name = isset($item['nama']) ? $item['nama'] : ($item['nama_produk'] ?? 'Produk');
                $name = substr($name, 0, 50); // Midtrans name limit

                $itemDetails[] = [
                    'id' => (string)$item['id'],
                    'price' => $price,
                    'quantity' => $qty,
                    'name' => $name
                ];
            }

            if ($shipping_cost > 0) {
                $itemDetails[] = [
                    'id' => 'SHIPPING',
                    'price' => (int)$shipping_cost,
                    'quantity' => 1,
                    'name' => 'Ongkos Kirim'
                ];
            }
            
            if ($discount_amount > 0) {
                 // Midtrans doesn't support negative item directly easily in this simplified flow usually, 
                 // but let's try adding it as negative value item if allowed, OR just rely on gross_amount.
                 // Safest way: Adjust gross_amount, but item_details sum must match gross_amount.
                 // If discount exists, we can add a negative item.
                 $itemDetails[] = [
                    'id' => 'DISCOUNT',
                    'price' => -((int)$discount_amount),
                    'quantity' => 1,
                    'name' => 'Diskon Voucher'
                 ];
            }

            $midtransOrderId = 'ORDER-' . $orderId . '-' . time();
            $transactionDetails = [
                'order_id' => $midtransOrderId,
                'gross_amount' => (int)$total
            ];

            $customerDetails = [
                'first_name' => $nama_penerima,
                'email' => $email,
                'phone' => $telepon,
                'shipping_address' => [
                    'first_name' => $nama_penerima,
                    'address' => $alamat,
                    'city' => $kota,
                    'postal_code' => $kode_pos,
                    'phone' => $telepon
                ]
            ];

            $transactionData = [
                'transaction_details' => $transactionDetails,
                'item_details' => $itemDetails,
                'customer_details' => $customerDetails,
            ];

            // Get Snap Token
            $snapToken = Snap::getSnapToken($transactionData);

            // Save snap token
            $this->pesananModel->update($orderId, [
                'snap_token' => $snapToken,
                'transaction_id' => $midtransOrderId,
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            // Clear session
            session()->remove(['cart', 'voucher_id', 'voucher_code', 'discount']);
            $cartModel = new \App\Models\CartModel();
            $cartModel->where('user_id', session()->get('id'))->delete();

            return $this->response->setJSON([
                'success' => true,
                'snap_token' => $snapToken,
                'order_id' => $orderId
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Checkout Error: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Normalize Indonesian phone numbers to +62... format
     */
    private function normalizePhone(string $phone): string
    {
        $phone = preg_replace('/\s+/', '', $phone); // remove spaces
        $phone = preg_replace('/[^0-9\+]/', '', $phone); // remove non-numeric except +

        if (strpos($phone, '+') === 0) {
            return $phone;
        }

        // if starts with 0 -> replace with +62
        if (strpos($phone, '0') === 0) {
            return '+62' . substr($phone, 1);
        }

        // if starts with 62 already without +, add +
        if (strpos($phone, '62') === 0) {
            return '+' . $phone;
        }

        // fallback, return as-is
        return $phone;
    }

    /**
     * AJAX check voucher (kept as-is with minor safety)
     */
    public function checkVoucher()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Invalid request']);
        }

        $voucherCode = $this->request->getPost('voucher_code');
        $subtotal = (int)$this->request->getPost('subtotal');

        $voucherModel = new \App\Models\VoucherModel();
        $voucher = $voucherModel->where('code', $voucherCode)->first();

        if (!$voucher) {
            return $this->response->setJSON(['success' => false, 'message' => 'Kode voucher tidak valid']);
        }

        if (!$voucher['is_active']) {
            return $this->response->setJSON(['success' => false, 'message' => 'Voucher tidak aktif']);
        }

        $now = date('Y-m-d H:i:s');
        if ($voucher['valid_from'] > $now || $voucher['valid_until'] < $now) {
            return $this->response->setJSON(['success' => false, 'message' => 'Voucher sudah kadaluarsa atau belum aktif']);
        }

        if ($voucher['usage_limit'] > 0 && $voucher['used_count'] >= $voucher['usage_limit']) {
            return $this->response->setJSON(['success' => false, 'message' => 'Voucher sudah mencapai batas penggunaan']);
        }

        if ($voucher['minimum_purchase'] > 0 && $subtotal < $voucher['minimum_purchase']) {
            return $this->response->setJSON(['success' => false, 'message' => 'Total belanja Anda belum mencapai minimum pembelian untuk voucher ini (Rp ' . number_format($voucher['minimum_purchase'], 0, ',', '.') . ')']);
        }

        $discount = 0;
        if ($voucher['discount_type'] === 'percentage') {
            $discount = ($subtotal * $voucher['discount_value']) / 100;
            if ($voucher['max_discount'] > 0 && $discount > $voucher['max_discount']) {
                $discount = $voucher['max_discount'];
            }
        } else {
            $discount = $voucher['discount_value'];
        }

        return $this->response->setJSON([
            'success' => true,
            'voucher_id' => $voucher['id'],
            'discount' => (int)$discount
        ]);
    }

    /**
     * Handle Midtrans notification (kept mostly same with minor safety)
     */
    public function notification()
    {
        try {
            $notif = new Notification();

            $transaction = $notif->transaction_status;
            $type = $notif->payment_type;
            $orderId = $notif->order_id;
            $fraud = $notif->fraud_status;

            // Extract order ID from transaction order_id
            preg_match('/ORDER-(\d+)-/', $orderId, $matches);
            $pesananId = $matches[1] ?? null;

            if (!$pesananId) {
                log_message('error', 'Invalid order ID format: ' . $orderId);
                return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid order ID']);
            }

            $order = $this->pesananModel->find($pesananId);

            if (!$order) {
                log_message('error', 'Order not found: ' . $pesananId);
                return $this->response->setJSON(['status' => 'error', 'message' => 'Order not found']);
            }

            // Handle transaction status
            $paymentStatus = 'pending';
            $orderStatus = $order['status'];

            if ($transaction == 'capture') {
                if ($type == 'credit_card') {
                    if ($fraud == 'challenge') {
                        $paymentStatus = 'pending';
                    } else {
                        $paymentStatus = 'paid';
                        $orderStatus = 'processing';
                    }
                }
            } elseif ($transaction == 'settlement') {
                $paymentStatus = 'paid';
                $orderStatus = 'processing';
            } elseif ($transaction == 'pending') {
                $paymentStatus = 'pending';
            } elseif ($transaction == 'deny') {
                $paymentStatus = 'failed';
            } elseif ($transaction == 'expire') {
                $paymentStatus = 'expired';
                $orderStatus = 'cancelled'; // Set order status to cancelled when payment expires
            } elseif ($transaction == 'cancel') {
                $paymentStatus = 'failed';
                $orderStatus = 'cancelled';
            }

            // Update order
            $updateData = [
                'payment_status' => $paymentStatus,
                'payment_type' => $type,
                'status' => $orderStatus,
                'updated_at' => date('Y-m-d H:i:s')
            ];

            if ($paymentStatus === 'paid' && empty($order['paid_at'])) {
                $updateData['paid_at'] = date('Y-m-d H:i:s');
            }

            $this->pesananModel->update($pesananId, $updateData);

            // Add status history
            $statusHistoryModel = new \App\Models\OrderStatusHistoryModel();
            $statusHistoryModel->addStatus(
                $pesananId,
                $orderStatus,
                'Payment ' . $paymentStatus . ' via ' . $type,
                null
            );

            return $this->response->setJSON(['status' => 'success', 'message' => 'Payment notification processed']);
        } catch (\Exception $e) {
            log_message('error', 'Payment notification error: ' . $e->getMessage());
            return $this->response->setJSON(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function finish()
    {
        $orderId = $this->request->getGet('order_id');
        $statusCode = $this->request->getGet('status_code');
        $transactionStatus = $this->request->getGet('transaction_status');

        preg_match('/ORDER-(\d+)-/', $orderId, $matches);
        $pesananId = $matches[1] ?? null;

        if ($pesananId) {
            $order = $this->pesananModel->find($pesananId);

            if (!$order) {
                return redirect()->to('/orders')->with('error', 'Pesanan tidak ditemukan.');
            }

            $data = [
                'title' => 'Pembayaran Selesai',
                'order' => $order,
                'statusCode' => $statusCode,
                'transactionStatus' => $transactionStatus
            ];

            return view('payment/finish', $data);
        }

        return redirect()->to('/orders')->with('error', 'Pesanan tidak ditemukan.');
    }

    public function unfinish()
    {
        return redirect()->to('/orders')->with('warning', 'Pembayaran belum selesai. Silakan coba lagi.');
    }

    public function error()
    {
        return redirect()->to('/orders')->with('error', 'Terjadi kesalahan saat memproses pembayaran.');
    }
}
