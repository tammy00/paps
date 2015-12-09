<?php

use yii\db\Migration;

class m151026_135427_Tabela_Anexo extends Migration
{
    public function up()
    {
        $this->createTable('anexo', [
            'id'    => $this->primaryKey(),
            'nome'  => $this->string(5)->notNull(),
            'tipo'  => $this->string(100)->notNull(),
            'hash'  => $this->integer()->notNull(),

        ]);
    }

    public function down()
    {
        $this->dropTable('anexo');
    }
}
