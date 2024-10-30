<?php

use common\models\Advertisement;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\AdvertisementSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Advertisements');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="advertisement-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Advertisement'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,

        'columns' => [

            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'type',
            'start_date',
            'end_date',
            [
                'class' => ActionColumn::className(),
                'template' => '{view} {update} {delete} {assign}',
                'buttons' =>[
                        'assign' => function ($url, $model) {
                            return Html::a("assign", $url, [
                                    'title' => Yii::t('yii', 'assign'),
                                    'class' => 'btn btn-primary',
                            ]);
                        }
                ],
                'urlCreator' => function ($action, Advertisement $model, $key, $index, $column) {

                    return Url::toRoute([$action, 'id' => $model->id]);
                 },


            ],
        ],
    ]); ?>


</div>
