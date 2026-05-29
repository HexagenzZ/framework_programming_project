<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProjectMembers extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true
            ],
            'project_id' => [
                'type' => 'INT', 'constraint' => 11, 'unsigned' => true
            ],
            'name' => [
                'type' => 'VARCHAR', 'constraint' => '255'
            ],
            'nim' => [
                'type' => 'VARCHAR', 'constraint' => '50', 'null' => true
            ],
            'role_in_team' => [
                'type' => 'VARCHAR', 'constraint' => '100', 'null' => true
            ],
            'created_at DATETIME DEFAULT CURRENT_TIMESTAMP'
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('project_id', 'projects', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('project_members', true);
    }

    public function down()
    {
        $this->forge->dropTable('project_members', true);
    }
}
