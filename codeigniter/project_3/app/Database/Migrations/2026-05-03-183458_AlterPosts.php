<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterPosts extends Migration
{
    public function up()
    {
        $this->forge->addColumn('posts', [
            'category_id' => [
                'type'       => 'INT',
                'constraint' => 5,
                'unsigned'   => true,
                'null'       => true,
                'after'      => 'id'
            ],
            'image' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
                'after'      => 'status'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('posts', 'category_id');
        $this->forge->dropColumn('posts', 'image');
    }
}
