<?php

use yii\db\Migration;

class m151023_004230_Inserir_Usuario extends Migration
{
    public function up()
    {
        $this->insert('usuario', array(
            'id'        => '',
            'name'      => 'Admin Master',
            'cpf'       => '999',
            'email'     => 'admin@master.com',
            'password'  => md5('999'),
            'matricula' => '',
            'siape'     => '',
            'perfil'    => 'admin',
            'dtEntrada' => date("Y-M-D"),
            
            'isAdmin'   => 1,
            'isAtivo'   => 1,
        ));
    }

    public function down()
    {
        echo "m151023_004230_Inserir_Usuario cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
