<?php

namespace gambit\banner\rotator\models;

use Yii;

/**
 * This is the model class for table "{{%banner}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $path_file
 * @property integer $width
 * @property integer $height
 * @property string $alt
 */
class Banner extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%banner}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'path_file'], 'required'],
            [['width', 'height'], 'integer'],
            [['title', 'path_file', 'alt'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Заголовок баннера'),
            'path_file' => Yii::t('app', 'Путь к баннерам'),
            'width' => Yii::t('app', 'Ширина баннера'),
            'height' => Yii::t('app', 'Высота баннера'),
            'alt' => Yii::t('app', 'Alt описание'),
        ];
    }

    /**
     * @inheritdoc
     * @return BannerQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new BannerQuery(get_called_class());
    }
}
