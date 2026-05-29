<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProjectsNew extends Migration
{
    public function up()
    {
        $this->forge->dropTable('projects', true);
        
        $this->forge->addField([
            'id' => [
                'type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true
            ],
            'user_id' => [
                'type' => 'INT', 'constraint' => 11, 'unsigned' => true
            ],
            'title' => [
                'type' => 'VARCHAR', 'constraint' => '255'
            ],
            'slug' => [
                'type' => 'VARCHAR', 'constraint' => '255'
            ],
            'description' => [
                'type' => 'TEXT'
            ],
            'thumbnail' => [
                'type' => 'VARCHAR', 'constraint' => '255', 'null' => true
            ],
            'github_url' => [
                'type' => 'VARCHAR', 'constraint' => '255', 'null' => true
            ],
            'demo_url' => [
                'type' => 'VARCHAR', 'constraint' => '255', 'null' => true
            ],
            'tech_stack' => [
                'type' => 'VARCHAR', 'constraint' => '255', 'null' => true
            ],
            'mata_kuliah' => [
                'type' => 'VARCHAR', 'constraint' => '255', 'null' => true
            ],
            'semester' => [
                'type' => 'TINYINT', 'constraint' => 2, 'null' => true
            ],
            'status' => [
                'type' => 'ENUM', 'constraint' => ['pending', 'approved', 'rejected'], 'default' => 'pending'
            ],
            'created_at DATETIME DEFAULT CURRENT_TIMESTAMP',
            'updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'custom_users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('projects', true);
    }

    public function down()
    {
        $this->forge->dropTable('projects', true);
    }
}
