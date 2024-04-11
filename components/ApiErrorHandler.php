<?php
namespace app\components;

use Yii;
use yii\web\ErrorHandler;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class ApiErrorHandler extends ErrorHandler
{
    protected function renderException($exception)
    {
        if (Yii::$app->has('response')) {
            $response = Yii::$app->getResponse();
            $response->format = Response::FORMAT_JSON;

            if ($exception instanceof NotFoundHttpException) {
                $response->statusCode = 404;
                $response->data = [
                    'name' => 'Not Found',
                    'message' => 'The requested resource was not found.',
                    'code' => 0,
                    'status' => 404,
                    'type' => 'yii\\web\\NotFoundHttpException',
                ];
            } else {
                $response->data = $this->convertExceptionToArray($exception);
            }

            $response->send();
        } else {
            Yii::error($exception, __METHOD__);
            echo $this->convertExceptionToString($exception);
        }
    }
}