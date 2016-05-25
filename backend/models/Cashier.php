<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "cashier".
 *
 * @property integer $id
 * @property string $name
 * @property string $second_name
 * @property integer $agreement_id
 */
class Cashier extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cashier';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['agreement_id'], 'required'],
            [['agreement_id'], 'integer'],
            [['name', 'second_name'], 'string', 'max' => 40]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'second_name' => 'Second Name',
            'agreement_id' => 'Agreement ID',
        ];
    }
}
