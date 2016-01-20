<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "periodoinscricao".
 *
 * @property integer $id
 * @property string $dataInicio
 * @property string $dataFim
 * @property string $periodo
 * @property string justificativa
 */
class PeriodoInscricaoMonitoria extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'periodoinscricao';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dataInicio', 'dataFim', 'periodo', 'ano'], 'required', 'message'=>'Este campo é obrigatório.'],
            [['justificativa'], 'string'],
            [['dataInicio', 'dataFim'], 'safe'],
            [['periodo'], 'in', 'range' => [1,2]],
            [['ano'], 'integer', 'min'=>2015],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'id',
            'dataInicio' => 'Data Inicial   ',
            'dataFim' => 'Data Final   ',
            'ano' => 'Ano',
            'periodo' => 'Número do Período',
            'justificativa' => 'Justificativa',
        ];
    }
}
