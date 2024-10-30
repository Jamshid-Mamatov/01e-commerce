<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Blog $model */
/** @var yii\widgets\ActiveForm $form */

$users=\common\models\User::find()->select(['username','id'])->indexBy('id')->column();
?>

<div class="blog-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'user_id')->dropDownList($users,['prompt'=>"Author"]) ?>

    <?php if ($model->id): ?>
        <div id="<?= 'image' . $model->id ?>">
            <?= Html::img($model->getImageUrl(), ['width' => 200]) ?>
            <?= Html::button('Delete', [
                "hx-get" => \yii\helpers\Url::to(
                    [
                        'img-delete', 'id' => $model->id
                    ]
                ),
                "hx-swap" => "outerHTML",
                'hx-target' => '#image' . $model->id,
            ]) ?>
        </div>
        <?= $form->field($model, 'image')->fileInput(['accept' => 'image/*'])?>
        <?= Html::activeHiddenInput($model, 'image')?>
    <?php else: ?>
        <?= $form->field($model, 'image')->fileInput(['accept' => 'image/*','required' => true])?>
    <?php endif ?>
    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'body')->textarea(['rows' => 6]) ?>



    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
