<?php

use common\models\Cart;
use yii\helpers\Html;
use yii\helpers\Url;


/** @var  $cart */

$cartItems = $cart->cartItems;

?>

<?php if (!Yii::$app->user->isGuest && !empty($cartItems)): ?>


    <div class="cart-main-area pt-100px pb-100px">
        <div class="container">
            <h3 class="cart-page-title">Your cart items</h3>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                    <?= Html::beginForm(['cart/custom-act'], 'post') ?>
                    <div class="table-content table-responsive cart-table-content">
                        <table>
                            <thead>
                            <tr>
                                <th>Image</th>
                                <th>Product Name</th>
                                <th>Until Price</th>
                                <th>Qty</th>
                                <th>Subtotal</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($cartItems as $item): ?>
                                <tr class="cart-item-<?= $item->id ?>">
                                    <td class="product-thumbnail">
                                        <?= Html::a(
                                            Html::img("http://localhost:8888/" . $item->product->productImages[0]->image_path, ['class' => 'img-responsive ml-15px', 'alt' => '']),
                                            Url::to(['product/view', 'id' => $item->product->id])
                                        ) ?>
                                    </td>
                                    <td class="product-name"><?= Html::label('' . $item->product->name) ?></td>
                                    <td class="product-price-cart"> <?= Html::tag('span', $item->price, ['class' => 'amount']) ?> </td>
                                    <td class="product-quantity">

                                        <div class="cart-plus-minus">
                                            <input class="cart-plus-minus-box" type="text" name="<?= $item->id ?>"
                                                   value="<?= $item->quantity?>"/>
                                        </div>
                                    </td>
                                    <td class="product-subtotal">$<?= $item->price * $item->quantity ?></td>
                                    <td class="product-remove">

                                        <?= Html::button('×', [

                                            'hx-get' => Url::to(['del-cart-item', 'id' => $item->id]),
                                            'hx-target' => '.cart-item-' . $item->id,
                                            'hx-swap' => 'outerHTML',
                                            'hx-confirm' => 'Are you sure you want to delete this item?',
                                        ]) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <script>
                                document.addEventListener('htmx:afterOnLoad', afterLoad);

                                function afterLoad(event) {
                                    var className = '.' + event.detail.target.className;
                                    console.log(className);

                                    document.querySelectorAll(className).forEach((el) => {
                                        console.log(el)
                                        el.remove();
                                    });
                                }
                            </script>
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="cart-shiping-update-wrapper">
                                <div class="cart-shiping-update">
                                    <a href="/">Continue Shopping</a>
                                </div>
                                <div class="cart-clear">
                                    <button>Update Shopping Cart</button>

                                </div>
                            </div>
                        </div>
                    </div>
                    <?= Html::endForm() ?>
                    <div class="row">

                        <div class="col-lg-4 col-md-12 mt-md-30px">
                            <div class="grand-totall">
                                <div class="title-wrap">
                                    <h4 class="cart-bottom-title section-bg-gary-cart">Cart Total</h4>
                                </div>


                                <h4 class="grand-totall-title">Grand Total <?= Html::tag('span',Cart::totalAmount())?> </h4>
                                <a href="cart/checkout">Proceed to Checkout</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

