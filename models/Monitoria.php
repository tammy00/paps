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
    public $filePlanoDisciplina;
    public $fileRelatorioSemestral;
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
            [['IDAluno', 'IDDisc', 'bolsa', 'status', 'IDperiodoinscr'], 'integer', 'message'=>'O valor deve ser númerico'],
            [['semestreConclusao'], 'in', 'range' => [1,2], 'message'=>'O valor deve ser 1 ou 2'],
            [['anoConclusao'], 'integer', 'min'=>2015, 'message'=>'O valor deve ser um ano no formato de 4 dígitos.'],
            [['mediaFinal'], 'number', 'min'=>7.0, 'max'=>10.0, 'tooSmall'=>'O valor não deve ser menor que 7.', 'tooBig'=>'O valor não deve ser maior que 10.'],
            ['banco', 'required', 
                'message'=>'O código do banco é obrigatório para bolsista', 
                'when' => function($model) { return $model->bolsa == 1; }, 
                'whenClient' => "function (attribute, value) { return $('#monitoria-bolsa').val() == '1'; }",
                //'whenClient' => function($model) { return $model->bolsa == 1; }, 
                'enableClientValidation' => false
            ],
            ['agencia', 'required', 
                'message'=>'A agência bancária é obrigatória para bolsista', 
                'when' => function($model) { return $model->bolsa == 1; }, 
                'whenClient' => "function (attribute, value) { return $('#monitoria-bolsa').val() == '1'; }",
                'enableClientValidation' => false
            ],
            ['conta', 'required', 
                'message'=>'A conta corrente é obrigatória para bolsista', 
                'when' => function($model) { return $model->bolsa == 1; }, 
                'whenClient' => "function (attribute, value) { return $('#monitoria-bolsa').val() == '1'; }",
                'enableClientValidation' => false
            ],
            [['file'], 'file', 'extensions' => 'pdf', 'skipOnEmpty' => false, 
                'message' => 'Falha ao carregar o arquivo.', 
                'uploadRequired' => 'Por favor, faça o upload do histórico escolar em PDF.', 
                'wrongExtension' => 'Apenas arquivos com a extensão PDF são permitidos.'
            ],
            [['pathArqHistorico'], 'string', 'max' => 250],
            [['filePlanoDisciplina'], 'file', 'extensions' => 'doc', 'skipOnEmpty' => true, 
                'message' => 'Falha ao carregar o arquivo.', 
                'uploadRequired' => 'Por favor, faça o upload do Plano Semestral da Disciplina.', 
                'wrongExtension' => 'Apenas arquivos com a extensão DOC são permitidos.'
            ],
            [['fileRelatorioSemestral'], 'file', 'extensions' => 'doc', 'skipOnEmpty' => true, 
                'message' => 'Falha ao carregar o arquivo.', 
                'uploadRequired' => 'Por favor, faça o upload do Relatório Semestral de Monitoria.', 
                'wrongExtension' => 'Apenas arquivos com a extensão DOC são permitidos.'
            ],
            [['pathArqPlanoDisciplina'], 'string', 'max' => 250],
            [['pathArqRelatorioSemestral'], 'string', 'max' => 250],
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
            'datacriacao' => 'Data Criação',
            'filePlanoDisciplina' => 'Plano Semestral da Disciplina (.DOC)',
            'fileRelatorioSemestral' => 'Relatório Semestral de Monitoria (.DOC)',
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

    public function nomeMes($mes) 
    {
        switch ($mes)
        {
            case '1': 
                $mes = 'Janeiro';
                break;
            case '2': 
                $mes = 'Fevereiro';
                break;
            case '3': 
                $mes = 'Março';
                break;
            case '4': 
                $mes = 'Abril';
                break;
            case '5': 
                $mes = 'Maio';
                break;
            case '6': 
                $mes = 'Junho';
                break;
            case '7': 
                $mes = 'Julho';
                break;
            case '8': 
                $mes = 'Agosto';
                break;
            case '9': 
                $mes = 'Setembro';
                break;
            case '10': 
                $mes = 'Outubro';
                break;
            case '11': 
                $mes = 'Novembro';
                break;
            case '12': 
                $mes = 'Dezembro';
                break;
        }
        return $mes;
    }

    public function nomeDia($dia)
    {
        $diaString = '';
        switch ($dia)
        {
            case 0: 
                $diaString = 'DOM';
                break;
            case 1: 
                $diaString = 'SEG';
                break;
            case 2: 
                $diaString = 'TER';
                break;
            case 3: 
                $diaString = 'QUA';
                break;
            case 4: 
                $diaString = 'QUI';
                break;
            case 5: 
                $diaString = 'SEX';
                break;
            case 6: 
                $diaString = 'SAB';
                break;
        }
        return $diaString;
    }
}
