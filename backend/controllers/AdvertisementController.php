<?php

namespace backend\controllers;

use common\components\Utils;
use common\models\Advertisement;
use common\models\AdvertisementSearch;
use common\models\Category;
use common\models\Product;
use Mpdf\Tag\P;
use Yii;
use yii\rbac\Assignment;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AdvertisementController implements the CRUD actions for Advertisement model.
 */
class AdvertisementController extends Controller
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
     * Lists all Advertisement models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new AdvertisementSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Advertisement model.
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
     * Creates a new Advertisement model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Advertisement();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Advertisement model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Advertisement model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {

        $products=Product::find()
            ->select('product.id')
            ->innerJoin('advertisement_products','product.id=advertisement_products.product_id')
            ->where(['advertisement_products.advertisement_id'=>$id])
            ->column();
//        Utils::printAsError($products);
        $ad=$this->findModel($id);
        $this->unlinkProducts($ad,$products);
        $ad->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Advertisement model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Advertisement the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Advertisement::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    public function actionAssign($id)
    {
        $advertisement = $this->findModel($id);
        $type = $advertisement->type;

        $ad_value=(int) $advertisement->name;

        if ($type == "category") {
            $assigned = $advertisement->getCategories();
//            Utils::printAsError($assigned,true);
            $allCategories = Category::find()->all();
            $data = array_filter($allCategories, function ($item) use ($assigned) {
                return !in_array($item->id, $assigned->select(['id'])->column());
            });


        } elseif ($type == "product") {
            $assigned = $advertisement->getProducts();

            $allProducts = Product::find()->all();
//            Utils::printAsError($allProducts);
            $data = array_filter($allProducts, function ($item) use ($assigned) {
                return !in_array($item->id, $assigned->select(['id'])->column());
            });
//            Utils::printAsError($data);
        }

        if (Yii::$app->request->isPost) {

            $selectedIds = $this->request->post('selectedIds');
//            Utils::printAsError($selectedIds);

            $unselectedIds = $this->request->post('unselectedIds');
//            Utils::printAsError($unselectedIds);

            $advertisement->linkAll($selectedIds,$ad_value);
            if ($advertisement->type == "category" and $selectedIds) {
                $productIds=[];
                foreach ($selectedIds as $id) {
                    $productIds[]=Advertisement::getAllProductsUnderCategory($id);
                }
                $selectedIds=array_unique(array_merge(... $productIds));
                $advertisement->linkAll($selectedIds,$ad_value,$table='advertisement_products');
            }


            if ($unselectedIds!=null) {
                if ($advertisement->type == "product") {
                    $this->unlinkProducts($advertisement,$unselectedIds);

//                Utils::printAsError($model);
                } else {
                    $name = "categories";
                    $model = $advertisement->getCategories()->where(['id' => $unselectedIds])->all();

                    if ($model!=null){


                        foreach ($model as $item){
                            $advertisement->unlink($name, $item, true);
                        }
                        $productIds=[];
                        foreach ($unselectedIds as $id) {
                            $productIds[]=Advertisement::getAllProductsUnderCategory($id);
                        }
                        $unselectedIds=array_unique(array_merge(... $productIds));
                        $this->unlinkProducts($advertisement,$unselectedIds);
                    }


                }
                $this->refresh();

                Yii::$app->session->setFlash('success', 'Advertisement assigned to category.');
            }
            $this->refresh();
        }



        $this->deleteExpiredAds($advertisement);


        return $this->render('assign', [
            'advertisement' => $advertisement,
            'data' => $data,
            'assigned' => $assigned,
        ]);

    }

    public function deleteExpiredAds($advertisement)
    {
        $currentTime = new \DateTime();
        $expiredAds = Advertisement::find()->where([
            '<', 'end_date', $currentTime->format('Y-m-d')
        ])->all();

        foreach ($expiredAds as $ad) {

            // Delete each expired ad
            if ($ad->type == "product") {

                $p_ids=$ad->getProducts()->select('id')->all();
//                Utils::printAsError($p_ids);
                $ad->unlinkAll('products', true);
                $this->unlinkProducts($ad,$p_ids);
            }else{
                $ad->unlinkAll('products', true);
                $ad->unlinkAll('categories', true);
                $category_ids = $ad->getCategories()->select('id')->column();
                $model = $ad->getCategories()->where(['id' => $category_ids])->all();
                $name = "categories";
                if ($model!=null){


                    foreach ($model as $item){
                        $advertisement->unlink($name, $item, true);
                    }
                    $productIds=[];
                    foreach ($category_ids as $id) {
                        $productIds[]=Advertisement::getAllProductsUnderCategory($id);
                    }
                    $unselectedIds=array_unique(array_merge(... $productIds));
                    $this->unlinkProducts($advertisement,$unselectedIds);
                }

            }

            if ($ad->delete()) {
                Yii::$app->session->setFlash('success', 'Expired ad ' . $ad->name . ' has been deleted.');
            } else {
                Yii::$app->session->setFlash('error', 'Failed to delete expired ad ' . $ad->name . '.');
            }
        }

    }

    public function unlinkProducts($ad,$p_ids){
        $model = $ad->getProducts()->where(['id' => $p_ids])->all();
        foreach ($model as $item) {

            $product=Product::findOne($item->id);
            $product->is_discount=false;
            $product->save();

            $ad->unlink("products", $item, true);

        }
    }

}
