<?php

namespace gambit\banner\rotator\models;

/**
 * This is the ActiveQuery class for [[BannerCounter]].
 *
 * @see BannerCounter
 */
class BannerCounterQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return BannerCounter[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return BannerCounter|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
