<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Attribute $model */

$this->title = Yii::t('app', 'Create Attribute');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Attributes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="attribute-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
