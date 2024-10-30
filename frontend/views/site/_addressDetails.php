<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
$form = ActiveForm::begin([
        'action' => ['site/form-address'],
    'id' => 'address-details-form',
    'options' => ['data-pjax' => true]
]);
?>

<h3>Adresses</h3>



<?= $form->field($user_info, 'city')->textInput() ?>
<?= $form->field($user_info, 'state')->textInput() ?>
<?= $form->field($user_info, 'zip')->textInput() ?>
<?= $form->field($user_info, 'country')->textInput() ?>

<?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>

<?php ActiveForm::end(); ?>
