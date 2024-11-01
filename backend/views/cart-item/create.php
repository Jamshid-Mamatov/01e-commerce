<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\CartItem $model */

$this->title = Yii::t('app', 'Create Cart Item');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cart Items'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cart-item-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
