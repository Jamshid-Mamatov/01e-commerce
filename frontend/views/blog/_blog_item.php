<?php


use yii\helpers\Html;
use yii\helpers\Url; ?>



<div class="col-12 mb-50px">
    <div class="single-blog">
        <div class="blog-image">
            <a href=" <?= Url::to(['blog/view','id'=>$model->id ]) ?>">
                <?=  \yii\helpers\Html::img($model->getImageUrl(), ['class' => 'img-responsive w-100', 'alt' => $model->title] ) ?>
            </a>
<!--            <a href="blog-single-left-sidebar.html"><img src="assets/images/blog-image/1.webp" class="img-responsive w-100" alt=""></a>-->
        </div>
        <div class="blog-text">
            <div class="blog-athor-date line-height-1">
                <span class="blog-date">
                    <i class="fa fa-calendar" aria-hidden="true"></i>
                    <?= Yii::$app->formatter->asDate($model->created_at, 'php:d,M Y') ?>
                </span>
                <span>
                    <a class="blog-author" href="<?= Url::to(['blog/index', 'author' => $model->user->username]) ?>">
                        <i class="fa fa-user" aria-hidden="true"></i>
                        <?= Html::encode($model->user->username) ?>
                    </a>
                </span>
            </div>
            <h5 class="blog-heading">
                <a class="blog-heading-link" href="<?= Url::to(['blog/view', 'id' => $model->id]) ?>">
                    <?= Html::encode($model->title) ?>
                </a>
            </h5>
            <p><?= Html::encode($model->getShortDescription()) ?></p>
            <a href="<?= Url::to(['blog/view', 'id' => $model->id]) ?>" class="btn btn-primary blog-btn">Read More</a>
        </div>
    </div>
</div>

