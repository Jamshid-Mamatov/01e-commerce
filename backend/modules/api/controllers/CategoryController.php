<?php

namespace backend\modules\api\controllers;


use backend\resource\Category;
use yii\data\ActiveDataProvider;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\Controller;

class CategoryController extends ActiveController
{

    public $modelClass = Category::class;

    public function actions()
    {
        $actions = parent::actions();

//        unset($actions['create']);
        return $actions;
    }

    public function actionIndex(){

        return new ActiveDataProvider([
            'query'=>Category::find(),
            'pagination'=>[
                'pageSize'=>5,
            ],
        ]);
    }

    public function actionView($id){
        $category=Category::findOne($id);
        return $category;
    }

}