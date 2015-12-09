<?php

use yii\db\Migration;

class m151026_134015_Tabela_Cursos extends Migration
{
    public function up()
    {
        $this->createTable('curso', [
            'id'        => $this->primaryKey(),
            'codigo'    => $this->string(5)->notNull(),
            'nome'      => $this->string(100)->notNull(),
            'max_horas' => $this->integer()->notNull(),
        ]);
    }

    public function down()
    {
        $this->dropTable('curso');
    }

}
