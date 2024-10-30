<?php

namespace frontend\controllers;

use common\components\Utils;
use common\models\Blog;
use common\models\Review;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * BlogController implements the CRUD actions for Blog model.
 */
class BlogController extends Controller
{
    /**
     * @inheritDoc
     */
    public $layout = 'layout_some';
//    public function behaviors()
//    {
//        return [
//            [
//                'verbs' => [
//                    'class' => VerbFilter::className(),
//                    'actions' => [
////                        'delete' => ['POST'],
//                    ],
//                ],
//            ]];
//    }
     public function beforeAction($action)
     {
         if ($action->id == 'delete')
         {
             $this->enableCsrfValidation = false;
         }
         return parent::beforeAction($action); // TODO: Change the autogenerated stub
     }

    /**
     * Lists all Blog models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Blog::find(),

            'pagination' => [
                'pageSize' => 5
            ],
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC,
                ]
            ],

        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Blog model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model=$this->findModel($id);
        $reviews= $model->getReviews()->where(['approved'=>1])->all();
//        Utils::printAsError($reviews);

        $newReview= new Review();

        if ($newReview->load(Yii::$app->request->post()) and Yii::$app->request->isAjax) {

            if (!$newReview->save())
            {
                var_dump($newReview->errors);
                exit;
            }

            $newReview->blog_id=$id;
            $newReview->user_id = Yii::$app->user->id;

            $newReview->save();

            return $this->renderAjax('view', [
                'model' => $model,
                'reviews' => $reviews,
                'newReview' => new Review(), // Reset the form
            ]);

        }
        return $this->render('view', [
            'model' => $model,
            'reviews' => $reviews,
            'newReview' => $newReview,
        ]);
    }

    /**
     * Creates a new Blog model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Blog();

        if ($this->request->isPost) {

            $image=UploadedFile::getInstances($model, 'image');

            $path=Utils::uploadImage($image[0]);



            if ($model->load($this->request->post())) {


                $model->image=$path;
//                Utils::printAsError($model);
                $model->save();
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
     * Updates an existing Blog model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post())) {

            $image=UploadedFile::getInstances($model, 'image');
            if(!empty($image)){
                $path=Utils::uploadImage($image[0]);
                Blog::updateAll(['image'=>$path],['id'=>$id]);
//            Utils::printAsError($path);
            }
            else{
                $model->image = $model->getOldAttribute('image');
            }

            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Blog model.
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
    public function actionImgDelete($id){
        $model = Blog::findOne($id);
        $model->image = "";
//        Utils::printAsError($model->errors);
        $model->save();

        return 'done';
    }

    /**
     * Finds the Blog model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Blog the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Blog::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}