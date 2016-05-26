<?php

namespace backend\controllers;

use backend\models\CashdeskTimesheet;
use backend\models\Cashier;
use Yii;


class CashiersShiftController extends \yii\web\Controller
{

    public function beforeAction($action)
    {
        // ...set `$this->enableCsrfValidation` here based on some conditions...
        // call parent method that will check CSRF if such property is true.
        if ($action->id === 'index') {
            
            $this->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }


    public function actionIndex()
    {
        $NecessaryDate = '(^(((\d\d)(([02468][048])|([13579][26]))-02-29)|(((\d\d)(\d\d)))-((((0\d)|(1[0-2]))-((0\d)|(1\d)|(2[0-8])))|((((0[13578])|(1[02]))-31)|(((0[1,3-9])|(1[0-2]))-(29|30)))))$)';
        $start_date = Yii::$app->request->post('date_from');
        $end_date = Yii::$app->request->post('date_to');
        if (Yii::$app->request->post('table') == 'shifts') {
            if (isset($start_date) && isset($end_date)) {
                if (preg_match($NecessaryDate, $start_date) && preg_match($NecessaryDate, $end_date)) {


                    $TakeShifts = CashdeskTimesheet::find()->
                    where(['BETWEEN', 'opendt', $start_date, $end_date])->
                    orWhere(['BETWEEN', 'closedt', $start_date, $end_date])->
                    asArray()->all();

                    if (!empty($TakeShifts) && isset($TakeShifts) && $TakeShifts !== null && $TakeShifts !== '') {


                        $CashierDataResult = [];
                        foreach ($TakeShifts as $valueShifts) {
                            $jsonValuesForCashierDate = new \stdClass();
                            $jsonValuesForCashierDate->shift_id = $valueShifts['id'];
                            $jsonValuesForCashierDate->shift_cashdesk = $valueShifts['cashdesk'];
                            $jsonValuesForCashierDate->shift_opendt = $valueShifts['opendt'];
                            $jsonValuesForCashierDate->shift_closedt = $valueShifts['closedt'];
                            $jsonValuesForCashierDate->cashier_id = $valueShifts['cashier'];

                            $TakeCashier = Cashier::find()->where(['=', 'id', $valueShifts['cashier']])->orderBy('id')->limit(1)->asArray()->all();
                            if (empty($TakeCashier)) {
                                //$jsonValuesForCashierDate = '{"Ошибка"}';
                                $jsonValuesForCashierDate->cashier_id = "Ошибка";
                                $CashierDataResult[] = $jsonValuesForCashierDate;
                            } else {
                                foreach ($TakeCashier as $valueCashiers) {
                                    $jsonValuesForCashierDate->cashier_name = $valueCashiers['name'];
                                    $jsonValuesForCashierDate->cashier_second_name = $valueCashiers['second_name'];
                                    $CashierDataResult[] = $jsonValuesForCashierDate;

                                }
                            }
                        }
                        $CashierDataResult = json_encode($CashierDataResult);

                        echo $CashierDataResult;

                    } else {

                        echo '[{"error": "Нет данных"}]';

                    }
                } else {

                    echo '[{"error": "Невалидный параметр date_from / date_to"}]';
                }
            } else {

                echo '[{"error": "Невалидный параметр date"}]';

            }
        } else {

            echo '[{"error": "Невалидный параметр table"}]';
        }
    }

}
