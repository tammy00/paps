<?php

use yii\db\Migration;

class m151026_134357_Tabela_Grupos extends Migration
{
    public function up()
    {
        $this->createTable('grupo', [
            'id'        => $this->primaryKey(),
            'codigo'    => $this->string(20)->notNull(),
            'nome'      => $this->string(100)->notNull(),
            'max_horas' => $this->integer()->notNull(),
        ]);
    }

    public function down()
    {
        $this->dropTable('grupo');
    }
}
