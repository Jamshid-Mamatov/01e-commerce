<?php

use common\models\Product;
use yii\helpers\Html;

$this->title = $category->name;
$this->params['breadcrumbs'][] = $this->title;
$products= $category->products;

?>

<div class="container">
    <h1 class="text-center my-4"><?= Html::encode($category->name) ?></h1>

    <?php if (!empty($products)): ?>
        <div class="row">
            <?php foreach ($products as $product): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title"><?= Html::encode($product->name) ?></h5>
                            <p class="card-text"><?= Html::encode($product->description) ?></p>
                            <p class="card-text"><strong>Price: </strong> $<?= Html::encode($product->price) ?></p>
                            <?= Html::a('View Details', ['product/view', 'id' => $product->id], ['class' => 'btn btn-primary']) ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p class="text-center">No products available for this category.</p>
    <?php endif; ?>
</div>
