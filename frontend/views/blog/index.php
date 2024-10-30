<?php

use common\models\Blog;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\widgets\ListView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Blogs');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="blog-list pb-100px pt-100px main-blog-page single-blog-page">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 ms-auto me-auto">

                    <h1><?= Html::encode($this->title) ?></h1>

                    <p>
                        <?= Html::a(Yii::t('app', 'Create Blog'), ['create'], ['class' => 'btn btn-success']) ?>
                    </p>


                    <?= ListView::widget([
                        'dataProvider' => $dataProvider,
                        'itemView' => '_blog_item',
                        'layout' => "{items}\n<div class='pro-pagination-style text-center mt-0 mb-0' data-aos='fade-up' data-aos-delay='200' ><div class='pages'> {pager}</div></div>",
                        'itemOptions' => ['class' => 'row'],
                        'pager' => [
                            'class' => \yii\widgets\LinkPager::class,
                            'options' => ['class' => 'pagination'],
                        ],

                    ]) ?>


            </div>
        </div>
    </div>
</div>
