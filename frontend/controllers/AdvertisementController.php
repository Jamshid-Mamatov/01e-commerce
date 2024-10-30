<?php

namespace frontend\controllers;

use common\components\Utils;
use common\models\Advertisement;
use yii\data\ActiveDataProvider;
use yii\data\Sort;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class AdvertisementController extends \yii\web\Controller
{
    public $layout = 'layout_some';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout', 'card'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
            'captcha' => [
                'class' => \yii\captcha\CaptchaAction::class,
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }


    public function actionIndex($id)
    {
        $advertisement = Advertisement::findOne($id);
//        if ($advertisement->type=="product"){
        $products = $advertisement->getProducts();
        $sort = new Sort([
            'defaultOrder' => ['name' => SORT_ASC],  // Default sorting
            'attributes' => [
                'name' => [
                    'asc' => ['name' => SORT_ASC],
                    'desc' => ['name' => SORT_DESC],
                    'default' => SORT_ASC,
                    'label' => 'Name',
                ],
                'price' => [
                    'asc' => ['price' => SORT_ASC],
                    'desc' => ['price' => SORT_DESC],
                    'default' => SORT_ASC,
                    'label' => 'Price',
                ],
                'created_at' => [
                    'asc' => ['created_at' => SORT_ASC],
                    'desc' => ['created_at' => SORT_DESC],
                    'default' => SORT_DESC,
                    'label' => 'Date',
                ],
                // Add more custom attributes if needed
            ],
        ]);
        $dataProvider = new ActiveDataProvider([
            'query' => $products,
            'pagination' => [
                'pageSize' => 5,
            ],
            'sort' => $sort
        ]);
//            Utils::printAsError($dataProvider);

        return $this->render('index', [
            'advertisement' => $advertisement,
            'dataProvider' => $dataProvider,
            'id' => $id,
        ]);
//

    }


}