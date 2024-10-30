<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Advertisement $model */

$this->title = Yii::t('app', 'Create Advertisement');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Advertisements'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="advertisement-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
