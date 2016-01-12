<?php

namespace app\models;

use Yii;

/**
 * This is the model class for view "view_professor_monitoria".
 */
class ProfessorMonitoria extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'view_professor_monitoria';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'professor', 'aluno', 'nomeDisciplina'], 'required'],
            [['id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
                'id'=>'id',
                'id_disciplina'=>'id_disciplina',
                'nomeDisciplina'=>'Disciplina',
                'codTurma'=>'Código da Turma',
                'professor'=>'Professor',
                'cpfProfessor'=>'CPF Professor',
                'idProfessor'=>'idProfessor',
                'nomeCursoDisciplina'=>'Curso da Disciplina',
                'aluno'=>'Monitor',
                'IDAluno'=>'IDAluno',
                'matricula'=>'Matrícula',
                'nomeCursoAluno'=>'Curso do Monitor',
                'bolsa'=>'Bolsista',
                'bolsa_traducao'=>'Bolsista',
                'periodo'=>'Período',
                'IDperiodoinscr'=>'IDperiodoinscr'
        ];
    }
    
    public static function primaryKey()
    {
        return array('id');
    }
}
