<?php

namespace backend\controllers;

use common\components\Utils;
use common\models\Advertisement;
use common\models\Category;
use common\models\Product;
use common\models\ProductImages;
use common\models\ProductSearch;
use common\models\RelatedProduct;
use common\models\SimilarProduct;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],

            ]
        );
    }

    /**
     * Lists all Product models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Product model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Product();

        if ($this->request->isPost) {

            if ($model->load($this->request->post())) {
                $images = UploadedFile::getInstances($model, 'productImages');

                [$not_uploaded, $uploaded] = $model->upload($images);

                if (count($not_uploaded) > 0) {

                    $model->addError('productImages', "Size is exceeded");

                }
                elseif ($model->category) {

                    $category_id = $model->category['id'];
                    $ad = Category::findOne($category_id)->advertisement;
//                    Utils::printAsError($ad->name);
                    if ($ad) {
                        $model->is_discount = true;
                        $model->discount_price = $model->price - (int)$ad->name * $model->price / 100;
                        $model->save();
                        Yii::$app->db->createCommand()->insert('advertisement_products', [
                            'product_id' => $model->id,
                            'advertisement_id' => $ad->id,
                        ])->execute();
                    }else{
                        $model->save();
                    }


//                    Utils::printAsError($model);

                    ProductImages::updateAll(['product_id' => $model->id], ['id' => $uploaded]);

//                    Utils::printAsError($model->similar_product_ids);

                    $this->saveSimilarProducts($model->id,$model->similar_product_ids);
                    $this->saveRelatedProducts($model->id,$model->related_product_ids);


                    return $this->redirect(['view', 'id' => $model->id]);
                }
                else{

                    $model->save();

//                    Utils::printAsError($model);

                    ProductImages::updateAll(['product_id' => $model->id], ['id' => $uploaded]);

//                    Utils::printAsError($model->similar_product_ids);

                    $this->saveSimilarProducts($model->id,$model->similar_product_ids);
                    $this->saveRelatedProducts($model->id,$model->related_product_ids);


                    return $this->redirect(['view', 'id' => $model->id]);
                }


            }
        }

        return $this->render('create', [
            'model' => $model

        ]);
    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->similar_product_ids = SimilarProduct::find()
            ->select('similar_product_id')
            ->where(['product_id' => $id])
            ->column();
        $model->related_product_ids = RelatedProduct::find()
            ->select('related_product_id')
            ->where(['product_id' => $id])
            ->column();
//        Utils::printAsError($model->related_product_ids);
        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {

            $images = UploadedFile::getInstances($model, 'productImages');

            [$not_uploaded, $uploaded] = $model->upload($images);
            ProductImages::updateAll(['product_id' => $model->id,], ['id' => $uploaded]);

            $this->saveSimilarProducts($model->id, $model->similar_product_ids);
            $this->saveRelatedProducts($model->id,$model->related_product_ids);

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,


        ]);
    }

    protected function saveSimilarProducts($productId,$similarProductIds){

        SimilarProduct::deleteAll(['product_id' => $productId]);
//        Utils::printAsError($similarProductIds);
        if ($similarProductIds) {
            foreach ($similarProductIds as $similarProductId) {
                $model = new SimilarProduct();
                $model->product_id = $productId;
                $model->similar_product_id = $similarProductId;
                $model->save();
            }
        }
    }

    protected function saveRelatedProducts($productId,$relatedProductIds){

        if (!empty($relatedProductIds)) {
            RelatedProduct::deleteAll(['product_id' => $productId]);
            $rows=[];
            foreach ($relatedProductIds as $relatedProductId) {
                $rows[]=[$productId,$relatedProductId];
            }
//            Utils::printAsError($rows);
            Yii::$app->db->createCommand()->batchInsert('related_product',
                ['product_id','related_product_id'],
                $rows)->execute();
        }

    }
    public function actionImgDelete($id)
    {
        $model = ProductImages::findOne($id);
        $model->delete();
        return 'done';
    }

    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
