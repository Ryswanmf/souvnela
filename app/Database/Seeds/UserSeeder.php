<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $model = new \App\Models\UserModel();

        $model->save([
            'nama_lengkap' => 'Administrator',
            'username'     => 'admin',
            'password'     => 'password123', // The model's beforeInsert hook will hash this
            'role'         => 'admin'
        ]);
    }
}