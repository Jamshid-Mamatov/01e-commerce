<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;

$form = ActiveForm::begin([
    'action' => ['site/form-account'],
    'id' => 'account-details-form',
    'options' => ['data-pjax' => true]
]); ?>




<?= $form->field($user_info, 'username')->textInput() ?>

<?= $form->field($user_info, 'email')->input('email') ?>

<?= $form->field($user_info, 'birthdate')->widget(DatePicker::class,[
    'dateFormat' => 'yyyy-MM-dd',
]) ?>

<?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>

<?php ActiveForm::end(); ?>
