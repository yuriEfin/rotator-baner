<?php

namespace gambit\banner\rotator\models;

use Yii;

/**
 * This is the model class for table "{{%banner_counter}}".
 *
 * @property integer $id
 * @property integer $banner_id
 * @property integer $counter
 */
class BannerCounter extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%banner_counter}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['banner_id', 'counter'], 'required'],
            [['banner_id', 'counter'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'banner_id' => Yii::t('app', '#ID баннера'),
            'counter' => Yii::t('app', 'Количество показов'),
        ];
    }

    /**
     * @inheritdoc
     * @return BannerCounterQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new BannerCounterQuery(get_called_class());
    }
}
