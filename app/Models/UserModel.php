<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';        // Nama tabel
    protected $primaryKey = 'id';      // Primary key
    protected $useTimestamps = false;  // Tidak ada kolom created_at / updated_at

    protected $allowedFields = [
        'username',
        'password',
        'nama_lengkap',
        'email',
        'role'
    ];

    // Jika ingin menambahkan helper untuk hashing password sebelum insert/update
    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

    protected function hashPassword(array $data)
    {
        if (isset($data['data']['password'])) {
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        }
        return $data;
    }
}
