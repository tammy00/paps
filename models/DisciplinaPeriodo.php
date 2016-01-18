<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "disciplina_periodo".
 *
 * @property integer $id
 * @property integer $idDisciplina
 * @property string $codTurma
 * @property integer $idCurso
 * @property integer $idProfessor
 * @property string $nomeUnidade
 * @property integer $qtdVagas
 * @property integer $numPeriodo
 * @property integer $anoPeriodo
 * @property string $dataInicioPeriodo
 * @property string $dataFimPeriodo
 * @property integer $usaLaboratorio
 *
 * @property Disciplina $disciplina
 * @property Curso $curso
 * @property Usuario $usuario
 */
class DisciplinaPeriodo extends \yii\db\ActiveRecord
{
    public $file;
    public $file_import;
    public $traducao_usa_laboratorio;
    public $codDisciplina;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'disciplina_periodo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idDisciplina', 'codTurma', 'idCurso', 'nomeUnidade', 'qtdVagas', 'numPeriodo', 'anoPeriodo'], 'required', 'message'=>'Este campo é obrigatório'],
            [['idDisciplina', 'idCurso', 'idProfessor', 'qtdVagas', 'qtdMonitorBolsista', 'qtdMonitorNaoBolsista', 'numPeriodo', 'anoPeriodo', 'usaLaboratorio'], 'integer'],
            [['dataInicioPeriodo', 'dataFimPeriodo', 'idProfessor'], 'safe'],
            [['codTurma'], 'string', 'max' => 10],
            [['nomeUnidade'], 'string', 'max' => 100],
            [['idDisciplina'], 'validateFieldsUnique'],
            [['codTurma'], 'validateFieldsUnique'],
            [['numPeriodo'], 'validateFieldsUnique'],
            [['anoPeriodo'], 'validateFieldsUnique'],
            [['file'], 'file', 'extensions' => 'csv'],
            [['file'], 'file', 'extensions' => 'csv', 'skipOnEmpty' => false, 'on' => 'csv'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'id',
            'idDisciplina' => 'Disciplina',
            'codDisciplina' => 'Código da Disciplina',
            'codTurma' => 'Código Turma',
            'idCurso' => 'Curso',
            'idProfessor' => 'Professor',
            'nomeUnidade' => 'Nome Unidade',
            'qtdVagas' => 'Quantidade de Vagas da Turma',
            'qtdMonitorBolsista' => 'Quantidade de Monitor Bolsista',
            'qtdMonitorNaoBolsista' => 'Quantidade de Monitor Não Bolsista',
            'numPeriodo' => 'Número do Período',
            'anoPeriodo' => 'Ano do Período',
            'dataInicioPeriodo' => 'Data Incial do Período',
            'dataFimPeriodo' => 'Data Final do Período',
            'usaLaboratorio' => 'Usar Laboratório',
            'file' => 'Arquivo CSV',
        ];
    }

    public function scenarios() {
        $scenarios = parent::scenarios();
        $scenarios['csv'] = ['file'];
        return $scenarios;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDisciplina()
    {
        return $this->hasOne(Disciplina::className(), ['id' => 'idDisciplina']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCurso()
    {
        return $this->hasOne(Curso::className(), ['id' => 'idCurso']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuario::className(), ['id' => 'idProfessor']);
    }

    
    public function validateFieldsUnique($attribute, $params) {

        $modelAux = DisciplinaPeriodo::findOne([
                'idDisciplina' => $this->idDisciplina, 
                'codTurma' => $this->codTurma, 
                'anoPeriodo' => $this->anoPeriodo, 
                'numPeriodo' => $this->numPeriodo
            ]);

        if ($modelAux != null) {
            if ($modelAux->id != $this->id) {
                $this->addError($attribute, 'O conjunto (Disciplina, Código Turma, Ano Período e Número Período) já existem no sistema.');
            }
        }
    }

    public function afterFind()
    {
        switch ($this->usaLaboratorio)
        {
            case 0:
                $this->traducao_usa_laboratorio = 'Não';
                break;
            case 1:
                $this->traducao_usa_laboratorio = 'Sim';
                break;
        }
    }
}
