<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "anexo".
 *
 * @property integer $id
 * @property string $nome
 * @property string $tipo
 * @property integer $hash
 * @property integer $solicitacao_id
 */
class Anexo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'anexo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nome', 'tipo', 'hash'], 'required'],
            [['hash', 'solicitacao_id'], 'integer'],
            [['nome'], 'string', 'max' => 255],
            [['tipo'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nome' => 'Nome',
            'tipo' => 'Tipo',
            'hash' => 'Hash',
            'solicitacao_id' => 'Solicitacao ID',
        ];
    }

    /**
     * @inheritdoc
     * @return AnexoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AnexoQuery(get_called_class());
    }
}
