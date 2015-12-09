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
 * @property Professor $professor
 */
class DisciplinaPeriodo extends \yii\db\ActiveRecord
{
    public $file;
    public $file_import;
    public $traducao_usa_laboratorio;

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
            [['idDisciplina', 'idCurso', 'idProfessor', 'qtdVagas', 'numPeriodo', 'anoPeriodo', 'usaLaboratorio'], 'integer'],
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
            'id' => 'ID',
            'idDisciplina' => 'Disciplina',
            'codTurma' => 'Código Turma',
            'idCurso' => 'Curso',
            'idProfessor' => 'Professor',
            'nomeUnidade' => 'Nome Unidade',
            'qtdVagas' => 'Quantidade Vagas',
            'numPeriodo' => 'Número Período',
            'anoPeriodo' => 'Ano Período',
            'dataInicioPeriodo' => 'Data Início Período',
            'dataFimPeriodo' => 'Data Término Período',
            'usaLaboratorio' => 'Usa Laboratório',
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
        return $this->hasOne(Curso::className(), ['ID' => 'idCurso']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfessor()
    {
        return $this->hasOne(Professor::className(), ['ID' => 'idProfessor']);
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
