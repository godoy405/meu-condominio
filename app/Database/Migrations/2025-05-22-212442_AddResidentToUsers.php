<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddResidentToUsers extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users', [
            'resident_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
                'default'    => null,               
            ],
        ]);
        $sql = "ALTER TABLE users
                ADD CONSTRAINT users_resident_id_foreign 
                FOREIGN KEY (resident_id) REFERENCES residents(id)
                ON DELETE CASCADE ON UPDATE CASCADE";
        $this->db->simpleQuery($sql);
    }

    public function down()
    {
        $this->forge->dropForeignKey('users', 'users_resident_id_foreign');
        $this->forge->dropColumn('users', 'resident_id');
    }
}
