<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdatePesananItemsTable extends Migration
{
    public function up()
    {
        $db = \Config\Database::connect();
        $fields = $db->getFieldNames('pesanan_items');
        
        // Rename quantity to jumlah
        if (in_array('quantity', $fields) && !in_array('jumlah', $fields)) {
            $this->forge->modifyColumn('pesanan_items', [
                'quantity' => [
                    'name' => 'jumlah',
                    'type' => 'INT',
                    'constraint' => 11,
                ],
            ]);
        }
        
        // Add subtotal if not exists
        if (!in_array('subtotal', $fields)) {
            $this->forge->addColumn('pesanan_items', [
                'subtotal' => [
                    'type'       => 'DECIMAL',
                    'constraint' => '15,2',
                    'after'      => 'harga',
                ],
            ]);
        }
        
        // Add gambar if not exists
        if (!in_array('gambar', $fields)) {
            $this->forge->addColumn('pesanan_items', [
                'gambar' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 255,
                    'null'       => true,
                    'after'      => 'subtotal',
                ],
            ]);
        }
    }

    public function down()
    {
        // Rename back
        $this->forge->modifyColumn('pesanan_items', [
            'jumlah' => [
                'name' => 'quantity',
                'type' => 'INT',
                'constraint' => 11,
            ],
        ]);
        
        $this->forge->dropColumn('pesanan_items', ['subtotal', 'gambar']);
    }
}
