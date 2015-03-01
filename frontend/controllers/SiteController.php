<?php
namespace frontend\controllers;

use common\components\Controller;
use Yii;

/**
 * Site controller
 */
class SiteController extends Controller
{
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class'=> 'yii\captcha\CaptchaAction',
                'width'=>110,'height'=>30,'minLength'=>2,'maxLength'=>4,
                'padding'=>0,'backColor'=>0xEEEEEE,'offset'=>4
            ]
        ];
    }
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogin(){
        return $this->render('login');
    }

}