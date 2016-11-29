<?php

namespace app\controllers;

use moonland\phpexcel\Excel;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;


class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionParse($file = '')
    {
        ini_set('max_execution_time', 900);
        $data = Excel::import(Yii::getAlias('@webroot').'/'.$file);

        var_dump($data[0]);


        //return $this->render('index');
    }
}
