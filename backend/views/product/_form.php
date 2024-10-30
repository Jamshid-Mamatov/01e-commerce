<?php

use common\models\Product;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Product $model */
/** @var yii\widgets\ActiveForm $form */
$categories = \common\models\Category::find()->select(['name', 'id'])->indexBy('id')->column();
//$allProducts=\common\models\Product::find()->all();
//$productList=ArrayHelper::map($allProducts,'id','name');
$productList = Product::find()
    ->select(['name', 'id'])
    ->indexBy('id')
    ->column();
//\common\components\Utils::printAsError($productList);
/* Add inline CSS */
$this->registerCss("
    .checkbox-container {
        display: block;
        max-height: 200px;
        overflow-y: auto;
        border: 1px solid #ccc;
        padding: 10px;
        width: 100%;
    }

    .checkbox-item {
        display: block;
        padding: 5px;
        border-bottom: 1px solid #ddd;
    }

    .custom-checkbox {
        margin-right: 5px;
    }
");
?>

<div class="product-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 50]) ?>

    <?= $form->field($model, 'is_active')->dropDownList(
        [true => 'Active', false => 'Inactive'],   // Options for dropdown
        ['prompt' => 'Select Status']
    ); ?>

    <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_discount')->dropDownList(
        [true => 'Yes', false => 'No']) ?>

    <?= $form->field($model, 'discount_price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'stock')->textInput() ?>
    <?php if ($model->id): ?>
        <div class="images">
            <?php foreach ($model->productImages as $image): ?>
                <div id="<?= 'image' . $image->id ?>">
                    <?= Html::img("/" . $image->image_path, ['width' => 200]) ?>
                    <?= Html::button('Delete', [
                        "hx-get" => \yii\helpers\Url::to(
                            [
                                'img-delete', 'id' => $image->id
                            ]
                        ),
                        "hx-swap" => "outerHTML",
                        'hx-target' => '#image' . $image->id,
                    ]) ?>
                </div>

            <?php endforeach; ?>
        </div>
        <?= $form->field($model, "productImages[]")->fileInput([
            "multiple" => true,
            'accept' => 'image/*',

        ]) ?>
    <?php else:?>
        <?= $form->field($model, "productImages[]")->fileInput([
            "multiple" => true,
            'accept' => 'image/*',
            'required' => true,
        ]) ?>
    <?php endif ?>


    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'category_id')->dropDownList(
        $categories,
        ['prompt' => 'Select Category']
    ) ?>

    <?= $form->field($model, 'similar_product_ids')->checkboxList($productList, [
        'item' => function($index, $label, $name, $checked, $value) {
            return '<div class="checkbox-item">'
                . Html::checkbox($name, $checked, [
                    'value' => $value,
                    'label' => $label,
                    'class' => 'custom-checkbox'
                ]) . '</div>';
        },
        'class' => 'checkbox-container'
    ])->label("Select Similar Products") ?>

    <?= $form->field($model, 'related_product_ids')->checkboxList($productList, [
        'item' => function($index, $label, $name, $checked, $value) {
            return '<div class="checkbox-item">'
                . Html::checkbox($name, $checked, [
                    'value' => $value,
                    'label' => $label,
                    'class' => 'custom-checkbox'
                ]) . '</div>';
        },
        'class' => 'checkbox-container'
    ])->label("Select Related Products") ?>


    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
