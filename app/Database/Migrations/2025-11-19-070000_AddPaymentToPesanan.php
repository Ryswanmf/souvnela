<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPaymentToPesanan extends Migration
{
    public function up()
    {
        $fields = [
            'payment_type' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
                'after'      => 'status',
            ],
            'payment_status' => [
                'type'       => 'ENUM',
                'constraint' => ['pending', 'paid', 'failed', 'expired'],
                'default'    => 'pending',
                'after'      => 'payment_type',
            ],
            'transaction_id' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'payment_status',
            ],
            'snap_token' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'transaction_id',
            ],
            'paid_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'snap_token',
            ],
        ];

        $this->forge->addColumn('pesanan', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('pesanan', [
            'payment_type',
            'payment_status',
            'transaction_id',
            'snap_token',
            'paid_at'
        ]);
    }
}
