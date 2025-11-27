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
        'tanggal_dibuat',
        'is_unggulan'
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'tanggal_dibuat';
    protected $updatedField  = ''; // Disable updated_at if not exists
}
