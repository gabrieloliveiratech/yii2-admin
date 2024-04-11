<?php

namespace app\commands;

use Yii;
use yii\console\Controller;
use app\models\User;

class UserController extends Controller
{
    public function actionCreate($name, $username, $password)
    {
        $user = new User();
        $user->name = $name;  // Save the name
        $user->username = $username;
        $user->password = Yii::$app->getSecurity()->generatePasswordHash($password);
        
        if ($user->save()) {
            echo "User {$username} created successfully.\n";
        } else {
            echo "Failed to create user.\n";
            print_r($user->errors);  // Add this line to print out the validation errors
        }
    }
}