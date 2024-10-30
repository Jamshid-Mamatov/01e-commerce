<?php

namespace frontend\controllers;

use common\components\Utils;
use common\models\Product;
use common\models\ProductSearch;
use common\models\RecentlyViewedProduct;
use common\models\Review;
use Yii;
use yii\db\Expression;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller
{
    /**
     * @inheritDoc
     */
    public $layout="layout_some";
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
        $product = Product::findOne($id);
        $reviews = Review::find()->where(['product_id' => $id,'approved'=>1])->all();

        $newReview = new Review();


        // If the form is submitted
        if ($newReview->load(Yii::$app->request->post()) && Yii::$app->request->isAjax) {
//

            if (!$newReview->save())
            {
                var_dump($newReview->errors);
                exit;
            }

            $newReview->product_id = $id;
            $newReview->user_id = Yii::$app->user->id;
            $newReview->save();

            // Return the updated reviews and form if it's a PJAX request
            return $this->renderAjax('view', [
                'model' => $product,
                'reviews' => $reviews,
                'newReview' => new Review(), // Reset the form
            ]);

        }


        $this->saveRecentlyViewed($id);

        $recentlyViewedProducts = $this->getRecentlyViewedProducts(5);

        return $this->render('view', [
            'model' => $product,
            'reviews' => $reviews,
            'newReview' => $newReview,
            'recentlyViewedProducts' => $recentlyViewedProducts,
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
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
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

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
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



    public function saveRecentlyViewed($id){
        $user_id = Yii::$app->user->isGuest ? null : Yii::$app->user->identity->getId();

        if(!$user_id){
            $session = Yii::$app->session;
            $recentlyViewed=$session->get('recentlyViewed',[]);
//            Utils::printAsError($recentlyViewed);
            if (!in_array($id,$recentlyViewed)){
                $recentlyViewed[]=$id;
                $session->set('recentlyViewed',$recentlyViewed);
            }
        }else{
                $recentlyViewed= RecentlyViewedProduct::findOne(['user_id'=>$user_id,'product_id'=>$id]);

                if (!$recentlyViewed){
                    $recentlyViewed = new RecentlyViewedProduct();
                    $recentlyViewed->user_id = $user_id;
                    $recentlyViewed->product_id = $id;
        //            Utils::printAsError($recentlyViewed);
                    $recentlyViewed->save();
                }
                else{
                    $recentlyViewed->viewed_at=new Expression('NOW()');
                    $recentlyViewed->save();
                }
            }
    }

    public function getRecentlyViewedProducts($limit=5)
    {
        $user_id = Yii::$app->user->isGuest ? null : Yii::$app->user->identity->getId();

        if (!$user_id){
            $session = Yii::$app->session;
            $recentlyViewedIds=$session->get('recentlyViewed',[]);
//            Utils::printAsError($recentlyViewedIds);
            if (!empty ($recentlyViewedIds)){
                return Product::find()
                    ->where(['id' => $recentlyViewedIds])
                    ->orderBy([new \yii\db\Expression('FIELD(id, ' . implode(',', $recentlyViewedIds) . ')')])
                    ->limit($limit)
                    ->all();
            }
        }else{

           $recentlyViewed=RecentlyViewedProduct::find()->where(['user_id'=>$user_id])->limit($limit)->all();
           $productIds=array_map(function($item){
               return $item->product_id;
           },$recentlyViewed);

           if (!empty ($productIds)){
               return Product::find()
                   ->where(['id' => $productIds])
                   ->orderBy([new \yii\db\Expression('FIELD(id, ' . implode(',', $productIds) . ')')])
                   ->limit($limit)
                   ->all();

           }
        }


        return [];
    }



}
