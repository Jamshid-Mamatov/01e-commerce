<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var common\models\Blog $model */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Blogs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="blog-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>
</div>



<div class="blog-grid pb-100px pt-100px main-blog-page single-blog-page">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-12 offset-lg-2">
                <div class="blog-posts">
                    <div class="single-blog-post blog-grid-post">
                        <div class="blog-image single-blog">
                            <?= Html::img($model->getImageUrl(),['class'=>"img-fluid h-auto border-radius-10px",'alt'=>Html::encode($model->title)])?>
                        </div>
                        <div class="blog-post-content-inner mt-30px">
                            <div class="blog-athor-date">
                               <span class="blog-date">
                                <i class="fa fa-calendar" aria-hidden="true"></i>
                                <?= Yii::$app->formatter->asDate($model->created_at,'php:d, M Y')?>
                                </span>
                                <span>
                                    <a class="blog-author" href="<?= Url::to(['site/account'])?>"> <i class="fa fa-user" aria-hidden="true"></i> <?= Html::encode($model->user->username)?></a>
                                </span>
                            </div>
                            <h4 class="blog-title"><?= Html::encode($model->title) ?></h4>
                            <p data-aos="fade-up">
                                <?= nl2br(Html::encode($model->getShortDescription())) ?>
                            </p>
                            <div class="single-post-content">
                                <p data-aos="fade-up" data-aos-delay="200">
                                    <?= nl2br(Html::encode($model->body)) ?>
                                </p>
                            </div>
                        </div>

                    </div>

                </div>

                <div id="des-details3" class="tab-pane">
                    <div class="row">
                        <div class="col-lg-12" id="review-form">
                            <?php Pjax::begin(['id'=>'review-pjax','enablePushState'=>false,'timeout'=>false]); ?>


                            <?= \common\components\ReviewWidget::widget([
                                'newReview' => $newReview,
                                'productId' => $model->id,
                                'reviews' => $reviews,
                            ]) ?>

                            <?php Pjax::end(); ?>
                        </div>
                    </div>
                </div>

            </div>
<!--            --><?php //Pjax::begin(['id'=>'review-pjax','enablePushState'=>false,'timeout'=>false]); ?>
<!---->
<!---->
<!--            --><?php //= \common\components\ReviewWidget::widget([
//                'newReview' => $newReview,
//                'productId' => $model->id,
//                'reviews' => $reviews,
//            ]) ?>
<!---->
<!--            --><?php //Pjax::end(); ?>
        </div>
    </div>
</div>
