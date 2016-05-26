<?php
namespace backend\controllers;


use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use common\models\LoginForm;
use yii\filters\VerbFilter;
use linslin\yii2\curl;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionPostExample()
    {
        //Init curl
        $curl = new curl\Curl();

        //post http://example.com/
        $response = $curl->setOption(
            CURLOPT_POSTFIELDS,
            http_build_query(array(
                    'table' => 'cashierdata'

                )
            ))
            ->post('http://test.local/backend/web/cashier');
    }
    /*public function actionPostExample()
    {
        //Init curl
        $curl = new curl\Curl();

        //post http://example.com/
        $response = $curl->setOption(
            CURLOPT_POSTFIELDS,
            http_build_query(array(
                    'table' => 'shifts',
                    'date_from' => '2016-04-01',
                    'date_to' => '2016-05-01'
                )
            ))
            ->post('http://test.local/backend/web/cashiers-shift');
    }*/

    public function beforeAction($action)
    {
        // ...set `$this->enableCsrfValidation` here based on some conditions...
        // call parent method that will check CSRF if such property is true.
            $this->enableCsrfValidation = false;
                if (Yii::$app->request->post('table') && Yii::$app->request->post('date_from') && Yii::$app->request->post('date_to')){

                    return (new CashiersShiftController($this->id, $this->module))->actionIndex();

                } elseif (Yii::$app->request->post('table')) {

                    return (new CashierController($this->id, $this->module))->actionIndex();

                } else {
                    return $this->actionPostExample();
                }

        return false;
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

}
