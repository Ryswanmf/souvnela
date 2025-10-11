<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Pesanan extends BaseController
{
    public function index()
    {
        $pesanan = [
            ['id' => 1, 'kode' => 'ORD-001', 'pelanggan' => 'Andi', 'tanggal' => '2025-10-11', 'total' => 250000, 'status' => 'Proses'],
            ['id' => 2, 'kode' => 'ORD-002', 'pelanggan' => 'Budi', 'tanggal' => '2025-10-10', 'total' => 480000, 'status' => 'Selesai'],
            ['id' => 3, 'kode' => 'ORD-003', 'pelanggan' => 'Citra', 'tanggal' => '2025-10-09', 'total' => 120000, 'status' => 'Baru'],
        ];

        return view('admin/pesanan', compact('pesanan'));
    }
}
