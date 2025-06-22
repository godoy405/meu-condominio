<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateOccurrences extends Migration
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
                    'null'           => true,
                    'default'        => null,
                ],              
                'code' => [
                    'type'           => 'VARCHAR',
                    'constraint'     => 8,                    
                    'null'           => false,                    
                ],
                'title' => [
                    'type'           => 'VARCHAR',  
                    'constraint'     => 255,                     
                ],            
                'description' => [
                    'type'           => 'TEXT',
                    'constraint'     => 5000,                                        
                ],
                'solution' => [
                    'type'           => 'TEXT',
                    'constraint'     => 5000,
                    'null'           => true,
                    'default'        => null,                                        
                ],   
                'status' => [
                    'type'           => 'VARCHAR',  
                    'constraint'     => 70,                     
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
        $this->forge->addKey('title');
        $this->forge->addKey('code');                         
        $this->forge->addKey('created_at');
        

        $this->forge->addForeignKey('resident_id', 'residents', 'id', 'CASCADE', 'CASCADE');
       
        $this->forge->createTable('occurrences');

        //--------Atualizações das ocorrências ---------------//
        

        $this->forge->addField(
            [
                'id' => [
                    'type'           => 'INT',
                    'constraint'     => 11,
                    'unsigned'       => true,
                    'auto_increment' => true,
                ],
                'occurrence_id' => [
                    'type'           => 'INT',
                    'constraint'     => 11,
                    'unsigned'       => true,
                    'null'           => true,
                    'default'        => null,
                ],             
               'description' => [
                    'type'           => 'TEXT',
                    'constraint'     => 5000,                                        
                ],
               'created_at' => [
                    'type'           => 'DATETIME',
                    'null'           => true,  
                    'default'        => null,
                ],
              
            ]
        );

        $this->forge->addKey('id', true);
        $this->forge->addKey('occurrence_id');                               
        $this->forge->addKey('created_at');
        

        $this->forge->addForeignKey('occurrence_id', 'occurrences', 'id', 'CASCADE', 'CASCADE');
       
        $this->forge->createTable('occurrence_updates');   


    }

    public function down()
    {
        $this->forge->dropTable('occurrence_updates');//! vem primeiro
        $this->forge->dropTable('occurrences');//! vem depois
    }
}
