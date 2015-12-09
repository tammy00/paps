<?php

use yii\db\Migration;

class m151026_134526_Tabela_Atividade extends Migration
{
    public function up()
    {
        $this->createTable('atividade', [
            'id'        => $this->primaryKey(),
            'codigo'    => $this->string(5)->notNull(),
            'nome'      => $this->string(100)->notNull(),
            'max_horas' => $this->integer()->notNull(),
            
            'curso_id' => $this->integer()->notNull(),
            'grupo_id' => $this->integer()->notNull()
            
        ]);
    }

    public function down()
    {
        $this->dropTable('atividade');
    }
}
