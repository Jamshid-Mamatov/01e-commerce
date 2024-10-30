<?php

use common\models\Category;
use common\models\Product;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var common\models\ProductSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Products');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="product-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Product'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'name',
            [
                'attribute' => 'is_active',
                'value' => function($model) {
                    return $model->is_active ? 'Active' : 'Inactive';
                },
                'filter' => [1 => 'Active', 0 => 'Inactive'],  // Add dropdown filter
            ],
            'price',
            [
                    'attribute' => 'is_discount',
                    'value' => function($model) {
                            return $model->is_discount ? 'Yes' : 'No';
                    },
                    'filter' => [1 => 'Yes', 0 => 'No'],
            ],
            'discount_price',
//            'stock',
//            'description:ntext',

            [
                    'attribute' => 'category_id',
                    'value' => function($model) {
                            return $model->category ? $model->category->name : 'No category';
                    },
                    'filter' => ArrayHelper::merge( ArrayHelper::map(Category::find()->all(), 'id', 'name'),
                                                    ['' => "No category"]),

            ],
            'created_at',
//            'updated_at',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Product $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
