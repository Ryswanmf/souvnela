<?php

namespace App\Controllers;

use App\Models\ProdukModel;

class Cart extends BaseController
{
    protected $produkModel;

    public function __construct()
    {
        $this->produkModel = new ProdukModel();
        helper(['form', 'number']);
    }

    public function add()
    {
        if (!session()->get('isLoggedIn')) {
            session()->set('redirect_url', current_url());
            return redirect()->to('/login')->with('error', 'Anda harus login untuk menambahkan produk ke keranjang.');
        }

        $cart = session()->get('cart') ?? [];
        $productId = $this->request->getPost('product_id');
        $quantity = (int)$this->request->getPost('quantity') ?: 1;

        $product = $this->produkModel->find($productId);

        if (!$product) {
            return redirect()->back()->with('error', 'Produk tidak ditemukan.');
        }

        // Cek apakah produk sudah ada di keranjang
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
        } else {
            $cart[$productId] = [
                'id'       => $product['id'],
                'nama'     => $product['nama'],
                'harga'    => $product['harga'],
                'gambar'   => $product['gambar'],
                'quantity' => $quantity,
            ];
        }

        session()->set('cart', $cart);

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    public function index()
    {
        $cart = session()->get('cart') ?? [];
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['harga'] * $item['quantity'];
        }

        return view('cart/index', ['cart' => $cart, 'total' => $total, 'title' => 'Keranjang Belanja']);
    }

    public function update()
    {
        $cart = session()->get('cart') ?? [];
        $productId = $this->request->getPost('product_id');
        $quantity = (int)$this->request->getPost('quantity');

        if (isset($cart[$productId])) {
            if ($quantity > 0) {
                $cart[$productId]['quantity'] = $quantity;
            } else {
                unset($cart[$productId]); // Hapus jika quantity 0 atau kurang
            }
        }

        session()->set('cart', $cart);
        return redirect()->to('/cart');
    }

    public function remove($productId)
    {
        $cart = session()->get('cart') ?? [];
        if (isset($cart[$productId])) {
            unset($cart[$productId]);
        }

        session()->set('cart', $cart);
        return redirect()->to('/cart')->with('success', 'Produk berhasil dihapus dari keranjang.');
    }

    public function placeOrder()
    {
        // Validasi dasar
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Anda harus login untuk membuat pesanan.');
        }
        $cart = session()->get('cart') ?? [];
        if (empty($cart)) {
            return redirect()->to('/'); // Redirect ke home jika keranjang kosong
        }

        $pesananModel = new \App\Models\PesananModel();
        $produkModel = new \App\Models\ProdukModel();

        // Hitung total
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['harga'] * $item['quantity'];
        }

        // Siapkan data pesanan
        $orderData = [
            'kode'      => 'ORD-' . strtoupper(uniqid()),
            'pelanggan' => session()->get('nama_lengkap'),
            'total'     => $total,
            'status'    => 'Baru',
            'created_at'   => date('Y-m-d H:i:s')
        ];

        // Mulai transaksi database
        $db = \Config\Database::connect();
        $db->transStart();

        // 1. Simpan data pesanan
        $pesananModel->save($orderData);

        // 2. Kurangi stok produk
        foreach ($cart as $item) {
            $produkModel->where('id', $item['id'])->set('stok', 'stok - ' . $item['quantity'], false)->update();
        }

        // Selesaikan transaksi
        $db->transComplete();

        if ($db->transStatus() === false) {
            // Jika transaksi gagal, kembalikan dengan error
            return redirect()->to('/checkout')->with('error', 'Gagal memproses pesanan, silakan coba lagi.');
        }

        // 3. Kosongkan keranjang
        session()->remove('cart');

        // Redirect ke halaman sukses
        return redirect()->to('/order-success');
    }

    public function success()
    {
        return view('order_success', ['title' => 'Pesanan Berhasil']);
    }
}
