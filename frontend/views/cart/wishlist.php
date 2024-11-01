<?php

use common\models\Wishlist;

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$wishlist_items = Wishlist::findAll(['user_id' => Yii::$app->user->id]);

?>

<div class="cart-main-area pt-100px pb-100px">
    <div class="container">
        <h3 class="cart-page-title">Your cart items</h3>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                <form action="#">
                    <div class="table-content table-responsive cart-table-content">
                        <table>
                            <thead>
                            <tr>
                                <th>Image</th>
                                <th>Product Name</th>
                                <th>Price</th>
                                <th>Add To Cart</th>
                                <th>Remove</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?php
                            foreach ($wishlist_items as $item):
                            ?>
                                <tr class="wishlist-item-<?= $item->id ?>">
                                    <td class="product-thumbnail">
                                        <?= Html::a(
                                            Html::img("http://localhost:8888/" . $item->product->productImages[0]->image_path, ['class' => 'img-responsive ml-15px', 'alt' => '']),
                                            Url::to(['product/view', 'id' => $item->product->id])
                                        ) ?>
                                    </td>
                                    <td class="product-name"><?= Html::label('' . $item->product->getTranslatedAttributes()['title']) ?></td>
                                    <td class="product-price-cart"> <?= Html::tag('span', $item->product->price , ['class' => 'amount']) ?> </td>

                                    <td>
                                        <?= Html::button('Add to Cart', [

                                           ' hx-get'=>"/site/add-to-cart?id=".$item->product_id,
                                            'hx-target'=>".minicart-product-list#cart-list",
                                            'hx-swap'=>"beforeend"
//
                                        ]) ?>
                                    </td>



                                    <td class="product-remove">

                                        <?= Html::button('×', [

                                            'hx-get' => Url::to(['del-wishlist-item', 'id' => $item->id]),
                                            'hx-target' => '.wishlist-item-' . $item->id,
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
                </form>
            </div>
        </div>
    </div>
</div>
