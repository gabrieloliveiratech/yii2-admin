<?php

namespace app\modules\api\controllers;

use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;

class CustomerController extends ActiveController
{
    public $modelClass = 'app\models\Customer';
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'data',
    ];

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => \yii\filters\auth\HttpBearerAuth::class,
        ];

        return $behaviors;
    }

    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actions()
    {
        $actions = parent::actions();

        $actions['index']['prepareDataProvider'] = function ($action) {
            $modelClass = $this->modelClass;

            $pageSize = \Yii::$app->request->get('pageSize') ?: 20;
            $page = \Yii::$app->request->get('page') ?: 1;

            return new ActiveDataProvider([
                'query' => $modelClass::find(),
                'pagination' => [
                    'pageSize' => $pageSize,
                    'page' => $page - 1,
                ],
            ]);
        };

        return $actions;
    }
}