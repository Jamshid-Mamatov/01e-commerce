<?php

/** @var yii\web\View $this
 * @var common\models\Product $products
 *
 * */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'My Yii Application';

$ads=\common\models\Advertisement::find()->all();
//\common\components\Utils::printAsError($ads);
?>


<div class="section ">
    <div class="hero-slider swiper-container slider-nav-style-1 slider-dot-style-1">
        <!-- Hero slider Active -->
        <div class="swiper-wrapper">
            <!-- Single slider item -->

            <?php foreach ($ads as $ad):?>
                <div class="hero-slide-item slider-height swiper-slide bg-color1" data-bg-image="/images/hero/bg/hero-bg-1.webp">
                    <div class="container h-100">
                        <div class="row h-100">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 align-self-center sm-center-view">
                                <div class="hero-slide-content slider-animated-1">
                                    <span class="category">Welcome To TestE-commerce</span>
                                    <h2 class="title-1"><?= Html::encode($ad->name) ?></h2>
                                    <?= Html::a("Go shopping",['/advertisement/index','id'=>$ad->id],['class' => 'btn btn-primary text-capitalize']) ?>
<!--                                    <a href="/advertisement/index?id=5" class="btn btn-primary text-capitalize">Shop All Devices</a>-->
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 d-flex justify-content-center position-relative align-items-end">
                                <div class="show-case">
                                    <div class="hero-slide-image">
                                        <img src="/images/hero/inner-img/blue.png" alt="" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            <!-- Single slider item -->

        </div>
        <!-- Add Pagination -->
        <div class="swiper-pagination swiper-pagination-white"></div>
        <!-- Add Arrows -->
        <div class="swiper-buttons">
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </div>
</div>
<!-- Hero/Intro Slider End -->

<!-- Product Area Start -->
<div class="product-area pb-100px">
    <div class="container">
        <!-- Section Title & Tab Start -->
        <div class="row">
            <div class="col-12">
                <!-- Tab Start -->
                <div class="tab-slider d-md-flex justify-content-md-between align-items-md-center">
                    <ul class="product-tab-nav nav justify-content-start align-items-center">

                        <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#products">Products</button>
                        </li>
                        <li class="nav-item"><button class="nav-link " data-bs-toggle="tab" data-bs-target="#newarrivals">New Arrivals</button>
                        </li>

                        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#discount">Discounted Products</button>
                        </li>
                    </ul>
                </div>
                <!-- Tab End -->
            </div>
        </div>
        <!-- Section Title & Tab End -->
        <div class="row">
            <div class="col">
                <div class="tab-content mt-60px">


<!--                    product tab start-->

                        <div class="tab-pane fade show active" id="products">
                            <div class="row mb-n-30px">



                                <?php foreach ($products as $product): ?>
                                <div class="col-lg-4 col-xl-3 col-md-6 col-sm-6 col-xs-6 mb-30px" >
                                    <div class="product">
                                        <span class="badges">
                                            <?= $product->is_discount ? Html::tag('span',"Discounted",['class'=>'new']) : Html::tag('span', 'New', ['class' => 'new']) ?>
                                        </span>

                                        <div class="thumb">
                                            <a href="<?= Url::to(['product/view', 'id' => $product->id]) ?>" class="image">
<!--                                                --><?php //= \common\components\Utils::printAsError($product->productImages)?>
                                                <?php if (!empty($product->productImages)): ?>
                                                <?= Html::img('http://localhost:8888/'  . $product->productImages[0]->image_path, ['alt' => $product->getTranslatedAttributes()['title'] ]) ?>
                                                <?= Html::img('http://localhost:8888/'  . $product->productImages[0]->image_path, ['class' => 'hover-image', 'alt' => $product->getTranslatedAttributes()['title'] ]) ?>
                                                <?php endif;?>
                                            </a>
                                        </div>
                                        <div class ="content" >
                                            <?php if ($product->category):?>
                                            <span class="category">
                                                <?= Html::a($product->category->name, ['category/view', 'id' => $product->category_id]) ?>
                                            </span>
                                            <?php endif;?>
                                            <h5 class="title">
                                                <?= Html::a(Html::encode($product->getTranslatedAttributes()['title'] ), ['product/view', 'id' => $product->id]) ?>
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
                        </div>
    <!--                    product tab end-->
                        <!-- 1st tab start -->

                        <div class="tab-pane fade" id="newarrivals">
                            <div class="row mb-n-30px">



                                <?php foreach ($newarrivals as $product): ?>
                                    <div class="col-lg-4 col-xl-3 col-md-6 col-sm-6 col-xs-6 mb-30px" >
                                        <div class="product">
                                        <span class="badges">
                                            <?= $product->is_discount ? Html::tag('span',"Discounted",['class'=>'new']) : Html::tag('span', 'New', ['class' => 'new']) ?>
                                        </span>

                                            <div class="thumb">
                                                <a href="<?= Url::to(['product/view', 'id' => $product->id]) ?>" class="image">
<!--                                                    --><?php //= Html::img('http://localhost:8888/'  . $product->productImages[0]->image_path, ['alt' => $product->getTranslatedAttributes()['title'] ]) ?>
<!--                                                    --><?php //= Html::img('http://localhost:8888/'  . $product->productImages[0]->image_path, ['class' => 'hover-image', 'alt' => $product->getTranslatedAttributes()['title'] ]) ?>
                                                    <?php if (!empty($product->productImages)): ?>
                                                        <?= Html::img('http://localhost:8888/'  . $product->productImages[0]->image_path, ['alt' => $product->getTranslatedAttributes()['title'] ]) ?>
                                                        <?= Html::img('http://localhost:8888/'  . $product->productImages[0]->image_path, ['class' => 'hover-image', 'alt' => $product->getTranslatedAttributes()['title'] ]) ?>
                                                    <?php endif;?>
                                                </a>
                                            </div>
                                            <div class ="content" >
                                                <?php if ($product->category):?>
                                                    <span class="category">
                                                        <?= Html::a($product->category->name, ['category/view', 'id' => $product->category_id]) ?>
                                                    </span>
                                                <?php endif;?>
                                                <h5 class="title">
                                                    <?= Html::a(Html::encode($product->getTranslatedAttributes()['title'] ), ['product/view', 'id' => $product->id]) ?>
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
                        </div>

                        <div class="tab-pane fade" id="discount">
                            <div class="row mb-n-30px">



                                <?php foreach ($products as $product): ?>
                                <?php if ($product->is_discount): ?>
                                    <div class="col-lg-4 col-xl-3 col-md-6 col-sm-6 col-xs-6 mb-30px" >
                                        <div class="product">
                                        <span class="badges">
                                            <?= $product->is_discount ? Html::tag('span',"Discounted",['class'=>'new']) : Html::tag('span', 'New', ['class' => 'new']) ?>
                                        </span>

                                            <div class="thumb">
                                                <a href="<?= Url::to(['product/view', 'id' => $product->id]) ?>" class="image">
<!--                                                    --><?php //= Html::img('http://localhost:8888/'  . $product->productImages[0]->image_path, ['alt' => $product->getTranslatedAttributes()['title'] ]) ?>
<!--                                                    --><?php //= Html::img('http://localhost:8888/'  . $product->productImages[0]->image_path, ['class' => 'hover-image', 'alt' => $product->getTranslatedAttributes()['title'] ]) ?>
                                                    <?php if (!empty($product->productImages)): ?>
                                                        <?= Html::img('http://localhost:8888/'  . $product->productImages[0]->image_path, ['alt' => $product->getTranslatedAttributes()['title'] ]) ?>
                                                        <?= Html::img('http://localhost:8888/'  . $product->productImages[0]->image_path, ['class' => 'hover-image', 'alt' => $product->getTranslatedAttributes()['title'] ]) ?>
                                                    <?php endif;?>
                                                </a>
                                            </div>
                                            <div class ="content" >
                                                <?php if ($product->category):?>
                                                    <span class="category">
                                                         <?= Html::a($product->category->name, ['category/view', 'id' => $product->category_id]) ?>
                                                    </span>
                                                <?php endif;?>
                                                <h5 class="title">
                                                    <?= Html::a(Html::encode($product->getTranslatedAttributes()['title'] ), ['product/view', 'id' => $product->id]) ?>
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
                                                <?= Html::a('<i class="pe-7s-shopbag"></i>', Url::to(['cart/', 'id' => $product->id]), [
                                                    'class' => 'action add-to-cart',
                                                    'title' => 'Add To Cart',
                                                    'data-id' => $product->id,

                                                ]) ?>
                                                <!-- Wishlist Button -->
                                                <?= Html::a('<i class="pe-7s-like"></i>', ['wishlist/add', 'id' => $product->id], [
                                                    'class' => 'action wishlist',
                                                    'title' => 'Wishlist',
                                                    'data-id' => $product->id,

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
                                <?php endif;?>
                                <?php endforeach;?>

                            </div>
                        </div>
                    <!-- 3rd tab end -->

                </div>
            </div>
        </div>
    </div>
</div>
<!-- Product Area End -->