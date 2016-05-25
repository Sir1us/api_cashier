<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "cashier_agreements".
 *
 * @property integer $id
 * @property string $number
 * @property string $date_from
 * @property string $date_to
 */
class CashierAgreements extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cashier_agreements';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date_from', 'date_to'], 'safe'],
            [['number'], 'string', 'max' => 40]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'number' => 'Number',
            'date_from' => 'Date From',
            'date_to' => 'Date To',
        ];
    }
}
