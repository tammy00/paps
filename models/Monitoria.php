<?php

namespace app\models;

use Yii;
use app\models\PeriodoInscricaoMonitoria;

/**
 * This is the model class for table "monitoria".
 *
 * @property integer $id
 * @property integer $IDAluno
 * @property integer $IDDisc
 * @property integer $bolsa
 *
 * @property DisciplinaPeriodo $disciplinaperiodo
 * @property Usuario $usuario
 * @property PeriodoInscricaoMonitoria $periodoinscricao
 */
class Monitoria extends \yii\db\ActiveRecord
{

    public $file;
    public $nomeDisciplina;
    public $nomeProfessor;
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
            [['IDAluno', 'IDDisc', 'status', 'IDperiodoinscr', 'semestreConclusao', 'anoConclusao', 'mediaFinal'], 'required', 'message'=>'Este campo é obrigatório'],
            [['IDAluno', 'IDDisc', 'bolsa', 'status', 'IDperiodoinscr', 'banco', 'agencia', 'conta'], 'integer', 'message'=>'O valor deve ser númerico'],
            [['semestreConclusao'], 'in', 'range' => [1,2], 'message'=>'O valor deve ser 1 ou 2'],
            [['anoConclusao'], 'integer', 'min'=>2015, 'message'=>'O valor deve ser um ano no formato de 4 dígitos maior/igual a 2015.'],
            [['mediaFinal'], 'number', 'min'=>7.0, 'max'=>10.0, 'message'=>'O valor deve ser maior/igual 7.0. Use o ponto (.) como o separador decimal.'],
            [['file'], 'file', 'extensions' => 'pdf', 'skipOnEmpty' => false],
            [['pathArqHistorico'], 'string', 'max' => 250],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'id',
            'IDAluno' => 'Aluno',
            'IDDisc' => 'Disciplina',
            'bolsa' => 'Deseja Bolsa?',
            'file' => 'Histórico Escolar (.PDF)',
            'status' => 'Status',
            'IDperiodoinscr' => 'Ano/período',
            'semestreConclusao' => 'Semestre de Previsão de Conclusão',
            'anoConclusao' => 'Ano de Previsão de Conclusão',
            'mediaFinal' => 'Média Obtida Quando Cursou a Disciplina',
            'nomeCurso' => 'Curso da Monitoria',
            'banco' => 'Código Banco',
            'agencia' => 'Agência',
            'conta' => 'Conta',
            'datacriacao' => 'Data Criação'
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
    public function getUsuario()
    {
        return $this->hasOne(Usuario::className(), ['id' => 'IDAluno']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPeriodoinscricao()
    {
        return $this->hasOne(PeriodoInscricaoMonitoria::className(), ['id' => 'IDperiodoinscr']);
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
        
        $periodo = PeriodoInscricaoMonitoria::findOne(['id' => $this->IDperiodoinscr]);
        $this->IDperiodoinscr = $periodo->ano.'/'.$periodo->periodo;

        $disciplinaPeriodo = DisciplinaPeriodo::findOne($this->IDDisc);
        $disciplina = Disciplina::find()->where(['id' => $disciplinaPeriodo->idDisciplina])->one();
        $this->nomeDisciplina = $disciplina->nomeDisciplina;

        $curso = Curso::find()->where(['id' => $disciplinaPeriodo->idCurso])->one();
        $this->nomeCurso = $curso->nome;
    }
}
