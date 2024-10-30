<?php

use common\models\Review;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var common\models\ReviewSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Reviews');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="review-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Review'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'product_id',
            'blog_id',
            'user_id',
            'rating',
            'comment:ntext',
            //'created_at',
//            [
//                'class' => ActionColumn::className(),
//                'urlCreator' => function ($action, Review $model, $key, $index, $column) {
//                    return Url::toRoute([$action, 'id' => $model->id]);
//                 }
//            ],
            [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{approve} {disapprove} {view} {update} {delete}',
                    'buttons' => [
                            'approve' => function ($url, $model) {
                                        if ($model->approved==0){
                                            return Html::a("Approve",['approve','id'=>$model->id],
                                                [
                                                        'class'=>'btn btn-success btn-xs',
                                                        'data'=>[
                                                                'method'=>'post',
                                                                'confirm'=>'Are you sure you want to approve this review?',
                                                        ]
                                                ]);
                                        }
                                        return "";
                            },
                            'disapprove' => function ($url, $model) {
                                        if ($model->approved==1){
                                            return Html::a("Disapprove",['disapprove','id'=>$model->id],
                                                [
                                                        'class'=>'btn btn-warning btn-xs',
                                                        'data'=>[
                                                                'method'=>'post',
                                                                'confirm'=>'Are you sure you want to disapprove this review?',
                                                            ],
                                                ]);
                                        }
                                        return "";
                            }
                        ]
            ]
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
