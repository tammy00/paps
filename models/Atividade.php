<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "atividade".
 *
 * @property integer $id
 * @property string $codigo
 * @property string $nome
 * @property integer $max_horas
 * @property integer $curso_id
 * @property integer $grupo_id
 */
class Atividade extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'atividade';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['codigo', 'nome', 'max_horas', 'curso_id', 'grupo_id'], 'required'],
            [['max_horas', 'curso_id', 'grupo_id'], 'integer'],
            [['codigo'], 'string', 'max' => 5],
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
            'curso_id' => 'Curso',
            'grupo_id' => 'Grupo ID',
        ];
    }
}
