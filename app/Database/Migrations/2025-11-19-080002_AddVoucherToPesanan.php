<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddVoucherToPesanan extends Migration
{
    public function up()
    {
        $fields = [
            'voucher_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
                'after'      => 'total_harga',
            ],
            'voucher_code' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
                'after'      => 'voucher_id',
            ],
            'discount_amount' => [
                'type'       => 'DECIMAL',
                'constraint' => '15,2',
                'default'    => 0,
                'after'      => 'voucher_code',
            ],
            'final_amount' => [
                'type'       => 'DECIMAL',
                'constraint' => '15,2',
                'null'       => true,
                'after'      => 'discount_amount',
            ],
        ];

        $this->forge->addColumn('pesanan', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('pesanan', [
            'voucher_id',
            'voucher_code',
            'discount_amount',
            'final_amount'
        ]);
    }
}
