<?php


use yii\helpers\Html;
use yii\helpers\Url;

?>

<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-xs-6 mb-30px">
    <!-- Single Prodect -->
    <div class="product"><span class="badges"><span class="new">New</span></span>
        <div class="thumb">
            <a href="<?= Url::to(['product/view', 'id' => $model->id]) ?>" class="image">
                <?= Html::img('http://localhost:8888/' . $model->productImages[0]->image_path, ['alt' => $model->getTranslatedAttributes()['title'] ]) ?>
                <?= Html::img('http://localhost:8888/' . $model->productImages[0]->image_path, ['class' => 'hover-image', 'alt' => $model->getTranslatedAttributes()['title'] ]) ?>
            </a>
        </div>
        <div class="content">

            <h5 class="title">
                <?= Html::a($model->getTranslatedAttributes()['title'] , ['product/view', 'id' => $model->id]) ?>
            </h5>
            <span class="price">
                <?php if ($model->is_discount): ?>
                    <?= Html::tag('span', '$' . Html::encode($model->discount_price), ['class' => 'new']) ?>
                    <?= Html::tag('span', '$' . Html::encode($model->price), ['class' => 'old']) ?>
                <?php else: ?>
                    <?= Html::tag('span', '$' . Html::encode($model->price), ['class' => 'new']) ?>
                <?php endif; ?>

            </span>
            <p><?= Html::encode($model->getTranslatedAttributes()['description']) ?></p>
        </div>
        <div class="actions">
            <!-- Add to Cart Button -->
            <?= Html::button('<i class="pe-7s-shopbag"></i>', [
                'class' => 'action add-to-cart',
                'title' => 'Add To Cart',
                'data-id' => $model->id,
                'hx-get' => '/site/add-to-cart?id=' . $model->id,
                'hx-target' => '.minicart-product-list#cart-list',
                'hx-swap' => 'beforeend'
            ]) ?>
            <!-- Wishlist Button -->
            <?= Html::button('<i class="pe-7s-like"></i>',
                ['class' => 'action add-to-wishlist',
                    'title' => 'Add To Wishlist',
                    'data-id' => $model->id,
                    'hx-get' => '/site/add-to-wishlist?id=' . $model->id,
                    'hx-target' => '.minicart-product-list#wish-list',
                    'hx-swap' => 'beforeend'
                ]) ?>

            <!-- Quick View Button -->
            <?= Html::a('<i class="pe-7s-look"></i>', ['product/view', 'id' => $model->id], [
                'class' => 'action quickview',
                'title' => 'Quick View',
                'data-id' => $model->id,

            ]) ?>
        </div>
    </div>
</div>

