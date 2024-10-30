<?php

namespace frontend\controllers;

use common\components\Utils;
use common\models\Cart;
use common\models\CartItem;
use common\models\Order;
use common\models\Wishlist;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CartController implements the CRUD actions for Cart model.
 */
class CartController extends Controller
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
                        'custom-act' => ['POST'],

                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Cart models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $cart=Cart::getUserCart();

        return $this->render('cart',['cart'=>$cart]);
    }

    /**
     * Displays a single Cart model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $session = Yii::$app->session;
        $session->open();
        $session->set('cart',$id);
        $session->get('cart_count');
        $session->destroy();
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Cart model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Cart();

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
     * Updates an existing Cart model.
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
     * Deletes an existing Cart model.
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
     * Finds the Cart model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Cart the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Cart::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    public function actionDelCartItem($id){

        $this->enableCsrfValidation=false;

        CartItem::deleteAll(['id'=>$id]);
        return "";
    }
    public function actionCustomAct(){



        $data = Yii::$app->request->post();
        foreach($data as $k=>$v){
            $cart_item = CartItem::findOne($k);
            if ($cart_item){
                $cart_item->quantity = $v;
                $cart_item->save();
            }
        }


        return $this->redirect("/cart");
    }

    public function actionCheckout(){
        $order= new Order();
        $cart=Cart::getUserCart();
        $cart_items=CartItem::findAll(['cart_id'=>$cart->id]);


        if ($this->request->isPost && $order->load($this->request->post()) && $order->validate()) {
            $order->user_id=Yii::$app->user->id;
            $order->total_amount=Cart::totalAmount();

            $order->save();
            foreach($cart_items as $item){
                $item->order_id=$order->id;
                $item->cart_id=null;
                $item->save();
            }
            yii::$app->session->setFlash('Order is completed');
            return $this->redirect("/");
        }

        return $this->render('checkout',['cart_items'=>$cart_items,'order'=>$order]);
    }

    public function actionDelWishlistItem($id){

        $this->enableCsrfValidation=false;

        Wishlist::deleteAll(['id'=>$id]);
        return "";
    }

    public function actionViewWishlist(){

        $items=Wishlist::findAll(['user_id'=>Yii::$app->user->id]);
        return $this->render('wishlist',['items'=>$items]);
    }
}
