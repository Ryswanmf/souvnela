<?php
// seed_info_pages.php

// Config
$host = 'localhost';
$db   = 'souvnela';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$envFile = __DIR__ . '/.env';
if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        list($name, $value) = explode('=', $line, 2);
        if (trim($name) == 'database.default.database') $db = trim($value);
    }
}

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=$charset", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pages = [
        [
            'slug' => 'kebijakan-privasi',
            'title' => 'Kebijakan Privasi',
            'content' => '
                <h3>Pendahuluan</h3>
                <p>Selamat datang di Souvnela. Kami menghargai privasi Anda dan berkomitmen untuk melindungi data pribadi Anda. Kebijakan Privasi ini menjelaskan bagaimana kami mengumpulkan, menggunakan, dan menjaga informasi Anda saat Anda mengunjungi website kami atau melakukan pembelian.</p>

                <h3>Informasi yang Kami Kumpulkan</h3>
                <p>Kami mengumpulkan informasi yang Anda berikan secara langsung kepada kami, seperti:</p>
                <ul>
                    <li>Nama lengkap</li>
                    <li>Alamat email</li>
                    <li>Nomor telepon</li>
                    <li>Alamat pengiriman</li>
                    <li>Informasi pembayaran (diproses secara aman oleh pihak ketiga)</li>
                </ul>

                <h3>Bagaimana Kami Menggunakan Informasi Anda</h3>
                <p>Informasi yang kami kumpulkan digunakan untuk:</p>
                <ul>
                    <li>Memproses dan mengirimkan pesanan Anda.</li>
                    <li>Mengirimkan notifikasi status pesanan.</li>
                    <li>Menanggapi pertanyaan atau keluhan pelanggan.</li>
                    <li>Meningkatkan layanan dan pengalaman berbelanja Anda.</li>
                </ul>

                <h3>Keamanan Data</h3>
                <p>Kami menerapkan langkah-langkah keamanan teknis untuk melindungi data pribadi Anda dari akses yang tidak sah, kehilangan, atau penyalahgunaan. Kami tidak akan menjual atau menyewakan data pribadi Anda kepada pihak ketiga.</p>

                <h3>Hubungi Kami</h3>
                <p>Jika Anda memiliki pertanyaan tentang Kebijakan Privasi ini, silakan hubungi kami melalui halaman Kontak.</p>
            '
        ],
        [
            'slug' => 'syarat-ketentuan',
            'title' => 'Syarat & Ketentuan',
            'content' => '
                <h3>Ketentuan Umum</h3>
                <p>Dengan mengakses dan menggunakan website Souvnela, Anda setuju untuk tunduk pada syarat dan ketentuan ini. Kami berhak mengubah syarat dan ketentuan ini sewaktu-waktu tanpa pemberitahuan sebelumnya.</p>

                <h3>Pemesanan</h3>
                <p>Semua pesanan tergantung pada ketersediaan stok. Kami berhak membatalkan pesanan jika produk tidak tersedia atau terdapat kesalahan harga.</p>

                <h3>Pembayaran</h3>
                <p>Pembayaran dapat dilakukan melalui metode yang tersedia di website kami (Transfer Bank, E-Wallet, QRIS). Pesanan akan diproses setelah pembayaran dikonfirmasi.</p>

                <h3>Pengembalian Barang</h3>
                <p>Barang yang sudah dibeli tidak dapat ditukar atau dikembalikan, kecuali terdapat cacat produksi atau kesalahan pengiriman dari pihak kami. Komplain wajib menyertakan video unboxing.</p>
            '
        ],
        [
            'slug' => 'pembayaran-pengiriman',
            'title' => 'Pembayaran & Pengiriman',
            'content' => '
                <h3>Metode Pembayaran</h3>
                <p>Kami bekerja sama dengan Midtrans untuk menyediakan berbagai metode pembayaran yang aman dan mudah, termasuk:</p>
                <ul>
                    <li>Transfer Bank (BCA, BNI, BRI, Mandiri)</li>
                    <li>E-Wallet (GoPay, OVO, ShopeePay)</li>
                    <li>QRIS</li>
                    <li>Kartu Kredit / Debit</li>
                </ul>

                <h3>Pengiriman</h3>
                <p>Kami menggunakan jasa ekspedisi terpercaya (JNE, J&T, SiCepat) untuk mengirimkan pesanan Anda ke seluruh Indonesia.</p>
                <p>Estimasi waktu pengiriman:</p>
                <ul>
                    <li><strong>Reguler:</strong> 3-5 hari kerja (Jawa & Sumatera), 5-7 hari kerja (Luar Jawa)</li>
                    <li><strong>Express:</strong> 1-2 hari kerja</li>
                    <li><strong>Same Day:</strong> Khusus area Bandar Lampung (pesanan sebelum jam 12.00)</li>
                </ul>
                <p>Nomor resi akan dikirimkan melalui email dan dapat dicek di menu "Pesanan Saya".</p>
            '
        ],
        [
            'slug' => 'konfirmasi-pembayaran',
            'title' => 'Konfirmasi Pembayaran',
            'content' => '
                <h3>Otomatis</h3>
                <p>Jika Anda membayar melalui Virtual Account, E-Wallet, atau QRIS, pembayaran akan terkonfirmasi secara <strong>otomatis</strong> oleh sistem dalam beberapa menit. Anda tidak perlu mengirimkan bukti transfer manual.</p>

                <h3>Cek Status</h3>
                <p>Anda dapat mengecek status pembayaran Anda di menu <a href="/orders">Pesanan Saya</a>. Status akan berubah menjadi "Proses" atau "Sedang Dikemas" setelah pembayaran berhasil.</p>

                <h3>Masalah Pembayaran?</h3>
                <p>Jika status pembayaran Anda belum berubah setelah 1x24 jam, silakan hubungi Customer Service kami melalui WhatsApp dengan menyertakan Nomor Pesanan dan Bukti Pembayaran.</p>
            '
        ]
    ];

    $stmt = $pdo->prepare("SELECT id FROM info_pages WHERE slug = ?");
    $insertStmt = $pdo->prepare("INSERT INTO info_pages (slug, title, content, created_at, updated_at) VALUES (?, ?, ?, NOW(), NOW())");
    $updateStmt = $pdo->prepare("UPDATE info_pages SET title = ?, content = ?, updated_at = NOW() WHERE slug = ?");

    foreach ($pages as $page) {
        $stmt->execute([$page['slug']]);
        $existing = $stmt->fetch();

        if ($existing) {
            $updateStmt->execute([$page['title'], $page['content'], $page['slug']]);
            echo "Updated: " . $page['title'] . "\n";
        } else {
            $insertStmt->execute([$page['slug'], $page['title'], $page['content']]);
            echo "Inserted: " . $page['title'] . "\n";
        }
    }

} catch (\PDOException $e) {
    echo "Database Error: " . $e->getMessage();
}
