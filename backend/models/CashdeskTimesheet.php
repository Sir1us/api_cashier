<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "cashdesk_timesheet".
 *
 * @property integer $id
 * @property integer $cashier
 * @property integer $cashdesk
 * @property string $opendt
 * @property string $closedt
 */
class CashdeskTimesheet extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cashdesk_timesheet';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'cashier', 'cashdesk', 'opendt'], 'required'],
            [['id', 'cashier', 'cashdesk'], 'integer'],
            [['opendt', 'closedt'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cashier' => 'Cashier',
            'cashdesk' => 'Cashdesk',
            'opendt' => 'Opendt',
            'closedt' => 'Closedt',
        ];
    }
}
