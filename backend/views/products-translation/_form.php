<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\ProductTranslation $model */
/** @var yii\widgets\ActiveForm $form */
?>


<div class="product-translation-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'product_id')->dropDownList($products,['prompt' => 'Select Product']) ?>

    <?= $form->field($model, 'language_code')->dropDownList(['uz-UZ'=>"uz",'ru-RU'=>'ru','en-US'=>'en'],['prompt'=>'Language']) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
