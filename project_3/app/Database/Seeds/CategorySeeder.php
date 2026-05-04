<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['name' => 'Desain Grafis', 'slug' => 'desain-grafis'],
            ['name' => 'Web Development', 'slug' => 'web-development'],
            ['name' => 'Fotografi', 'slug' => 'fotografi'],
            ['name' => 'UI/UX Design', 'slug' => 'ui-ux-design'],
        ];

        $this->db->table('categories')->ignore(true)->insertBatch($data);
    }
}
