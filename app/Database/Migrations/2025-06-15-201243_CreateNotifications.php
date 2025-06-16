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
                'title' => [
                    'type'           => 'VARCHAR',
                    'constraint'     => 100,                    
                    'null'           => false,                    
                ],
                'message' => [
                    'type'           => 'TEXT',
                    'constraint'     => 5000,                    
                    'null'           => false,                    
                ],              
                'created_at' => [
                    'type'           => 'DATETIME',
                    'null'           => true,  
                    'default'        => null,
                ],               
            ]
        );

        $this->forge->addKey('id', true);        
        $this->forge->addKey('code');          
        $this->forge->addKey('title');
        $this->forge->addKey('created_at');
        
        
        $this->forge->createTable('notifications');
    }

    public function down()
    {
        $this->forge->dropTable('notifications');
    }
}
