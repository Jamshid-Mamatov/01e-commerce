<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Review $model */

$this->title = Yii::t('app', 'Create Review');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Reviews'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="review-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
