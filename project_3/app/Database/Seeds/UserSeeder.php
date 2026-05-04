<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'username'      => 'admin',
                'email'         => 'admin@kampus.ac.id',
                'password_hash' => password_hash('admin123', PASSWORD_BCRYPT),
                'role'          => 'admin',
                'full_name'     => 'Administrator System',
                'nim'           => null
            ],
            [
                'username'      => 'mahasiswa',
                'email'         => 'mhs@kampus.ac.id',
                'password_hash' => password_hash('mhs123', PASSWORD_BCRYPT),
                'role'          => 'mahasiswa',
                'full_name'     => 'Budi Mahasiswa',
                'nim'           => '123456789'
            ]
        ];

        $this->db->table('custom_users')->ignore(true)->insertBatch($data);
    }
}
