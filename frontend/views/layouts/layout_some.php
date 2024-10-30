<?php

use common\models\Cart;
use common\models\CartItem;
use common\models\Wishlist;
use frontend\assets\AppAsset;

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Menu;

/**
 ** @var \yii\web\View $this
 */

AppAsset::register($this);

$cart_items = Cart::getUserCart()->cartItems;
$wishlist = Wishlist::findALl(['user_id' => Yii::$app->user->id]);
$this->beginPage();

//Yii::$app->language = 'en';
//$languageItem = new cetver\LanguageSelector\items\DropDownLanguageItem([
//    'languages' => [
//        'en' => '<span class="flag-icon flag-icon-us"></span> English',
//        'ru' => '<span class="flag-icon flag-icon-ru"></span> Russian',
//        'de' => '<span class="flag-icon flag-icon-de"></span> Deutsch',
//    ],
//    'options' => ['encode' => false],
//]);

//\common\components\Utils::printAsError($languageItem);
?>

<!DOCTYPE html>
<html lang="zxx" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hmart - About Us</title>
    <meta name="robots" content="index, follow"/>
    <meta name="description" content="Hmart-Smart Product eCommerce html Template">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="/images/favicon.ico"/>
    <script src="https://unpkg.com/htmx.org@2.0.3" integrity="sha384-0895/pl2MU10Hqc6jd4RvrthNlDiE9U1tWmX7WRESftEDRosgxNsQG/Ze9YMRzHq" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <?php $this->head() ?>
</head>
<?php $this->beginBody() ?>
<body>
<div class="main-wrapper">
    <header>
        <!-- Flag Icon CSS (optional, for flag icons) -->
<!--        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/css/flag-icon.min.css">-->

        <!-- Bootstrap Select CSS -->
<!--        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.min.css">-->
        <!-- Header top area start -->
        <div class="header-top">
            <div class="container">
                <div class="row justify-content-between align-items-center">
                    <div class="col">
                        <div class="welcome-text">
                            <p>World Wide Completely Free Returns and Shipping</p>
                        </div>
                    </div>
                    <div class="col d-none d-lg-block">
                        <div class="top-nav">
                            <ul>
                                <li><a href="tel:0123456789"><i class="fa fa-phone"></i> +012 3456 789</a></li>
                                <li><a href="mailto:demo@example.com"><i class="fa fa-envelope-o"></i> demo@example.com</a>
                                </li>
                                <?php if(yii::$app->user->isGuest):?>
                                    <li><?= \yii\helpers\Html::a("Login",['site/login']) ?></li>
                                    <li><?= \yii\helpers\Html::a("Signup",['site/signup']) ?></li>
                                <?php else: ?>
                                    <li><?= \yii\helpers\Html::a("Account",['site/account']) ?></li>
                                <?php endif;?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Header top area end -->
        <!-- Header action area start -->
        <div class="header-bottom  d-none d-lg-block">
            <div class="container">
                <div class="row justify-content-between align-items-center">
                    <div class="col-lg-3 col">
                        <div class="header-logo">
                            <a href="/"><img src="/images/logo/footer-logo.png" alt="Site Logo"/></a>
                        </div>

                    </div>
                    <div class="col-lg-3 col">
                        <div class="header-actions">
                            <!-- Single Wedge Start -->
                            <a href="#offcanvas-wishlist" class="header-action-btn offcanvas-toggle">
                                <i class="pe-7s-like"></i>
                            </a>
                            <!-- Single Wedge End -->
                            <a href="#offcanvas-cart" class="header-action-btn header-action-btn-cart offcanvas-toggle pr-0">
                                <i class="pe-7s-shopbag"></i>
                                <span class="header-action-num">01</span>
                                <!-- <span class="cart-amount">€30.00</span> -->
                            </a>
                            <a href="#offcanvas-mobile-menu" class="header-action-btn header-action-btn-menu offcanvas-toggle d-lg-none">
                                <i class="pe-7s-menu"></i>
                            </a>
                        </div>



                    </div>
                    <div class="col-lg-3 col">
                        <div class="dropdown">
                            <?= Yii::$app->language ?>
                            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
<!--                                --><?php //= \common\components\Utils::printAsError(Yii::$app->language) ?>
                                <?= Yii::$app->language === 'uz-UZ' ? '<span class="flag-icon flag-icon-uz"></span> Uzbek' : (Yii::$app->language === 'ru-RU' ? '<span class="flag-icon flag-icon-ru"></span> Russian' : '<span class="flag-icon flag-icon-us"></span> English') ?>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="languageDropdown">
                                <li>
                                    <a class="dropdown-item" href="<?= \yii\helpers\Url::to(['site/language', 'lang' => 'en-US']) ?>">
                                        <span class="flag-icon flag-icon-us"></span> English
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="<?= \yii\helpers\Url::to(['site/language', 'lang' => 'ru-RU']) ?>">
                                        <span class="flag-icon flag-icon-ru"></span> Russian
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="<?= \yii\helpers\Url::to(['site/language', 'lang' => 'uz-UZ']) ?>">
                                        <span class="flag-icon flag-icon-uz"></span> Uzbek
                                    </a>
                                </li>
                            </ul>
                        </div>

                    </div>

                </div>
            </div>
        </div>
        <!-- Header action area end -->
        <!-- Header action area start -->
        <div class="header-bottom d-lg-none sticky-nav style-1">
            <div class="container">
                <div class="row justify-content-between align-items-center">
                    <div class="col-lg-3 col">
                        <div class="header-logo">
                            <a href="index.html"><img src="/images/logo/footer-logo.png" alt="Site Logo"/></a>
                        </div>
                    </div>
                    <div class="col-lg-6 d-none d-lg-block">
                        <div class="search-element">
                            <form action="#">
                                <input type="text" placeholder="Search"/>
                                <button><i class="pe-7s-search"></i></button>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-3 col">
                        <div class="header-actions">
                            <!-- Single Wedge Start -->
                            <a href="#offcanvas-wishlist" class="header-action-btn offcanvas-toggle">
                                <i class="pe-7s-like"></i>
                            </a>
                            <!-- Single Wedge End -->
                            <a href="#offcanvas-cart"
                               class="header-action-btn header-action-btn-cart offcanvas-toggle pr-0">
                                <i class="pe-7s-shopbag"></i>
                                <span class="header-action-num">01</span>
                                <!-- <span class="cart-amount">€30.00</span> -->
                            </a>
                            <a href="#offcanvas-mobile-menu"
                               class="header-action-btn header-action-btn-menu offcanvas-toggle d-lg-none">
                                <i class="pe-7s-menu"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Header action area end -->
        <!-- header navigation area start -->
        <div class="header-nav-area d-none d-lg-block sticky-nav">
            <div class="container">
                <div class="header-nav">


                    <div class="main-menu position-relative">
                        <ul>
                            <!-- Home menu item with dropdown -->
                            <li class="dropdown">
                                <?= Html::a('Home <i class="fa fa-angle-down"></i>', '/site', ['class' => 'dropdown-toggle', 'data-toggle' => 'dropdown']) ?>
                            </li>

                            <!-- About page -->
                            <li>
                                <?= Html::a('About', Url::to(['/site/about'])) ?>
                            </li>

                            <!-- Pages menu with dropdown -->
                            <li class="dropdown position-static">
                                <?= Html::a('Pages <i class="fa fa-angle-down"></i>', '#', ['class' => 'dropdown-toggle', 'data-toggle' => 'dropdown']) ?>
                                <ul class="mega-menu d-block">
                                    <li class="d-flex">
                                        <ul class="d-block">
                                            <li class="title"><?= Html::a('Inner Pages', '#') ?></li>
                                            <li><?= Html::a('404 Page', Url::to(['/site/error', 'code' => 404])) ?></li>
                                            <li><?= Html::a('Order Tracking', Url::to(['/order/tracking'])) ?></li>
                                            <li><?= Html::a('Faq Page', Url::to(['/site/faq'])) ?></li>
                                            <li><?= Html::a('Coming Soon Page', Url::to(['/site/coming-soon'])) ?></li>
                                        </ul>
                                        <ul class="d-block">
                                            <li class="title"><?= Html::a('Other Shop Pages', '#') ?></li>
                                            <li><?= Html::a('Cart Page', Url::to(['/cart/index'])) ?></li>
                                            <li><?= Html::a('Checkout Page', Url::to(['/checkout/index'])) ?></li>
                                            <li><?= Html::a('Compare Page', Url::to(['/compare/index'])) ?></li>
                                            <li><?= Html::a('Wishlist Page', Url::to(['/wishlist/index'])) ?></li>
                                        </ul>
                                        <ul class="d-block">
                                            <li class="title"><?= Html::a('Related Shop Pages', '#') ?></li>
                                            <li><?= Html::a('Account Page', Url::to(['/user/account'])) ?></li>
                                            <li><?= Html::a('Login & Register Page', Url::to(['/user/login'])) ?></li>
                                            <li><?= Html::a('Empty Cart Page', Url::to(['/cart/empty'])) ?></li>
                                            <li><?= Html::a('Thank You Page', Url::to(['/site/thank-you'])) ?></li>
                                        </ul>
                                        <ul class="d-flex align-items-center p-0 border-0 flex-column justify-content-center">
                                            <li>
                                                <a class="p-0" href="<?= Url::to(['/shop/left-sidebar']) ?>">
                                                    <img class="img-responsive w-100" src="<?= Url::to('@web/assets/images/banner/menu-banner.png') ?>" alt="">
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>

                            <!-- Shop menu with dropdown -->
                            <li class="dropdown position-static">
                                <?= Html::a('Shop <i class="fa fa-angle-down"></i>', '#', ['class' => 'dropdown-toggle', 'data-toggle' => 'dropdown']) ?>
                                <ul class="mega-menu d-block">
                                    <li class="d-flex">
                                        <ul class="d-block">
                                            <li class="title"><?= Html::a('Shop Page', '#') ?></li>
                                            <li><?= Html::a('Shop 3 Column', Url::to(['/shop/3-column'])) ?></li>
                                            <li><?= Html::a('Shop 4 Column', Url::to(['/shop/4-column'])) ?></li>
                                            <li><?= Html::a('Shop Left Sidebar', Url::to(['/shop/left-sidebar'])) ?></li>
                                            <li><?= Html::a('Shop Right Sidebar', Url::to(['/shop/right-sidebar'])) ?></li>
                                            <li><?= Html::a('Shop List Left Sidebar', Url::to(['/shop/list-left-sidebar'])) ?></li>
                                            <li><?= Html::a('Shop List Right Sidebar', Url::to(['/shop/list-right-sidebar'])) ?></li>
                                        </ul>
                                        <ul class="d-block">
                                            <li class="title"><?= Html::a('Product Details Page', '#') ?></li>
                                            <li><?= Html::a('Product Single', Url::to(['/product/single'])) ?></li>
                                            <li><?= Html::a('Product Variable', Url::to(['/product/variable'])) ?></li>
                                            <li><?= Html::a('Product Affiliate', Url::to(['/product/affiliate'])) ?></li>
                                            <li><?= Html::a('Product Group', Url::to(['/product/group'])) ?></li>
                                            <li><?= Html::a('Product Tab 2', Url::to(['/product/tabstyle-2'])) ?></li>
                                            <li><?= Html::a('Product Tab 3', Url::to(['/product/tabstyle-3'])) ?></li>
                                        </ul>
                                        <ul class="d-block">
                                            <li class="title"><?= Html::a('Single Product Page', '#') ?></li>
                                            <li><?= Html::a('Product Slider', Url::to(['/product/slider'])) ?></li>
                                            <li><?= Html::a('Product Gallery Left', Url::to(['/product/gallery-left'])) ?></li>
                                            <li><?= Html::a('Product Gallery Right', Url::to(['/product/gallery-right'])) ?></li>
                                            <li><?= Html::a('Product Sticky Left', Url::to(['/product/sticky-left'])) ?></li>
                                            <li><?= Html::a('Product Sticky Right', Url::to(['/product/sticky-right'])) ?></li>
                                            <li><?= Html::a('Cart Page', Url::to(['/cart/index'])) ?></li>
                                        </ul>
                                        <ul class="d-block p-0 border-0">
                                            <li class="title"><?= Html::a('Single Product Page', '#') ?></li>
                                            <li><?= Html::a('Checkout Page', Url::to(['/checkout/index'])) ?></li>
                                            <li><?= Html::a('Compare Page', Url::to(['/compare/index'])) ?></li>
                                            <li><?= Html::a('Wishlist Page', Url::to(['/wishlist/index'])) ?></li>
                                            <li><?= Html::a('Account Page', Url::to(['/user/account'])) ?></li>
                                            <li><?= Html::a('Login & Register Page', Url::to(['/user/login'])) ?></li>
                                            <li><?= Html::a('Empty Cart Page', Url::to(['/cart/empty'])) ?></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>

                            <!-- Blog menu with dropdown -->
                            <li class="dropdown">
                                <?= Html::a('Blog <i class="fa fa-angle-down"></i>', '#', ['class' => 'dropdown-toggle', 'data-toggle' => 'dropdown']) ?>
                                <ul class="sub-menu">
                                    <li class="dropdown position-static">
                                        <?= Html::a('Blog Grid <i class="fa fa-angle-right"></i>', Url::to(['/blog/grid-left-sidebar'])) ?>
                                        <ul class="sub-menu sub-menu-2">
                                            <li><?= Html::a('Blog Grid', Url::to(['/blog/grid'])) ?></li>
                                            <li><?= Html::a('Blog Grid Left Sidebar', Url::to(['/blog/grid-left-sidebar'])) ?></li>
                                            <li><?= Html::a('Blog Grid Right Sidebar', Url::to(['/blog/grid-right-sidebar'])) ?></li>
                                        </ul>
                                    </li>
                                    <li class="dropdown position-static">
                                        <?= Html::a('Blog List <i class="fa fa-angle-right"></i>', Url::to(['/blog/list-left-sidebar'])) ?>
                                        <ul class="sub-menu sub-menu-2">
                                            <li><?= Html::a('Blog List', Url::to(['/blog/list'])) ?></li>
                                            <li><?= Html::a('Blog List Left Sidebar', Url::to(['/blog/list-left-sidebar'])) ?></li>
                                            <li><?= Html::a('Blog List Right Sidebar', Url::to(['/blog/list-right-sidebar'])) ?></li>
                                        </ul>
                                    </li>
                                    <li class="dropdown position-static">
                                        <?= Html::a('Single Blog <i class="fa fa-angle-right"></i>', Url::to(['/blog/single-left-sidebar'])) ?>
                                        <ul class="sub-menu sub-menu-2">
                                            <li><?= Html::a('Single Blog', Url::to(['/blog/single'])) ?></li>
                                            <li><?= Html::a('Single Blog Left Sidebar', Url::to(['/blog/single-left-sidebar'])) ?></li>
                                            <li><?= Html::a('Single Blog Right Sidebar', Url::to(['/blog/single-right-sidebar'])) ?></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>

                            <!-- Contact page -->
                            <li>
                                <?= Html::a('Contact', Url::to(['/site/contact'])) ?>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- header navigation area end -->
        <div class="mobile-search-box d-lg-none">
            <div class="container">
                <!-- mobile search start -->
                <div class="search-element max-width-100">
                    <form action="#">
                        <input type="text" placeholder="Search"/>
                        <button><i class="pe-7s-search"></i></button>
                    </form>
                </div>
                <!-- mobile search start -->
            </div>
        </div>
    </header>
    <!-- offcanvas overlay start -->
    <div class="offcanvas-overlay"></div>
    <!-- offcanvas overlay end -->
    <!-- OffCanvas Wishlist Start -->
    <div id="offcanvas-wishlist" class="offcanvas offcanvas-wishlist">
        <div class="inner">
            <div class="head">
                <span class="title">Wishlist</span>
                <button class="offcanvas-close">×</button>
            </div>
            <div class="body customScroll">
                <ul class="minicart-product-list" id="wish-list">
                    <?php foreach ($wishlist as $item) :?>
                        <li id="wishlist-item-<?= $item->id ?>" class="wishlist-item-<?= $item->id ?>">
                            <a href="<?= Url::to(['product/view', 'id' => $item->product->id]) ?>" class="image"><?= Html::img('http://localhost:8888/'  . $item->product->productImages[0]->image_path, ['alt' => $item->product->name]) ?>
                            </a>
                            <div class="content">
                                <a href="single-product.html" class="title"><?= $item->product->name ?></a>

                                <?= Html::button('×',[

                                    'hx-get' => Url::to(['cart/del-wishlist-item', 'id' => $item->id]),
                                    'hx-target' => '#wishlist-item-' . $item->id,
                                    'hx-swap' => 'outerHTML',
                                    'hx-confirm' => 'Are you sure you want to delete this item?',
                                ])?>

                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="foot">
                <div class="buttons">
                    <a href="/cart/view-wishlist" class="btn btn-dark btn-hover-primary mt-30px">view wishlist</a>
                </div>
            </div>
        </div>
    </div>
    <!-- OffCanvas Wishlist End -->
    <!-- OffCanvas Cart Start -->
    <div id="offcanvas-cart" class="offcanvas offcanvas-cart">
        <div class="inner">
            <div class="head">
                <span class="title">Cart</span>
                <button class="offcanvas-close">×</button>
            </div>
            <div class="body customScroll">
                <ul class="minicart-product-list" id="cart-list">

                    <?php foreach ($cart_items as $cart_item) :?>
                        <li id="cart-item-<?= $cart_item->id ?>" class="cart-item-<?= $cart_item->id ?>">
                            <a href="<?= Url::to(['product/view', 'id' => $cart_item->product->id]) ?>" class="image"><?= Html::img('http://localhost:8888/'  . $cart_item->product->productImages[0]->image_path, ['alt' => $cart_item->product->name]) ?>
                            </a>
                            <div class="content">
                                <a href="single-product.html" class="title"><?= $cart_item->product->name ?></a>
                                <span class="quantity-price"><?= $cart_item->quantity?> x <span class="amount"><?= $cart_item->product->price ?></span></span>
                                <?= Html::button('×',[

                                    'hx-get' => Url::to(['cart/del-cart-item', 'id' => $cart_item->id]),
                                    'hx-target' => '#cart-item-' . $cart_item->id,
                                    'hx-swap' => 'outerHTML',
                                    'hx-confirm' => 'Are you sure you want to delete this item?',
                                ])?>

                            </div>
                        </li>
                    <?php endforeach; ?>

                </ul>
            </div>
            <div class="foot">
                <div class="buttons mt-30px">
                    <a href="/cart" class="btn btn-dark btn-hover-primary mb-30px">view cart</a>
                    <a href="/cart/checkout" class="btn btn-outline-dark current-btn">checkout</a>
                </div>
            </div>
        </div>
    </div>
    <!-- OffCanvas Cart End -->
    <!-- OffCanvas Menu Start -->
    <div id="offcanvas-mobile-menu" class="offcanvas offcanvas-mobile-menu">
        <button class="offcanvas-close"></button>
        <div class="user-panel">
            <ul>
                <li><a href="tel:0123456789"><i class="fa fa-phone"></i> +012 3456 789</a></li>
                <li><a href="mailto:demo@example.com"><i class="fa fa-envelope-o"></i> demo@example.com</a></li>
                <li><a href="my-account.html"><i class="fa fa-user"></i> Account</a></li>
            </ul>
        </div>
        <div class="inner customScroll">
            <div class="offcanvas-menu mb-4">
                <ul>
                    <li><a href="#"><span class="menu-text">Home</span></a>
                        <ul class="sub-menu">
                            <li><a href="index.html"><span class="menu-text">Home 1</span></a></li>
                            <li><a href="index-2.html"><span class="menu-text">Home 2</span></a></li>
                        </ul>
                    </li>
                    <li><a href="about.html">About</a></li>
                    <li>
                        <a href="#"><span class="menu-text">Pages</span></a>
                        <ul class="sub-menu">
                            <li>
                                <a href="#"><span class="menu-text">Inner Pages</span></a>
                                <ul class="sub-menu">
                                    <li><a href="404.html">404 Page</a></li>
                                    <li><a href="order-tracking.html">Order Tracking</a></li>
                                    <li><a href="faq.html">Faq Page</a></li>
                                    <li><a href="coming-soon.html">Coming Soon Page</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="#"><span class="menu-text"> Other Shop Pages</span></a>
                                <ul class="sub-menu">
                                    <li><a href="cart.html">Cart Page</a></li>
                                    <li><a href="checkout.html">Checkout Page</a></li>
                                    <li><a href="compare.html">Compare Page</a></li>
                                    <li><a href="wishlist.html">Wishlist Page</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="#"><span class="menu-text">Related Shop Page</span></a>
                                <ul class="sub-menu">
                                    <li><a href="my-account.html">Account Page</a></li>
                                    <li><a href="login.html">Login & Register Page</a></li>
                                    <li><a href="empty-cart.html">Empty Cart Page</a></li>
                                    <li><a href="thank-you-page.html">Thank You Page</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li><a href="#"><span class="menu-text">Shop</span></a>
                        <ul class="sub-menu">
                            <li>
                                <a href="#"><span class="menu-text">Shop Page</span></a>
                                <ul class="sub-menu">
                                    <li><a href="shop-3-column.html">Shop 3 Column</a></li>
                                    <li><a href="shop-4-column.html">Shop 4 Column</a></li>
                                    <li><a href="shop-left-sidebar.html">Shop Left Sidebar</a></li>
                                    <li><a href="shop-right-sidebar.html">Shop Right Sidebar</a></li>
                                    <li><a href="shop-list-left-sidebar.html">Shop List Left Sidebar</a>
                                    </li>
                                    <li><a href="shop-list-right-sidebar.html">Shop List Right Sidebar</a>
                                    </li>
                                    <li><a href="cart.html">Cart Page</a></li>
                                    <li><a href="checkout.html">Checkout Page</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="#"><span class="menu-text">product Details Page</span></a>
                                <ul class="sub-menu">
                                    <li><a href="single-product.html">Product Single</a></li>
                                    <li><a href="single-product-variable.html">Product Variable</a></li>
                                    <li><a href="single-product-affiliate.html">Product Affiliate</a></li>
                                    <li><a href="single-product-group.html">Product Group</a></li>
                                    <li><a href="single-product-tabstyle-2.html">Product Tab 2</a></li>
                                    <li><a href="single-product-tabstyle-3.html">Product Tab 3</a></li>
                                    <li><a href="single-product-slider.html">Product Slider</a></li>
                                    <li><a href="single-product-gallery-left.html">Product Gallery Left</a>
                                </ul>
                            </li>
                            <li>
                                <a href="#"><span class="menu-text">Single Product Page</span></a>
                                <ul class="sub-menu">
                                    <li><a href="single-product-gallery-right.html">Product Gallery
                                            Right</a></li>
                                    <li><a href="single-product-sticky-left.html">Product Sticky Left</a>
                                    </li>
                                    <li><a href="single-product-sticky-right.html">Product Sticky Right</a>
                                    </li>
                                    <li><a href="compare.html">Compare Page</a></li>
                                    <li><a href="wishlist.html">Wishlist Page</a></li>
                                    <li><a href="my-account.html">Account Page</a></li>
                                    <li><a href="login.html">Login & Register Page</a></li>
                                    <li><a href="empty-cart.html">Empty Cart Page</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li><a href="#"><span class="menu-text">Blog</span></a>
                        <ul class="sub-menu">
                            <li><a href="blog-grid.html">Blog Grid Page</a></li>
                            <li><a href="blog-grid-left-sidebar.html">Grid Left Sidebar</a></li>
                            <li><a href="blog-grid-right-sidebar.html">Grid Right Sidebar</a></li>
                            <li><a href="blog-list.html">Blog List Page</a></li>
                            <li><a href="blog-list-left-sidebar.html">List Left Sidebar</a></li>
                            <li><a href="blog-list-right-sidebar.html">List Right Sidebar</a></li>
                            <li><a href="blog-single.html">Blog Single Page</a></li>
                            <li><a href="blog-single-left-sidebar.html">Single Left Sidebar</a></li>
                            <li><a href="blog-single-right-sidebar.html">Single Right Sidbar</a>
                        </ul>
                    </li>
                    <li><a href="contact.html">Contact Us</a></li>
                </ul>
            </div>
            <!-- OffCanvas Menu End -->
            <div class="offcanvas-social mt-auto">
                <ul>
                    <li>
                        <a href="#"><i class="fa fa-facebook"></i></a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-twitter"></i></a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-google"></i></a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-youtube"></i></a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-instagram"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>


    <!--    content -->

    <?= $content ?>
    <!-- Footer Area Start -->
    <div class="footer-area">
        <div class="footer-container">
            <div class="footer-top">
                <div class="container">
                    <div class="row">
                        <!-- Start single blog -->
                        <div class="col-md-6 col-lg-3 mb-md-30px mb-lm-30px">
                            <div class="single-wedge">
                                <div class="footer-logo">
                                    <a href="index.html"><img src="/images/logo/footer-logo.png" alt=""></a>
                                </div>
                                <p class="about-text">Lorem ipsum dolor sit amet consl adipisi elit, sed do eiusmod
                                    templ incididunt ut labore
                                </p>
                                <ul class="link-follow">
                                    <li>
                                        <a class="m-0" title="Twitter" target="_blank" rel="noopener noreferrer"
                                           href="#"><i class="fa fa-facebook"
                                                       aria-hidden="true"></i></a>
                                    </li>
                                    <li>
                                        <a title="Tumblr" target="_blank" rel="noopener noreferrer" href="#"><i
                                                    class="fa fa-tumblr" aria-hidden="true"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a title="Facebook" target="_blank" rel="noopener noreferrer" href="#"><i
                                                    class="fa fa-twitter" aria-hidden="true"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a title="Instagram" target="_blank" rel="noopener noreferrer" href="#"><i
                                                    class="fa fa-instagram" aria-hidden="true"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- End single blog -->
                        <!-- Start single blog -->
                        <div class="col-md-6 col-lg-3 col-sm-6 mb-lm-30px pl-lg-60px">
                            <div class="single-wedge">
                                <h4 class="footer-herading">Services</h4>
                                <div class="footer-links">
                                    <div class="footer-row">
                                        <ul class="align-items-center">
                                            <li class="li"><a class="single-link" href="my-account.html">My Account</a>
                                            </li>
                                            <li class="li"><a class="single-link" href="contact.html">Contact</a></li>
                                            <li class="li"><a class="single-link" href="cart.html">Shopping cart</a>
                                            </li>
                                            <li class="li"><a class="single-link" href="shop-left-sidebar.html">Shop</a>
                                            </li>
                                            <li class="li"><a class="single-link" href="login.html">Services Login</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End single blog -->
                        <!-- Start single blog -->
                        <div class="col-md-6 col-lg-3 col-sm-6 mb-lm-30px pl-lg-40px">
                            <div class="single-wedge">
                                <h4 class="footer-herading">My Account</h4>
                                <div class="footer-links">
                                    <div class="footer-row">
                                        <ul class="align-items-center">
                                            <li class="li"><a class="single-link" href="my-account.html">My Account</a>
                                            </li>
                                            <li class="li"><a class="single-link" href="contact.html">Contact</a></li>
                                            <li class="li"><a class="single-link" href="cart.html">Shopping cart</a>
                                            </li>
                                            <li class="li"><a class="single-link" href="shop-left-sidebar.html">Shop</a>
                                            </li>
                                            <li class="li"><a class="single-link" href="login.html">Services Login</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End single blog -->
                        <!-- Start single blog -->
                        <div class="col-md-6 col-lg-3 col-sm-12">
                            <div class="single-wedge">
                                <h4 class="footer-herading">Contact Info</h4>
                                <div class="footer-links">
                                    <!-- News letter area -->
                                    <p class="address">Address: Your Address Goes Here.</p>
                                    <p class="phone">Phone/Fax:<a href="tel:0123456789"> 0123456789</a></p>
                                    <p class="mail">Email:<a href="mailto:demo@example.com"> demo@example.com</a></p>
                                    <p class="mail"><a href="https://demo@example.com"> demo@example.com</a></p>
                                    <!-- News letter area  End -->
                                </div>
                            </div>
                        </div>
                        <!-- End single blog -->
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <div class="container">
                    <div class="line-shape-top line-height-1">
                        <div class="row flex-md-row-reverse align-items-center">
                            <div class="col-md-6 text-center text-md-end">
                                <div class="payment-mth"><a href="#"><img class="img img-fluid"
                                                                          src="assets/images/icons/payment.png"
                                                                          alt="payment-image"></a></div>
                            </div>
                            <div class="col-md-6 text-center text-md-start">
                                <p class="copy-text"> © 2021 <strong>Hmart</strong> Made With <i class="fa fa-heart"
                                                                                                 aria-hidden="true"></i>
                                    By <a class="company-name"
                                          href="https://themeforest.net/user/codecarnival/portfolio">
                                        <strong> Codecarnival </strong></a>.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer Area End -->
</div>
</body>
<?php $this->endBody() ?>
</html>
<?php $this->endPage() ?>