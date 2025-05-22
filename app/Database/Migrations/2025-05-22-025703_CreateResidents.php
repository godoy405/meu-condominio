<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateResidents extends Migration
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
                'user_id' => [
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
                'name' => [
                    'type'           => 'VARCHAR',
                    'constraint'     => 100,                    
                    'null'           => false,                    
                ],
                'apartment' => [
                    'type'           => 'VARCHAR',
                    'constraint'     => 20,                    
                    'null'           => false,                    
                ],
                'mobile_phone' => [
                    'type'           => 'VARCHAR',
                    'constraint'     => 20,                    
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
        $this->forge->createTable('residents');
    }

    public function down()
    {
        //
    }
}
