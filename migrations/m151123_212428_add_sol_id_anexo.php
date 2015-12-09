<?php

use yii\db\Migration;

class m151123_212428_add_sol_id_anexo extends Migration
{

    public function up()
    {
        $this->addColumn("anexo", "solicitacao_id", "integer");
        $this->alterColumn("anexo", "nome", "string not null");
    }

    public function down()
    {
        return false;
    }

}
