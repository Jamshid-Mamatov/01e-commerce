<?php


?>


<div class="product-area related-product">
    <div class="container">
        <!-- Section Title & Tab Start -->
        <div class="row">
            <div class="col-12">
                <div class="section-title text-center m-0">
                    <h2 class="title"><?= $title ?></h2>
                    <!--                    <p>There are many variations of passages of Lorem Ipsum available</p>-->
                </div>
            </div>
        </div>
        <!-- Section Title & Tab End -->
        <div class="row">
            <div class="col">
                <div class="new-product-slider swiper-container slider-nav-style-1">
                    <div class="swiper-wrapper">
                        <?php use yii\helpers\Html;
                        use yii\helpers\Url;

                        foreach ($model as $product):?>
                            <div class="swiper-slide">
                                <!-- Single Prodect -->
                                <div class="product">
                                        <span class="badges">
                                        <span class="new">New</span>
                                        </span>
                                    <div class="thumb">
                                        <a href="<?= Url::to(['product/view', 'id' => $product->id]) ?>" class="image">
                                            <?= Html::img('http://localhost:8888/' . $product->productImages[0]->image_path, ['alt' => $product->name]) ?>
                                            <?= Html::img('http://localhost:8888/' . $product->productImages[0]->image_path, ['class' => 'hover-image', 'alt' => $product->name]) ?>
                                        </a>
                                    </div>
                                    <div class="content">
                                        <span class="category"><a href="#">Accessories</a></span>
                                        <h5 class="title">
                                            <?= Html::a(Html::encode($product->name), ['product/view', 'id' => $product->id]) ?>
                                        </h5>
                                        <span class="price">
                                                <?php if ($product->is_discount): ?>
                                                    <?= Html::tag('span', '$' . Html::encode($product->discount_price), ['class' => 'new']) ?>
                                                    <?= Html::tag('span', '$' . Html::encode($product->price), ['class' => 'old']) ?>
                                                <?php else: ?>
                                                    <?= Html::tag('span', '$' . Html::encode($product->price), ['class' => 'new']) ?>
                                                <?php endif; ?>
                                            </span>

                                    </div>
                                    <div class="actions">
                                        <!-- Add to Cart Button -->
                                        <?= Html::button('<i class="pe-7s-shopbag"></i>', [
                                            'class' => 'action add-to-cart',
                                            'title' => 'Add To Cart',
                                            'data-id' => $product->id,
                                            'hx-get'=>'/site/add-to-cart?id='.$product->id,
                                            'hx-target'=>'.minicart-product-list#cart-list',
                                            'hx-swap'=>'beforeend'
                                        ]) ?>
                                        <!-- Wishlist Button -->
                                        <?= Html::button('<i class="pe-7s-like"></i>',
                                            ['class' => 'action add-to-wishlist',
                                                'title' => 'Add To Wishlist',
                                                'data-id' => $product->id,
                                                'hx-get'=>'/site/add-to-wishlist?id='.$product->id,
                                                'hx-target'=>'.minicart-product-list#wish-list',
                                                'hx-swap'=>'beforeend'
                                            ]) ?>

                                        <!-- Quick View Button -->
                                        <?= Html::a('<i class="pe-7s-look"></i>', ['product/view', 'id' => $product->id], [
                                            'class' => 'action quickview',
                                            'title' => 'Quick View',
                                            'data-id' => $product->id,

                                        ]) ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach;?>

                    </div>
                    <!-- Add Arrows -->
                    <div class="swiper-buttons">
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
