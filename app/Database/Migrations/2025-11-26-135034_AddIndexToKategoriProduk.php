<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddIndexToKategoriProduk extends Migration
{
    public function up()
    {
        $this->forge->addKey('kategori', false, false, 'kategori_index');
        $this->forge->processIndexes('produk');
    }

    public function down()
    {
        $this->forge->dropKey('produk', 'kategori_index');
    }
}
