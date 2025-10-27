<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdukModel extends Model
{
    protected $table = 'produk';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'nama', 
        'deskripsi', 
        'harga', 
        'stok', 
        'gambar', 
        'kategori', 
        'tanggal_dibuat'
    ];
    public $useTimestamps = false; // karena kamu pakai kolom tanggal_dibuat manual
}
