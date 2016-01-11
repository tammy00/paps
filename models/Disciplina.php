<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "disciplina".
 *
 * @property integer $id
 * @property string $codDisciplina
 * @property string $nomeDisciplina
 * @property integer $cargaHoraria
 * @property integer $creditos
 *
 * @property DisciplinaPeriodo[] $disciplinaPeriodos
 */
class Disciplina extends \yii\db\ActiveRecord
{

    public $traducao_possui_monitoria;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'disciplina';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['codDisciplina', 'nomeDisciplina', 'cargaHoraria', 'creditos'], 'required', 'message'=>'Este campo é obrigatório'],
            [['cargaHoraria', 'creditos', 'possuiMonitoria'], 'integer'],
            [['codDisciplina'], 'string', 'max' => 10],
            [['nomeDisciplina'], 'string', 'max' => 150],
            [['codDisciplina'], 'unique', 'message'=>'O código da disciplina já existe no sistema.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'id',
            'codDisciplina' => 'Código da Disciplina',
            'nomeDisciplina' => 'Nome da Disciplina',
            'cargaHoraria' => 'Carga Horária',
            'creditos' => 'Créditos',
            'possuiMonitoria' => 'Disciplina com Monitoria',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDisciplinaPeriodos()
    {
        return $this->hasMany(DisciplinaPeriodo::className(), ['idDisciplina' => 'id']);
    }

    public function afterFind()
    {
        switch ($this->possuiMonitoria)
        {
            case 0:
                $this->traducao_possui_monitoria = 'Não';
                break;
            case 1:
                $this->traducao_possui_monitoria = 'Sim';
                break;
        }
    }
}
