<?php

namespace App\Models;

use CodeIgniter\Model;

class PesananItemModel extends Model
{
    protected $table            = 'pesanan_items';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'pesanan_id',
        'produk_id',
        'nama_produk',
        'quantity',
        'harga'
    ];
    protected $useTimestamps = false;
}