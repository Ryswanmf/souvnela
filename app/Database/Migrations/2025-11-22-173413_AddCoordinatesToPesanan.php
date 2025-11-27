<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddCoordinatesToPesanan extends Migration
{
    public function up()
    {
        $this->forge->addColumn('pesanan', [
            'latitude' => [
                'type' => 'DECIMAL(10, 8)',
                'null' => true,
                'after' => 'alamat_lengkap',
            ],
            'longitude' => [
                'type' => 'DECIMAL(11, 8)',
                'null' => true,
                'after' => 'latitude',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('pesanan', ['latitude', 'longitude']);
    }
}