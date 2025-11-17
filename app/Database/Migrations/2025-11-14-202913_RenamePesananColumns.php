<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RenamePesananColumns extends Migration
{
    public function up()
    {
        $this->forge->modifyColumn('pesanan', [
            'kode_pesanan' => [
                'name' => 'kode',
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'nama_pelanggan' => [
                'name' => 'pelanggan',
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
        ]);
    }

    public function down()
    {
        // Revert the changes
        $this->forge->modifyColumn('pesanan', [
            'kode' => [
                'name' => 'kode_pesanan',
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'pelanggan' => [
                'name' => 'nama_pelanggan',
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
        ]);
    }
}