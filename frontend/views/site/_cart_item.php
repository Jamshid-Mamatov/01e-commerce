<?php
/**
 * @var \common\models\CartItem $cart_item
 */


use yii\helpers\Html;
use yii\helpers\Url;

?>

<li>
    <a href="<?= Url::to(['product/view', 'id' => $cart_item->product->id]) ?>" class="image"><?= Html::img('http://localhost:8888/'  . $cart_item->product->productImages[0]->image_path, ['alt' => $cart_item->product->name]) ?>
    </a>
    <div class="content">
        <a href="single-product.html" class="title"><?= $cart_item->product->name ?></a>
        <span class="quantity-price"><?= $cart_item->quantity?> x <span class="amount"><?= $cart_item->price ?></span></span>
        <a href="#" class="remove">×</a>
    </div>
</li>
