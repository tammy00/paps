<?php

use yii\db\Migration;

class m151026_134945_Tabela_Periodo extends Migration
{
    public function up()
    {
        $this->createTable('periodo', [
            'id'        => $this->primaryKey(),
            'codigo'    => $this->string(10)->notNull(),
            'dtInicio'  => $this->date()->notNull(),
            'dtTermino' => $this->date()->notNull()
        ]);
    }

    public function down()
    {
        $this->dropTable('periodo');
    }
}
