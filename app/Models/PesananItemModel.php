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
        'jumlah',
        'harga',
        'subtotal',
        'gambar'
    ];
    protected $useTimestamps = false;
    
    // Get order items with product details
    public function getOrderItems($pesananId)
    {
        return $this->select('pesanan_items.*, produk.gambar')
                    ->join('produk', 'produk.id = pesanan_items.produk_id', 'left')
                    ->where('pesanan_items.pesanan_id', $pesananId)
                    ->findAll();
    }
}