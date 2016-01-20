<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "comissao".
 *
 * @property integer $id
 * @property integer $idProfessor
 *
 * @property Usuario $idProfessor
 */
class Comissao extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comissao';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idProfessor'], 'required', 'message'=>'Este campo é obrigatório'],
            [['idProfessor'], 'unique', 'message'=>'Professor(a) já cadastrado'],
            [['idProfessor'], 'integer'],
            [['idProfessor'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['idProfessor' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'idProfessor' => 'Professor',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    //public function getIdProfessor()
    public function getUsuario()
    {
        return $this->hasOne(Usuario::className(), ['id' => 'idProfessor']);
    }
}
