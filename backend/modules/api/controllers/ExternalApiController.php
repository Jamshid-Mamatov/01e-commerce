<?php

namespace backend\modules\api\controllers;

use yii\rest\Controller;
use yii\httpclient\Client;
class ExternalApiController extends Controller
{

    public function actionIndex(){

        $client= new Client();
        $request= $client->createRequest()
            ->setMethod('GET')
            ->setUrl('https://petstore3.swagger.io/api/v3/pet/2')
            ->addHeaders(['Authorization' => 'Bearer '.\Yii::$app->request->get('token')]);

        $response= $request->send();

        if ($response->isOk) {
            return $response->data;
        }
        else{
            return [
                'error'=>true,
                'message'=>$response->data['message']
            ];
        }

    }
}