<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class InfoPageSeeder extends Seeder
{
    public function run()
    {
        // Update Kebijakan Privasi
        $this->db->table('info_pages')->where('slug', 'kebijakan-privasi')->update([
            'content' => '
                <h2>Kebijakan Privasi untuk Souvnela</h2>
                <p>Di Souvnela, dapat diakses dari souvnela.com, salah satu prioritas utama kami adalah privasi pengunjung kami. Dokumen Kebijakan Privasi ini berisi jenis informasi yang dikumpulkan dan dicatat oleh Souvnela dan bagaimana kami menggunakannya.</p>
                
                <h3>Informasi yang Kami Kumpulkan</h3>
                <p>Informasi pribadi yang Anda diminta untuk berikan, dan alasan mengapa Anda diminta untuk menyediakannya, akan dijelaskan kepada Anda pada saat kami meminta Anda untuk memberikan informasi pribadi Anda.</p>
                <p>Jika Anda menghubungi kami secara langsung, kami mungkin menerima informasi tambahan tentang Anda seperti nama, alamat email, nomor telepon, isi pesan dan/atau lampiran yang mungkin Anda kirimkan kepada kami, dan informasi lain yang mungkin Anda pilih untuk diberikan.</p>
                <p>Saat Anda mendaftar untuk sebuah Akun, kami mungkin meminta informasi kontak Anda, termasuk item seperti nama, nama perusahaan, alamat, alamat email, dan nomor telepon.</p>

                <h3>Data Formulir Website</h3>
                <p>Ketika Anda mengisi formulir di situs web kami (misalnya, formulir kontak, pendaftaran, atau pemesanan), kami mengumpulkan informasi yang Anda berikan langsung dalam formulir tersebut. Informasi ini dapat mencakup, namun tidak terbatas pada, nama, alamat email, nomor telepon, alamat pengiriman, dan detail lain yang relevan dengan tujuan formulir.</p>
                <p>Kami menggunakan data ini untuk memproses permintaan Anda, memberikan layanan yang Anda minta, dan berkomunikasi dengan Anda terkait interaksi Anda dengan situs web kami.</p>

                <h3>Bagaimana Kami Menggunakan Informasi Anda</h3>
                <p>Kami menggunakan informasi yang kami kumpulkan dengan berbagai cara, termasuk untuk:</p>
                <ul>
                    <li>Menyediakan, mengoperasikan, dan memelihara situs web kami</li>
                    <li>Meningkatkan, mempersonalisasi, dan memperluas situs web kami</li>
                    <li>Memahami dan menganalisis bagaimana Anda menggunakan situs web kami</li>
                    <li>Mengembangkan produk, layanan, fitur, dan fungsionalitas baru</li>
                    <li>Berkomunikasi dengan Anda, baik secara langsung atau melalui salah satu mitra kami, termasuk untuk layanan pelanggan, untuk memberi Anda pembaruan dan informasi lain yang berkaitan dengan situs web, dan untuk tujuan pemasaran dan promosi</li>
                    <li>Mengirimi Anda email</li>
                    <li>Menemukan dan mencegah penipuan</li>
                </ul>

                <h3>File Log</h3>
                <p>Souvnela mengikuti prosedur standar menggunakan file log. File-file ini mencatat pengunjung ketika mereka mengunjungi situs web. Semua perusahaan hosting melakukan ini dan merupakan bagian dari analitik layanan hosting. Informasi yang dikumpulkan oleh file log termasuk alamat protokol internet (IP), jenis browser, Penyedia Layanan Internet (ISP), stempel tanggal dan waktu, halaman rujukan/keluar, dan mungkin jumlah klik. Ini tidak terkait dengan informasi apa pun yang dapat diidentifikasi secara pribadi. Tujuan dari informasi ini adalah untuk menganalisis tren, mengelola situs, melacak pergerakan pengguna di situs web, dan mengumpulkan informasi demografis.</p>
            '
        ]);

        // Update Syarat & Ketentuan
        $this->db->table('info_pages')->where('slug', 'syarat-ketentuan')->update([
            'content' => '
                <h2>Syarat & Ketentuan untuk Souvnela</h2>
                <p>Selamat datang di Souvnela! Syarat dan ketentuan ini menguraikan aturan dan peraturan untuk penggunaan Situs Web Souvnela, yang terletak di souvnela.com.</p>
                <p>Dengan mengakses situs web ini, kami menganggap Anda menerima syarat dan ketentuan ini. Jangan terus menggunakan Souvnela jika Anda tidak setuju untuk mengambil semua syarat dan ketentuan yang tercantum di halaman ini.</p>

                <h3>Cookie:</h3>
                <p>Situs web ini menggunakan cookie untuk membantu mempersonalisasi pengalaman online Anda. Dengan mengakses Souvnela, Anda setuju untuk menggunakan cookie yang diperlukan.</p>

                <h3>Lisensi:</h3>
                <p>Kecuali dinyatakan lain, Souvnela dan/atau pemberi lisensinya memiliki hak kekayaan intelektual untuk semua materi di Souvnela. Semua hak kekayaan intelektual dilindungi. Anda dapat mengakses ini dari Souvnela untuk penggunaan pribadi Anda sendiri dengan tunduk pada batasan yang ditetapkan dalam syarat dan ketentuan ini.</p>
                <p>Anda tidak boleh:</p>
                <ul>
                    <li>Menerbitkan ulang materi dari Souvnela</li>
                    <li>Menjual, menyewakan, atau mensublisensikan materi dari Souvnela</li>
                    <li>Mereproduksi, menggandakan, atau menyalin materi dari Souvnela</li>
                    <li>Mendistribusikan kembali konten dari Souvnela</li>
                </ul>

                <h3>Hyperlinking ke Konten kami:</h3>
                <p>Organisasi berikut dapat menautkan ke Situs Web kami tanpa persetujuan tertulis sebelumnya:</p>
                <ul>
                    <li>Lembaga pemerintah;</li>
                    <li>Mesin pencari;</li>
                    <li>Organisasi berita;</li>
                </ul>
                <p>Organisasi-organisasi ini dapat menautkan ke beranda kami, ke publikasi, atau ke informasi Situs Web lain selama tautan tersebut: (a) tidak menipu dengan cara apa pun; (b) tidak secara keliru menyiratkan sponsor, dukungan, atau persetujuan dari pihak yang menautkan dan produk dan/atau layanannya; dan (c) sesuai dengan konteks situs pihak yang menautkan.</p>
            '
        ]);
    }
}
