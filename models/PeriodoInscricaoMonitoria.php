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
            'periodo' => 'Período da Universidade',
        ];
    }
}
