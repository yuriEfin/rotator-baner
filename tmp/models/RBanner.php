<?php

/**
 * This is the model class for table "banners".
 *
 * The followings are the available columns in table 'banners':
 * @property string $id
 * @property string $tpl_name
 * @property string $display
 */
class RBanner extends CActiveRecord
{

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'banners';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('tpl_name', 'required'),
            array('tpl_name', 'length', 'max' => 254),
            array('display', 'length', 'max' => 11),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, tpl_name, display', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'tpl_name' => 'Tpl Name',
            'display' => 'Display',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('tpl_name', $this->tpl_name, true);
        $criteria->compare('display', $this->display, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Banner the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * метод отображает остаток кредитов отображения по конкретному ID имени шаблона
     *
     * @param type $id
     * @return integer $credits;
     */
    public static function residual($tpl_name = '')
    {
        $conn = Yii::app()->db;

        //Residual for ID banner record
        $sql = 'SELECT `display` FROM `banners` WHERE `tpl_name` ="' . $tpl_name . '"';
        if ($tpl_name) {
            $row = $conn->createCommand($sql)->queryRow();
        }
        return $row['display'];
    }

    public static function decrementDisplay($tpl_name = '', $decrementVal = 0)
    {
        $conn = Yii::app()->db;

        //counter for ID banner record
        $sql = 'UPDATE `banners` SET `display` = `display`-' . $decrementVal
            . ' WHERE `tpl_name` ="' . $tpl_name . '"';
        if ($tpl_name && $decrementVal) {
            $row = $conn->createCommand($sql)->execute();
        }

        $sql = 'SELECT `display` FROM `banners` WHERE `tpl_name` ="' . $tpl_name . '"';
        if ($tpl_name && $row) {
            $row = $conn->createCommand($sql)->queryRow();
        }
        return $row['display'];
    }
}
