<?php

namespace backend\modules\api\controllers;

use common\models\User;
use Yii;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\Controller;

class AuthController extends Controller
{

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        // Set up HTTP Bearer Authentication
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class,
            'except' => ['index', 'view','login'],  // Public actions
        ];

        return $behaviors;
    }
    public function actionRegister(){
        $model= new User();
        $model->scenario=User::SCENARIO_REGISTER;
        $model->load(Yii::$app->request->post(),'');
        if ($model->validate() && $model->save()){
            return ['message'=>'Registration successful'];
        }

        return $model->errors;
    }

    public function actionLogin(){
        Yii::info('Login action triggered', __METHOD__);

        $username=Yii::$app->request->post('username');
        $password=Yii::$app->request->post('password');
        $user=User::findOne(['username'=>$username]);

        if ($user && $user->validatePassword($password)){
            return ['token'=>$user->generateAccessToken()];
        }
        return $user->errors;
    }
}