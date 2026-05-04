<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Myth\Auth\Models\GroupModel;
use Myth\Auth\Entities\User;
use Myth\Auth\Models\UserModel;

class AuthSeeder extends Seeder
{
    public function run()
    {
        // 1. Setup Groups/Roles
        $db = \Config\Database::connect();
        $builder = $db->table('auth_groups');
        
        $groups = [
            ['name' => 'admin', 'description' => 'Administrator with full access'],
            ['name' => 'mahasiswa', 'description' => 'Student who can submit projects'],
            ['name' => 'guest', 'description' => 'Normal visitor']
        ];

        foreach ($groups as $group) {
            if ($builder->where('name', $group['name'])->countAllResults() == 0) {
                $builder->insert($group);
            }
        }

        // 2. Setup Dummy Users
        $userModel = new UserModel();
        
        // Admin User
        if (!$userModel->where('username', 'admin')->first()) {
            $admin = new User([
                'email'    => 'admin@campus.edu',
                'username' => 'admin',
                'password' => 'admin123',
                'active'   => 1
            ]);
            $userModel->withGroup('admin')->save($admin);
        }

        // Mahasiswa User
        if (!$userModel->where('username', 'mhs1')->first()) {
            $mhs = new User([
                'email'    => 'mhs1@campus.edu',
                'username' => 'mhs1',
                'password' => 'mhs123',
                'active'   => 1
            ]);
            $userModel->withGroup('mahasiswa')->save($mhs);
        }
    }
}
