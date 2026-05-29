<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCustomUsers extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true
            ],
            'username' => [
                'type' => 'VARCHAR', 'constraint' => '50', 'unique' => true
            ],
            'email' => [
                'type' => 'VARCHAR', 'constraint' => '100', 'unique' => true
            ],
            'password_hash' => [
                'type' => 'VARCHAR', 'constraint' => '255'
            ],
            'role' => [
                'type' => 'ENUM', 'constraint' => ['admin', 'mahasiswa', 'guest'], 'default' => 'mahasiswa'
            ],
            'full_name' => [
                'type' => 'VARCHAR', 'constraint' => '100'
            ],
            'nim' => [
                'type' => 'VARCHAR', 'constraint' => '20', 'null' => true
            ],
            'created_at DATETIME DEFAULT CURRENT_TIMESTAMP',
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('custom_users', true);
    }

    public function down()
    {
        $this->forge->dropTable('custom_users', true);
    }
}
