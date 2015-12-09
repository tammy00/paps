<?php

use yii\db\Migration;

class m151023_003007_Tabela_Usua extends Migration
{
    public function up()
    {
        $this->createTable('usuario', [
            'id'        => $this->primaryKey(),
            'name'      => $this->string(100)->notNull(),
            'cpf'       => $this->string(100)->notNull(),
            'email'     => $this->string(100)->notNull(),
            'password'  => $this->string(100)->notNull(),
            'matricula' => $this->string(20),
            'siape'     => $this->string(20),
            'perfil'    => $this->string(20)->notNull(),
            'dtEntrada' => $this->date(),
            
            'isAdmin'   => $this->boolean()->notNull(),
            'isAtivo'   => $this->boolean()->notNull(),
            
            'auth_key'              => $this->string(65),
            'password_reset_token'  => $this->string(255),
        
        ]);
    }

    public function down()
    {
        $this->dropTable('usuario');
    }


}
