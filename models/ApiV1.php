<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for the search
 * @property string $name
 */
//class ApiV1 extends \yii\db\ActiveRecord
class ApiV1 extends Model
{
    public $name;
    public $score;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('app', 'Full Name'),
        ];
    }

    public function search($name){
        $this->name = $name;
        $this->score =  mt_rand(1, 99);
    }
}
