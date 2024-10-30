<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\ProductAttributeValue $model */

$this->title = Yii::t('app', 'Create Product Attribute Value');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Product Attribute Values'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-attribute-value-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
