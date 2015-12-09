<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "solicitacao".
 *
 * @property integer $id
 * @property string $descricao
 * @property string $dtInicio
 * @property string $dtTermino
 * @property integer $horasComputadas
 * @property integer $horasMaxAtiv
 * @property string $observacoes
 * @property string $status
 * @property integer $atividade_id
 * @property integer $periodo_id
 * @property integer $solicitante_id
 * @property integer $aprovador_id
 * @property integer $anexo_id
 */
class Solicitacao extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'solicitacao';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['descricao', 'dtInicio', 'dtTermino', 'status', 'atividade_id', 'periodo_id', 'solicitante_id', 'aprovador_id', 'anexo_id'], 'required'],
            [['dtInicio', 'dtTermino'], 'safe'],
            [['horasComputadas', 'horasMaxAtiv', 'atividade_id', 'periodo_id', 'solicitante_id', 'aprovador_id', 'anexo_id'], 'integer'],
            [['descricao', 'observacoes'], 'string', 'max' => 100],
            [['status'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'descricao' => 'Descrição',
            'dtInicio' => 'Data Início',
            'dtTermino' => 'Data Término',
            'horasComputadas' => 'Horas Computadas',
            'horasMaxAtiv' => 'Horas Max Ativ',
            'observacoes' => 'Observacoes',
            'status' => 'Status',
            'atividade_id' => 'Atividade ID',
            'periodo_id' => 'Periodo ID',
            'solicitante_id' => 'Solicitante ID',
            'aprovador_id' => 'Aprovador ID',
            'anexo_id' => 'Anexo ID',
        ];
    }
}
