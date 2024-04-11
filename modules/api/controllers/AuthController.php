<?php

namespace app\modules\api\controllers;

use Yii;
use yii\rest\Controller;
use app\models\LoginForm;

class AuthController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => \yii\filters\auth\HttpBearerAuth::class,
            'except' => ['login'],
        ];
        return $behaviors;
    }

    public function actionLogin()
    {
        $model = new LoginForm();

        if ($model->load(Yii::$app->request->getBodyParams(), '') && $model->login()) {
            $user = $model->getUser();
            $user->access_token = Yii::$app->security->generateRandomString();
            $user->save(false);

            return ['access_token' => $user->access_token];
        }

        return $model->getFirstErrors();
    }
}
