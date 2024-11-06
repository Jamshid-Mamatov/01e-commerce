<?php

namespace backend\modules\api\controllers;

use backend\resource\Category;
use common\components\Utils;
use backend\resource\Product;
use common\models\ProductImages;
use Yii;
use yii\data\ActiveDataFilter;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;
use yii\helpers\ArrayHelper;
use yii\rest\ActiveController;
use yii\rest\Controller;
use yii\web\UploadedFile;

class ProductController extends \backend\modules\api\controllers\ActiveController
{
    public $modelClass = Product::class;



    public function actions()
    {
        $actions = parent::actions();

        // disable the "delete" and "create" actions
        unset($actions['index'],$actions['create'],$actions['update']);


        return $actions;
    }


    public function actionIndex()
    {

        $filter = new ActiveDataFilter([
            'searchModel' => 'common\models\ProductSearch',

        ]);

        $filterCondition = null;

        if ($filter->load(Yii::$app->request->get())) {
            $filterCondition = $filter->build();
            if ($filterCondition === false) {
                // Serializer would get errors out of it
                return $filter;
            }
        }
        $query = Product::find();
        if ($filterCondition !== null) {
            $query->andWhere($filterCondition);
        }


        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 3], // Set this to false to avoid automatic pagination in the response
        ]);
    }

    public function actionCreate(){

        $product = new Product();
        return $this->extracted($product);
    }

    public function actionUpdate($id){
        $product = Product::findOne($id);
        return $this->extracted($product);
    }

    /**
     * @param Product|null $product
     * @return array|Product|null
     * @throws \yii\db\Exception
     */
    public function extracted(?Product $product)
    {
        $product->load(Yii::$app->request->post(), '');

        if ($product->save()) {
            $image = UploadedFile::getInstancesByName('image');
//            Utils::printAsError($image);
            [$not_uploaded, $uploaded] = $product->upload($image);
//            Utils::printAsError($uploaded);
            ProductImages::updateAll(['product_id' => $product->id], ['id' => $uploaded]);
            return $product;
        } else {
            return ['errors' => $product->errors];
        }
    }

//    public function actionCategoryProducts(){
////        Utils::printAsError($this->modelClass::find()->andWhere(['category_id' => \Yii::$app->request->get('id')]));
//        return new ActiveDataProvider([
//            'query' => $this->modelClass::find()->andWhere(['category_id' => \Yii::$app->request->get('id')]),
//        ]);
//    }


}