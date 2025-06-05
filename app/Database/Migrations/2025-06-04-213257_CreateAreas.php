<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAreas extends Migration
{
    public function up()
    {
        $this->forge->addField(
            [
                'id' => [
                    'type'           => 'INT',
                    'constraint'     => 11,
                    'unsigned'       => true,
                    'auto_increment' => true,
                ],              
                'code' => [
                    'type'           => 'VARCHAR',
                    'constraint'     => 8,                    
                    'null'           => false,                    
                ],
                'name' => [
                    'type'           => 'VARCHAR',
                    'constraint'     => 100,                    
                    'null'           => false,                    
                ],
                'description' => [
                    'type'           => 'TEXT',
                    'constraint'     => 5000,                    
                    'null'           => false,                    
                ],              
                'created_at' => [
                    'type'           => 'DATETIME',
                    'null'           => true,  
                    'default'        => null,
                ],
                'updated_at' => [
                    'type'           => 'DATETIME',
                    'null'           => true,                    
                    'default'        => null,
                ],
            ]
        );

        $this->forge->addKey('id', true);        
        $this->forge->addKey('code');          
        $this->forge->addKey('name');
        $this->forge->addKey('created_at');
        $this->forge->addKey('updated_at');
        
        $this->forge->createTable('areas');
    }

    public function down()
    {
        $this->forge->dropTable('areas');
    }
}
