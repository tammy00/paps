<?php

namespace app\models;

use Yii;

/**
 * This is the model class for view "view_disciplina_monitoria".
 *
 * @property integer $id
 * @property string $nomeDisciplina
 * @property string $nomeCurso
 * @property string $codTurma
 * @property string $nomeProfessor
 */
class DisciplinaMonitoria extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'view_disciplina_monitoria';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'nomeDisciplina'], 'required'],
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
            'codDisciplina' => 'Código Disciplina',
            'nomeDisciplina' => 'Disciplina',
            'nomeCurso' => 'Curso',
            'nomeProfessor' => 'Professor',
            'codTurma' => 'Código da Turma',
            'numPeriodo' => 'Número do Período',
            'anoPeriodo' => 'Ano do Período',
            'qtdVagas' => 'QTD Vagas',
            'lab' => 'Usa Laboratório',
            'lab_traducao' => 'Usa Laboratório',
            'qtdMonitorBolsista' => 'QTD Bolsista',
            'qtdMonitorNaoBolsista' => 'QTD Não Bolsista'
        ];
    }
}
