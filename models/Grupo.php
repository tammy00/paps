<?php

namespace app\models;
use app\models\Grupo;

use Yii;

/**
 * This is the model class for table "grupo".
 *
 * @property integer $id
 * @property string $codigo
 * @property string $nome
 * @property integer $max_horas
 */
class Grupo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'grupo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['codigo', 'nome', 'max_horas'], 'required'],
            [['max_horas'], 'integer'],
            [['codigo'], 'string', 'max' => 20],
            [['nome'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'codigo' => 'Codigo',
            'nome' => 'Nome',
            'max_horas' => 'Max Horas',
        ];
    }
}
