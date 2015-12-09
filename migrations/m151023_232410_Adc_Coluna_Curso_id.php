<?php

use yii\db\Migration;

class m151023_232410_Adc_Coluna_Curso_id extends Migration
{
    public function up()
    {
        $this->addColumn("usuario", "curso_id", "integer");
    }

    public function down()
    {
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
