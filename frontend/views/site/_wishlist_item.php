<?php
/**
 * @var \common\models\Wishlist $wishlist
 */


use yii\helpers\Html;
use yii\helpers\Url;

?>

<li>
    <a href="<?= Url::to(['product/view', 'id' => $wishlist->product_id]) ?>" class="image"><?= Html::img('http://localhost:8888/'  . $wishlist->product->productImages[0]->image_path, ['alt' => $wishlist->product->name]) ?>
    </a>
    <div class="content">
        <a href="single-product.html" class="title"><?= $wishlist->product->name ?></a>
        <span class="quantity-price">1 x <span class="amount"><?= '100' ?></span></span>
        <a href="#" class="remove">×</a>
    </div>
</li>
