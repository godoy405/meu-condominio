<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBills extends Migration
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
                'reservation_id' => [
                    'type'           => 'INT',
                    'constraint'     => 11, 
                    'unsigned'       => true,
                    'null'           => true,
                    'default'        => null,
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
                'amount' => [
                    'type'           => 'INT',                                      
                    'comment'        => 'Valor da cobrança em centavos',                    
                ],
                'due_date' => [
                    'type'           => 'DATE',                    
                    'comment'        => 'Data do vencimento',                    
                ],
                'status' => [
                    'type'           => 'ENUM',
                    'constraint'     => ['pending', 'paid', 'overdue'],                    
                    'default'        => 'pending',                    
                ],              
                'notes' => [
                    'type'           => 'VARCHAR',
                    'constraint'     => 255,                    
                    'null'           => false,  
                    'default'        => null,                    
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
        $this->forge->addKey('reservation_id');
        $this->forge->addKey('resident_id');
        $this->forge->addKey('code');
        $this->forge->addKey('due_date');
        $this->forge->addKey('status');
        $this->forge->addKey('amount');       
        $this->forge->addKey('created_at');

        $this->forge->addForeignKey('resident_id', 'residents', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('reservation_id', 'reservations', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('bills');

    }

    public function down()
    {
        $this->forge->dropTable('bills');
    }
}
