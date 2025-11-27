<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddRatingFieldsToProduk extends Migration
{
    public function up()
    {
        $fields = [
            'average_rating' => [
                'type'       => 'DECIMAL',
                'constraint' => '3,2',
                'default'    => '0.00',
                'after'      => 'stok',
            ],
            'total_reviews' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
                'after'      => 'average_rating',
            ],
        ];
        
        $this->forge->addColumn('produk', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('produk', ['average_rating', 'total_reviews']);
    }
}
