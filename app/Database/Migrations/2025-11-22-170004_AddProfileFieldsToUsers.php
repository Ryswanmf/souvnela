<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddProfileFieldsToUsers extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users', [
            'foto_profil' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
                'after'      => 'email',
            ],
            'alamat' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'foto_profil',
            ],
            'tanggal_lahir' => [
                'type' => 'DATE',
                'null' => true,
                'after' => 'alamat',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('users', ['foto_profil', 'alamat', 'tanggal_lahir']);
    }
}