<?php

namespace app\modules\api\controllers;

use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;

class ProductController extends ActiveController
{
    public $modelClass = 'app\models\Product';
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
            $searchModel = new \app\models\ProductSearch();
            
            $params = \Yii::$app->request->queryParams;
            $params['ProductSearch'] = [
                'customer_id' => \Yii::$app->request->get('customer_id'),
            ];
            $params['pageSize'] = \Yii::$app->request->get('pageSize') ?: 20;
            $params['page'] = \Yii::$app->request->get('page') ?: 1;
    
            return $searchModel->search($params);
        };
    
        return $actions;
    }
}