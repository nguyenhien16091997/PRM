<?php

namespace app\controllers;

class PrmController extends \yii\web\Controller
{
    public function actionIndex()
    {
    	//$this->layout='mainWork';
        return $this->render('index');
    }
}
