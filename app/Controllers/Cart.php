<?php

namespace App\Controllers;

use App\Models\ProdukModel;
use App\Models\CartModel;

class Cart extends BaseController
{
    protected $request;
    protected $response;
    protected $produkModel;
    protected $cartModel;

    public function __construct()
    {
        $this->produkModel = new ProdukModel();
        $this->cartModel = new CartModel();
        helper(['form', 'number']);
    }

    public function add()
    {
        if (!session()->get('isLoggedIn')) {
            session()->set('redirect_url', current_url());

            // Check if AJAX request
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Anda harus login untuk menambahkan produk ke keranjang.',
                    'redirect' => '/login'
                ]);
            }

            return redirect()->to('/login')->with('error', 'Anda harus login untuk menambahkan produk ke keranjang.');
        }

        $cart = session()->get('cart') ?? [];
        $productId = $this->request->getPost('product_id');
        $quantity = (int)$this->request->getPost('quantity') ?: 1;

        $product = $this->produkModel->find($productId);

        if (!$product) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Produk tidak ditemukan.'
                ]);
            }
            return redirect()->back()->with('error', 'Produk tidak ditemukan.');
        }

        // Check stock availability
        $currentQuantityInCart = isset($cart[$productId]) ? $cart[$productId]['quantity'] : 0;
        $newTotalQuantity = $currentQuantityInCart + $quantity;

        if ($newTotalQuantity > $product['stok']) {
            $message = 'Stok produk tidak mencukupi. Stok tersedia: ' . $product['stok'];
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => $message
                ]);
            }
            return redirect()->back()->with('error', $message);
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

        // Sync to DB if logged in
        if (session()->get('isLoggedIn')) {
            $this->cartModel->where('user_id', session()->get('id'))->where('produk_id', $productId)->delete();
            $this->cartModel->insert([
                'user_id' => session()->get('id'),
                'produk_id' => $productId,
                'quantity' => $cart[$productId]['quantity']
            ]);
        }

        // Calculate total items
        $totalItems = 0;
        foreach ($cart as $item) {
            $totalItems += $item['quantity'];
        }

        // If AJAX request, return JSON
        if ($this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Produk berhasil ditambahkan ke keranjang!',
                'totalItems' => $totalItems,
                'productName' => $product['nama']
            ]);
        }

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    public function index()
    {
        if (!session()->get('isLoggedIn')) {
            session()->set('redirect_url', current_url());
            return redirect()->to('/login')->with('error', 'Anda harus login untuk melihat keranjang belanja.');
        }

        $cart = session()->get('cart') ?? [];
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['harga'] * $item['quantity'];
        }

        return view('cart/index', ['cart' => $cart, 'total' => $total, 'title' => 'Keranjang Belanja']);
    }

    public function update()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Anda harus login untuk mengupdate keranjang.');
        }

        $cart = session()->get('cart') ?? [];
        $productId = $this->request->getPost('product_id');
        $quantity = (int)$this->request->getPost('quantity');

        if (isset($cart[$productId])) {
            if ($quantity > 0) {
                // Check stock availability
                $product = $this->produkModel->find($productId);
                if ($product && $quantity > $product['stok']) {
                    return redirect()->to('/cart')->with('error', 'Stok produk tidak mencukupi. Stok tersedia: ' . $product['stok']);
                }
                $cart[$productId]['quantity'] = $quantity;
            } else {
                unset($cart[$productId]); // Hapus jika quantity 0 atau kurang
            }
        }

        session()->set('cart', $cart);

        // Sync to DB if logged in
        if (session()->get('isLoggedIn')) {
            if ($quantity > 0) {
                $this->cartModel->where('user_id', session()->get('id'))->where('produk_id', $productId)->delete();
                $this->cartModel->insert([
                    'user_id' => session()->get('id'),
                    'produk_id' => $productId,
                    'quantity' => $quantity
                ]);
            } else {
                $this->cartModel->where('user_id', session()->get('id'))->where('produk_id', $productId)->delete();
            }
        }

        return redirect()->to('/cart');
    }

    public function remove($productId)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Anda harus login untuk menghapus item dari keranjang.');
        }

        $cart = session()->get('cart') ?? [];
        if (isset($cart[$productId])) {
            unset($cart[$productId]);
        }

        session()->set('cart', $cart);

        // Sync to DB if logged in
        if (session()->get('isLoggedIn')) {
            $this->cartModel->where('user_id', session()->get('id'))->where('produk_id', $productId)->delete();
        }

        return redirect()->to('/cart')->with('success', 'Produk berhasil dihapus dari keranjang.');
    }

    public function checkout()
    {
        if (!session()->get('isLoggedIn')) {
            session()->set('redirect_url', base_url('cart/checkout'));
            return redirect()->to('/login')->with('error', 'Anda harus login untuk melanjutkan ke checkout.');
        }

        $cart = session()->get('cart') ?? [];
        if (empty($cart)) {
            return redirect()->to('/cart')->with('error', 'Keranjang Anda kosong.');
        }

        // Transform cart data for view
        $cart_items = [];
        $total = 0;
        foreach ($cart as $item) {
            $cart_items[] = [
                'id' => $item['id'],
                'nama_produk' => $item['nama'],
                'harga' => $item['harga'],
                'jumlah' => $item['quantity'],
                'gambar' => $item['gambar']
            ];
            $total += $item['harga'] * $item['quantity'];
        }

        // Get Midtrans Client Key safely
        $midtransClientKey = getenv('MIDTRANS_CLIENT_KEY');
        if (!$midtransClientKey && isset($_ENV['MIDTRANS_CLIENT_KEY'])) {
            $midtransClientKey = $_ENV['MIDTRANS_CLIENT_KEY'];
        }
        if (!$midtransClientKey && isset($_SERVER['MIDTRANS_CLIENT_KEY'])) {
            $midtransClientKey = $_SERVER['MIDTRANS_CLIENT_KEY'];
        }

        $data = [
            'cart_items' => $cart_items,
            'total' => $total,
            'title' => 'Checkout',
            'midtransClientKey' => $midtransClientKey
        ];

        return view('cart/checkout', $data);
    }

    public function applyVoucher()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Anda harus login untuk menggunakan voucher.');
        }

        $voucherCode = $this->request->getPost('voucher_code');
        $cart = session()->get('cart') ?? [];

        if (empty($cart)) {
            return redirect()->back()->with('error', 'Keranjang Anda kosong.');
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['harga'] * $item['quantity'];
        }

        $voucherModel = new \App\Models\VoucherModel();
        $voucher = $voucherModel->where('code', $voucherCode)->first();

        if (!$voucher) {
            return redirect()->back()->with('error', 'Kode voucher tidak valid.');
        }

        // Check if voucher is active
        if (!$voucher['is_active']) {
            return redirect()->back()->with('error', 'Voucher tidak aktif.');
        }

        // Check expiry
        $now = date('Y-m-d H:i:s');
        if ($voucher['valid_from'] > $now || $voucher['valid_until'] < $now) {
            return redirect()->back()->with('error', 'Voucher sudah kadaluarsa atau belum aktif.');
        }

        // Check usage limit
        if ($voucher['usage_limit'] > 0 && $voucher['used_count'] >= $voucher['usage_limit']) {
            return redirect()->back()->with('error', 'Voucher sudah mencapai batas penggunaan.');
        }

        // Check minimum purchase
        if ($voucher['minimum_purchase'] > 0 && $total < $voucher['minimum_purchase']) {
            return redirect()->back()->with('error', 'Total belanja Anda belum mencapai minimum pembelian untuk voucher ini (Rp ' . number_format($voucher['minimum_purchase'], 0, ',', '.') . ')');
        }

        // Calculate discount
        $discount = 0;
        if ($voucher['discount_type'] === 'percentage') {
            $discount = ($total * $voucher['discount_value']) / 100;
            if ($voucher['max_discount'] > 0 && $discount > $voucher['max_discount']) {
                $discount = $voucher['max_discount'];
            }
        } else {
            $discount = $voucher['discount_value'];
        }

        // Save to session
        session()->set([
            'voucher_id' => $voucher['id'],
            'voucher_code' => $voucherCode,
            'discount' => $discount
        ]);

        return redirect()->back()->with('success', 'Voucher berhasil diterapkan! Anda mendapat diskon Rp ' . number_format($discount, 0, ',', '.'));
    }

    public function removeVoucher()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Anda harus login untuk menghapus voucher.');
        }

        session()->remove(['voucher_id', 'voucher_code', 'discount']);
        return redirect()->back()->with('success', 'Voucher berhasil dihapus.');
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
        $pesananItemModel = new \App\Models\PesananItemModel();
        $produkModel = new ProdukModel();
        $statusHistoryModel = new \App\Models\OrderStatusHistoryModel();

        // Hitung total
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['harga'] * $item['quantity'];
        }

        // Apply discount if voucher exists
        $discount = session()->get('discount') ?? 0;
        $finalTotal = $total - $discount;

        // Get form data
        $nama = $this->request->getPost('nama_penerima') ?? session()->get('nama_lengkap');
        $alamat = $this->request->getPost('alamat_lengkap');
        $telepon = $this->request->getPost('no_telepon');
        $email = $this->request->getPost('email') ?? session()->get('email');
        $catatan = $this->request->getPost('catatan');

        // Siapkan data pesanan
        $orderData = [
            'user_id'        => session()->get('id'),
            'nama_penerima'  => $nama,
            'alamat_lengkap' => $alamat,
            'no_telepon'     => $telepon,
            'email'          => $email,
            'catatan'        => $catatan,
            'total_harga'    => $finalTotal,
            'status'         => 'pending',
            'payment_status' => 'pending',
        ];

        // Mulai transaksi database
        $db = \Config\Database::connect();
        $db->transStart();

        // 1. Simpan data pesanan utama
        $pesananModel->save($orderData);
        $pesananId = $pesananModel->getInsertID();

        // 2. Simpan item-item pesanan
        foreach ($cart as $item) {
            $itemData = [
                'pesanan_id'  => $pesananId,
                'produk_id'   => $item['id'],
                'nama_produk' => $item['nama'],
                'jumlah'      => $item['quantity'],
                'harga'       => $item['harga'],
                'subtotal'    => $item['harga'] * $item['quantity'],
                'gambar'      => $item['gambar'],
            ];
            $pesananItemModel->save($itemData);

            // 3. Kurangi stok produk
            $produkModel->where('id', $item['id'])->set('stok', 'stok - ' . $item['quantity'], false)->update();
        }

        // 4. Save voucher usage if exists
        if (session()->get('voucher_id')) {
            $voucherUsageModel = new \App\Models\VoucherUsageModel();
            $voucherUsageModel->save([
                'voucher_id' => session()->get('voucher_id'),
                'user_id' => session()->get('id'),
                'pesanan_id' => $pesananId,
                'discount_amount' => $discount,
                'used_at' => date('Y-m-d H:i:s')
            ]);

            // Update voucher used count
            $voucherModel = new \App\Models\VoucherModel();
            $voucherModel->where('id', session()->get('voucher_id'))
                         ->set('used_count', 'used_count + 1', false)
                         ->update();
        }

        // 5. Create initial status history
        $statusHistoryModel->addStatus($pesananId, 'pending', 'Pesanan berhasil dibuat', session()->get('id'));

        // Selesaikan transaksi
        $db->transComplete();

        if ($db->transStatus() === false) {
            // Jika transaksi gagal, kembalikan dengan error
            return redirect()->to('/checkout')->with('error', 'Gagal memproses pesanan, silakan coba lagi.');
        }

        // 6. Kosongkan keranjang dan voucher
        session()->remove(['cart', 'voucher_id', 'voucher_code', 'discount']);

        // Clear DB cart
        if (session()->get('isLoggedIn')) {
            $this->cartModel->where('user_id', session()->get('id'))->delete();
        }

        // Redirect ke halaman pembayaran
        return redirect()->to('/payment/process/' . $pesananId);
    }

    public function success()
    {
        return view('order_success', ['title' => 'Pesanan Berhasil']);
    }
}
