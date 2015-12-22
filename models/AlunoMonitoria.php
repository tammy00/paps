<?php

namespace app\models;

use Yii;

/**
 * This is the model class for view "view_aluno_monitoria".
 */
class AlunoMonitoria extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'view_aluno_monitoria';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'aluno', 'nomeDisciplina'], 'required'],
            [['id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'id',
            'id_disciplina' => 'id_disciplina',
            'bolsa' => 'bolsa',
            'bolsa_traducao' => 'Bolsista',
            'aluno' => 'Aluno',
            'IDAluno' => 'IDAluno',
            'matricula' => 'Matrícula',
            'cpf' => 'CPF',
            'nomeDisciplina' => 'Disciplina',
            'codTurma' => 'Código da Turma',
            'professor' => 'Professor',
            'nomeCurso' => 'Curso',
            'status' => 'Status',
            'periodo' => 'Período'
        ];
    }
    
    public static function primaryKey()
    {
        return array('id');
    }
}
