<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAnnoucements extends Migration
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
                'is_public' => [
                    'type'           => 'TINYINT',  
                    'constraint'     => 1, 
                    'default'        => 1,                
                    'comment'        => 'Se é publico, exibe os ddos do anunciante',
                ],               
                'title' => [
                    'type'           => 'VARCHAR',
                    'constraint'     => 255,                                                            
                ],
                'content' => [
                    'type'           => 'TEXT',
                    'constraint'     => 5000,                                        
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
        $this->forge->addKey('is_public');                     
        $this->forge->addKey('created_at');
        

        $this->forge->addForeignKey('resident_id', 'residents', 'id', 'CASCADE', 'CASCADE');
       
        $this->forge->createTable('announcements');
    }

    public function down()
    {
        $this->forge->dropTable('announcements');
    }
}
