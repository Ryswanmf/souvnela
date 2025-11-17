<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFeaturedToProdukTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('produk', [
            'is_unggulan' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
                'null'       => false,
                'after'      => 'gambar',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('produk', 'is_unggulan');
    }
}