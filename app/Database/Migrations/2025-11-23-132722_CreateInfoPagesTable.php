<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateInfoPagesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'slug' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'unique'     => true,
            ],
            'title' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'content' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('info_pages');

        // Seed initial data
        $this->db->table('info_pages')->insertBatch([
            [
                'slug' => 'konfirmasi-pembayaran',
                'title' => 'Konfirmasi Pembayaran',
                'content' => 'Halaman ini berisi informasi tentang cara mengkonfirmasi pembayaran.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'slug' => 'pembayaran-pengiriman',
                'title' => 'Pembayaran & Pengiriman',
                'content' => 'Halaman ini berisi informasi tentang metode pembayaran dan pengiriman.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'slug' => 'syarat-ketentuan',
                'title' => 'Syarat & Ketentuan',
                'content' => 'Halaman ini berisi syarat dan ketentuan penggunaan situs.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'slug' => 'kebijakan-privasi',
                'title' => 'Kebijakan Privasi',
                'content' => 'Halaman ini berisi kebijakan privasi situs.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropTable('info_pages');
    }
}