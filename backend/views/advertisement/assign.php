<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
// Set the title for the view

$this->title = 'Assign Advertisement: ' . $advertisement->name;

// Set up breadcrumbs
$this->params['breadcrumbs'][] = ['label' => 'Advertisements', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title; // You can use $this->title here
?>


<?= Html::beginForm() ?>

<select multiple name="selectedIds[]">
    <?php if ($data): ?>
        <?php
        foreach ($data as $item):?>
            <option value="<?= $item->id?>"><?= $item->name ?></option>
        <?php endforeach; ?>
    <?php endif ?>
</select>
<?= Html::submitButton()?>

<?= Html::endForm() ?>


<?= Html::beginForm() ?>
    <select multiple name="unselectedIds[]">
        <?php foreach ($assigned->select(['id','name'])->all() as $product): ?>
            <option value="<?= $product->id ?>"><?= Html::encode($product->name) ?></option>
        <?php endforeach; ?>
    </select>
<?= Html::submitButton()?>
<?= Html::endForm() ?>

