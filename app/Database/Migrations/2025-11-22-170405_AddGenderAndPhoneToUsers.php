<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddGenderAndPhoneToUsers extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users', [
            'jenis_kelamin' => [
                'type'       => 'ENUM',
                'constraint' => ['Laki-laki', 'Perempuan'],
                'null'       => true,
                'after'      => 'tanggal_lahir',
            ],
            'nomor_telepon' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => true,
                'after' => 'jenis_kelamin',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('users', ['jenis_kelamin', 'nomor_telepon']);
    }
}