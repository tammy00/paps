<?php

namespace app\models;

use Yii;
use app\models\PeriodoInscricaoMonitoria;

/**
 * This is the model class for table "monitoria".
 *
 * @property integer $ID
 * @property string $numProcs
 * @property integer $IDAluno
 * @property integer $IDDisc
 * @property integer $bolsa
 *
 * @property DisciplinaPeriodo $disciplinaperiodo
 * @property Aluno $aluno
 * @property PeriodoInscricaoMonitoria $periodoinscricao
 */
class Monitoria extends \yii\db\ActiveRecord
{

    public $file;
    public $nomeDisciplina;
    public $nomeCurso;
    public $traducao_bolsa;
    public $traducao_status;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'monitoria';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['numProcs', 'IDAluno', 'IDDisc', 'bolsa', 'status', 'IDperiodoinscr', 'semestreConclusao', 'anoConclusao', 'mediaFinal'], 'required', 'message'=>'Este campo é obrigatório'],
            [['IDAluno', 'IDDisc', 'bolsa', 'status', 'IDperiodoinscr', 'semestreConclusao', 'anoConclusao'], 'integer'],
            [['mediaFinal'], 'number'],
            [['numProcs'], 'string', 'max' => 150, 'min' => 7],
            [['file'], 'file', 'extensions' => 'pdf'],
            [['pathArqHistorico'], 'string', 'max' => 250],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'numProcs' => 'Nº Processo',
            'IDAluno' => 'Aluno',
            'IDDisc' => 'Disciplina',
            'bolsa' => 'Bolsista',
            'file' => 'Histórico em PDF',
            'status' => 'Status',
            'IDperiodoinscr' => 'Ano/período',
            'semestreConclusao' => 'Semestre Previsão Conclusão',
            'anoConclusao' => 'Ano Previsão Conclusão',
            'mediaFinal' => 'Média Final',
            'nomeCurso' => 'Curso da Monitoria',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDisciplinaperiodo()
    {
        return $this->hasOne(DisciplinaPeriodo::className(), ['id' => 'IDDisc']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAluno()
    {
        return $this->hasOne(Aluno::className(), ['ID' => 'IDAluno']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPeriodoinscricao()
    {
        return $this->hasOne(PeriodoInscricaoMonitoria::className(), ['ID' => 'IDperiodoinscr']);
    }


    public function afterFind()
    {
        switch ($this->bolsa)
        {
            case 0:
                $this->traducao_bolsa = 'Não';
                break;
            case 1:
                $this->traducao_bolsa = 'Sim';
                break;
        }

        switch ($this->status)
        {
            case 0:
                $this->traducao_status = 'Aguardando Avaliação';
                break;
            case 1:
                $this->traducao_status = 'Deferido';
                break;
            case 2:
                $this->traducao_status = 'Indeferido';
                break;
        }
        
        $periodo = PeriodoInscricaoMonitoria::findOne(['ID' => $this->IDperiodoinscr]);
        $this->IDperiodoinscr = $periodo->ano.'/'.$periodo->periodo;

        $disciplinaPeriodo = DisciplinaPeriodo::findOne($this->IDDisc);
        $disciplina = Disciplina::find()->where(['id' => $disciplinaPeriodo->idDisciplina])->one();
        $this->nomeDisciplina = $disciplina->nomeDisciplina;

        $curso = Curso::find()->where(['ID' => $disciplinaPeriodo->idCurso])->one();
        $this->nomeCurso = $curso->nome;
    }
}
