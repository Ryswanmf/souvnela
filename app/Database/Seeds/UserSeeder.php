<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $model = new \App\Models\UserModel();

        // Always ensure admin user exists with correct password
        $data = [
            'nama_lengkap' => 'Administrator',
            'username'     => 'admin',
            'password'     => 'password123', // The model's beforeInsert/beforeUpdate hook will hash this
            'role'         => 'admin'
        ];

        $existingUser = $model->where('username', 'admin')->first();
        if ($existingUser) {
            // Update existing user
            $model->update($existingUser['id'], $data);
        } else {
            // Insert new user
            $model->insert($data);
        }
    }
}