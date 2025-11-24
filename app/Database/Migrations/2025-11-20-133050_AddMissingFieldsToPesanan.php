<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddMissingFieldsToPesanan extends Migration
{
    public function up()
    {
        $fields = [];

        // Check and add ongkir if not exists
        $result = $this->db->query("SHOW COLUMNS FROM pesanan LIKE 'ongkir'")->getRow();
        if (!$result) {
            $fields['ongkir'] = [
                'type'       => 'DECIMAL',
                'constraint' => '15,2',
                'default'    => 0,
                'after'      => 'catatan',
            ];
        }

        // Check and add diskon if not exists
        $result = $this->db->query("SHOW COLUMNS FROM pesanan LIKE 'diskon'")->getRow();
        if (!$result) {
            $fields['diskon'] = [
                'type'       => 'DECIMAL',
                'constraint' => '15,2',
                'default'    => 0,
                'after'      => 'ongkir',
            ];
        }

        // Check and add shipping_method if not exists
        $result = $this->db->query("SHOW COLUMNS FROM pesanan LIKE 'shipping_method'")->getRow();
        if (!$result) {
            $fields['shipping_method'] = [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
                'after'      => 'diskon',
            ];
        }

        if (!empty($fields)) {
            $this->forge->addColumn('pesanan', $fields);
        }
    }

    public function down()
    {
        $this->forge->dropColumn('pesanan', [
            'subtotal',
            'ongkir',
            'diskon',
            'shipping_method'
        ]);
    }
}
