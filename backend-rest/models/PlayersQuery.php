<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Players]].
 *
 * @see Players
 */
class PlayersQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Players[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Players|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
