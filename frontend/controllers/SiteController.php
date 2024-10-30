<?php

namespace frontend\controllers;

use common\components\Utils;
use common\models\Advertisement;
use common\models\Cart;
use common\models\CartItem;
use common\models\Category;
use common\models\Order;
use common\models\Product;
use common\models\RecentlyViewedProduct;
use common\models\User;
use common\models\Wishlist;
use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;

/**
 * Site controller
 */
class SiteController extends Controller
{
    public $layout = 'layout_some';
    /**
     * {@inheritdoc}
     */
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
                        'actions' => ['logout','card'],
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

    /**
     * {@inheritdoc}
     */
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

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $cookies = Yii::$app->request->cookies;
//        echo "<pre>";
//        var_dump(Yii::$app->session->getCookieParams());
//        var_dump($cookies->getValue('language', 'en'));
//        var_dump(Yii::$app->session);
//        echo "</pre>";
//        die;
//        Utils::printAsError(Yii::$app->language);
        $products=Product::find()->all();
        $oneDayAgo=(new \DateTime('now'))->modify('-1 day')->format('Y-m-d H:i:s');
//        Utils::printAsError($oneDayAgo);
        $newArrivals = Product::find()
            ->where(['>', 'created_at', $oneDayAgo]) // Adjust this as per your timestamp logic
            ->all();

        return $this->render('index',['products'=>$products,'newarrivals'=>$newArrivals]);
    }
    public function actionCategory($id){
        $category=Category::findOne($id);

        return $this->render('category',['category'=>$category]);
    }
    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        }

        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');
            return $this->goHome();
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            }

            Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Verify email address
     *
     * @param string $token
     * @throws BadRequestHttpException
     * @return yii\web\Response
     */
    public function actionVerifyEmail($token)
    {
        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if (($user = $model->verifyEmail()) && Yii::$app->user->login($user)) {
            Yii::$app->session->setFlash('success', 'Your email has been confirmed!');
            return $this->goHome();
        }

        Yii::$app->session->setFlash('error', 'Sorry, we are unable to verify your account with provided token.');
        return $this->goHome();

//        this line is not generated by yii2
//        $user = User::find()->where(['verification_token' => $token])->one();
//        if (!$user) {
//            throw new BadRequestHttpException('invalid token');
//
//        }
//        $user->status = User::STATUS_ACTIVE;
//        $user->verification_token = null;
//        $user->save();
//        Yii::$app->session->setFlash('success', 'Your email has been confirmed!');
//        return $this->goHome();
    }

    /**
     * Resend verification email
     *
     * @return mixed
     */
    public function actionResendVerificationEmail()
    {
        $model = new ResendVerificationEmailForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            }
            Yii::$app->session->setFlash('error', 'Sorry, we are unable to resend verification email for the provided email address.');
        }

        return $this->render('resendVerificationEmail', [
            'model' => $model
        ]);
    }

//    public function actionCart(){
//
//        $cart=Cart::getUserCart();
//
//        return $this->render('cart',['cart'=>$cart]);
//    }

    public function actionAccount(){

        $user=Yii::$app->user->identity;
        $order_query=Order::find()
            ->where(['user_id'=>Yii::$app->user->identity->id])
            ->orderBY('created_at DESC');
        $dataProvider=new ActiveDataProvider([
            'query'=>$order_query,
            'pagination'=>[
                'pageSize'=>5,
            ]
        ]);
        $user_info=User::findOne($user->id);



        return $this->render('account',[
            'dataProvider'=>$dataProvider,
            'user_info'=>$user_info,
        ]);
    }



    public function actionFormAddress(){
        $user=Yii::$app->user->identity;

        $user_info=User::findOne($user->id);
        if ($user_info->load(Yii::$app->request->post()) && $user_info->save()) {

//            Utils::printAsError($user_info);
            Yii::$app->session->setFlash('success', 'Address updated successfully.');
//            Utils::printAsError(Yii::$app->request->isPjax);
            if (Yii::$app->request->isPjax) {
//                Utils::printAsError($user_info);
                return $this->renderAjax('_addressDetails', ['user_info' => $user_info]);
            }
        }
        return $this->redirect('account');
    }

    public function actionFormAccount() {
        $user=Yii::$app->user->identity;
        $user_info=User::findOne($user->id);


//        Utils::printAsError($user_info);

        if ($user_info->load(Yii::$app->request->post()) && $user_info->save()) {

//            Utils::printAsError($user_info);
            Yii::$app->session->setFlash('success', 'Address updated successfully.');
//            Utils::printAsError(Yii::$app->request->isPjax);
            if (Yii::$app->request->isPjax) {
//                Utils::printAsError($user_info);
                return $this->renderAjax('_accountDetails', ['user_info' => $user_info]);
            }
        }
        else{
            Utils::printAsError($user_info->errors);
        }
        return $this->redirect('account');
    }
    public function actionAddToCart($id,$quantity=1){
        $this->enableCsrfValidation = false;
        $product=Product::findOne($id);
        $cart_item = new CartItem();
        $cart = Cart::getUserCart();
        $cart_item->cart_id = $cart->id;
        $cart_item->product_id=$id;
        $cart_item->quantity=$quantity;
        $cart_item->price= $product->is_discount ? $product->discount_price : $product->price;
        $cart_item->save();

        return $this->renderPartial("_cart_item", ["cart_item"=>$cart_item]);
    }

    public function actionAddToWishlist($id){
        $this->enableCsrfValidation = false;

        $wishlist = new Wishlist();


        $wishlist->product_id=$id;
        $wishlist->user_id=Yii::$app->user->id;
        $wishlist->save();

        return $this->renderPartial("_wishlist_item", ["wishlist"=>$wishlist]);
    }

    #add new controller for cart and wishlist
    public function actionLanguage($lang){

//        Utils::printAsError(Yii::$app->request->isPjax);
//        if (Yii::$app->request->isPjax) {
//            Yii::$app->language = $lang;
////            Utils::printAsError(Yii::$app->language);
//            Yii::$app->session->set('language', $lang);
//            Yii::$app->response->cookies->add(new \yii\web\Cookie([
//                'name' => 'language',
//                'value' => $lang,
//                'expire' => time() + 86400 * 30,
//            ]));
//
//            return $this->renderAjax('_language');
//        }
//        else{
//            return $this->goHome();
//        }
//        var_dump(Yii::$app->language);
//        $lang = 'ru-RU';
        $session = Yii::$app->session;

// check if a session is already open
        if (!$session->isActive) $session->open();

        Yii::$app->language = $lang; // Set the application language
        Yii::$app->session->set('language', $lang);
        $cookie = new \yii\web\Cookie([
            'name' => 'language',
            'domain' => '',
            'value' => $lang,
            'expire' => time() + 86400 * 30,
        ]);
        Yii::$app->response->cookies->add($cookie);
        Yii::$app->session->set("language",$lang);
        // return Yii::$app->language;
//        Utils::printAsError(Yii::$app->language);
        // Redirect back to the previous page or a specific page
//        echo Url::previous();
//        echo "<br>";
//        echo Url::current();
//        echo "<br>";
//        die(Yii::$app->request->referrer);
        return $this->redirect(Yii::$app->request->referrer);
    }



}
