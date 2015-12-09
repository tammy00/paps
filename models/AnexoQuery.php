<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Anexo]].
 *
 * @see Anexo
 */
class AnexoQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return Anexo[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Anexo|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
