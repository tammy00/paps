<?php

use yii\db\Migration;

class m151026_140506_Tabela_Solicitacao extends Migration
{

    public function up()
    {
        
        $this->createTable('solicitacao', [
            'id'            => $this->primaryKey(),
            'descricao'     => $this->string(100)->notNull(),
            'dtInicio'      => $this->date()->notNull(),
            'dtTermino'     => $this->date()->notNull(),
            
            'horasComputadas'  => $this->integer(),
            'horasMaxAtiv'  => $this->integer(),
            'observacoes'   => $this->string(100),
            'status'        => $this->string(20)->notNull(),
            
            'atividade_id'  => $this->integer()->notNull(),
            'periodo_id'    => $this->integer()->notNull(),
            'solicitante_id'=> $this->integer()->notNull(),
            'aprovador_id'  => $this->integer()->notNull(),
            'anexo_id'      => $this->integer()->notNull()
            
        ]);
    }

    public function down()
    {
        $this->dropTable('solicitacao');
    }

}
