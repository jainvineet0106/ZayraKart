<?php
namespace App\Database\Migrations;
class Student extends \CodeIgniter\Database\Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'fname' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'mname' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'mobile' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'address' => [
                'type' => 'TEXT',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('student', true);
    }

    public function down()
    {
        $this->forge->dropTable('student');
    }
}