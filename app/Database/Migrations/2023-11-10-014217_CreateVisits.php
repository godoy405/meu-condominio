<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateVisits extends Migration
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
                'resident_id' => [
                    'type'           => 'INT',
                    'constraint'     => 11, 
                    'unsigned'       => true,                
                ],             
                'code' => [
                    'type'           => 'INT',
                    'constraint'     => 8,                    
                    'null'           => false,                    
                ],
                'name' => [
                    'type'           => 'VARCHAR',  
                    'constraint'     => 128,                                      
                ],
                'is_used' => [
                    'type'           => 'TINYINT', 
                    'constraint'     => 1,                   
                    'default'        => 0,                    
                ],
                'valid_until' => [
                    'type'           => 'DATETIME',
                    'comment'        => 'Válida por 24 horas, por exemplo.',                 
                ],
                'used_in' => [
                    'type'           => 'DATETIME',
                    'null'           => true,
                    'default'        => null,  
                    'comment'        => 'Quando foi utilizada.',                  
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
        $this->forge->addKey('resident_id');
        $this->forge->addKey('code');
        $this->forge->addKey('name');
        $this->forge->addKey('valid_until');
        $this->forge->addKey('used_in');       
        $this->forge->addKey('created_at');

        $this->forge->addForeignKey('resident_id', 'residents', 'id', 'CASCADE', 'CASCADE');        

        $this->forge->createTable('visits');

    }

    public function down()
    {
        $this->forge->dropTable('visits');
    }
}
