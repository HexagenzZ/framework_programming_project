<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterPostsForNews extends Migration
{
    public function up()
    {
        $this->forge->addColumn('posts', [
            'sumber_berita' => [
                'type' => 'VARCHAR', 'constraint' => '255', 'null' => true
            ],
            'is_featured' => [
                'type' => 'TINYINT', 'constraint' => 1, 'default' => 0
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('posts', 'sumber_berita');
        $this->forge->dropColumn('posts', 'is_featured');
    }
}
