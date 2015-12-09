<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "monitoria".
 *
 * @property integer $ID
 * @property string $numProcs
 * @property integer $IDAluno
 * @property integer $IDDisc
 * @property integer $IDCurso
 * @property integer $bolsa
 *
 * @property Disciplina $iDDisc
 * @property Curso $iDCurso
 * @property Aluno $iDAluno
 */
class Monitoria extends \yii\db\ActiveRecord
{

    public $file;

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
            [['numProcs', 'IDAluno', 'IDDisc', 'IDCurso', 'bolsa'], 'required'],
            [['IDAluno', 'IDDisc', 'IDCurso', 'bolsa'], 'integer'],
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
            'IDCurso' => 'Curso',
            'bolsa' => 'Bolsista',
            'file' => 'Histórico em PDF',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIDDisc()
    {
        return $this->hasOne(DisciplinaPeriodo::className(), ['id' => 'IDDisc']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIDCurso()
    {
        return $this->hasOne(Curso::className(), ['ID' => 'IDCurso']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIDAluno()
    {
        return $this->hasOne(Aluno::className(), ['ID' => 'IDAluno']);
    }


    public function afterFind()
    {
        switch ($this->bolsa)
        {
            case 0:
                $this->bolsa = 'Não';
                break;
            case 1:
                $this->bolsa = 'Sim';
                break;
        }
    }
    
    
}
