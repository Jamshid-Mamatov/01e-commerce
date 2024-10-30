<?php

use common\models\Product;
use common\models\ProductAttributeValue;
use common\models\Review;

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var common\models\Product $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Products'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
$images=$model->productImages;
//\common\components\Utils::printAsError($images);
$mainImage = $images ? $images[0] : null;

//$reviews= Review::find()->where(['product_id'=>$model->id,'approved'=>1])->all();
$averageRating=Review::find()->where(['product_id'=>$model->id,'approved'=>1])->average('rating');

//$attributes1=$model->getProductAttributeValues()->where(['product_id'=>$model->id])->all();

$attributes = ProductAttributeValue::find()
    ->select(['attribute.name as attribute_name','product_attribute_value.value as attribute_value'])
    ->joinWith('attribute0')
    ->where(['product_attribute_value.product_id'=>$model->id])
    ->asArray()
    ->all();

$similarProducts = $model->similarProducts1;
$relatedProducts = $model->relatedProducts1;
//\common\components\Utils::printAsError($relatedProducts);
?>



<!-- Product Details Area Start -->
<div class="product-details-area pt-100px pb-100px">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-sm-12 col-xs-12 mb-lm-30px mb-md-30px mb-sm-30px">
                <?php if ($mainImage):?>
                    <div class="main-image-container">
                        <?= Html::img('http://localhost:8888/'  . $mainImage->image_path, ['class'=>'img-responsive m-auto','alt' => $model->name]) ?>
                    </div>
                <?php endif;?>

                <?php if (count($images)>1): ?>
                    <?php $isSwiper = count($images) >4 ?>
                    <div class=" mt-20px <?php if ($isSwiper):  ?> zoom-thumb swiper-container slider-nav-style-1 small-nav <?php else:?> unswiper<?php endif;?>  ">
                        <div class="<?= $isSwiper ? 'swiper-wrapper' : '' ?>">
                            <?php foreach ($images as $index => $image):?>
                                <?php if ($index >0): ?>
                                    <div class="<?= $isSwiper ? 'swiper-slide' : '' ?>">
                                        <?= Html::img('http://localhost:8888/'  . $image->image_path, ['class'=>'img-responsive m-auto','alt' => $model->name]) ?>
                                    </div>
                                <?php endif;?>
                            <?php endforeach;?>
                        </div>
                        <?php if ($isSwiper) :  ?>
                        <div class="swiper-buttons">
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>
                        </div>
                        <?php endif;?>
                    </div>
                    <!-- Add Swiper Navigation Arrows -->

                <?php endif;?>
            </div>
            <div class="col-lg-6 col-sm-12 col-xs-12" data-aos="fade-up" data-aos-delay="200">
                <div class="product-details-content quickview-content ml-25px">
                    <h2><?= $model->name ?></h2>
                    <div class="price">

                            <?php if ($model->is_discount): ?>
                                <?= Html::tag('span', '$' . Html::encode($model->discount_price), ['class' => 'new']) ?>
                                <?= Html::tag('span', '$' . Html::encode($model->price), ['style'=>"text-decoration:line-through; color:grey"]) ?>
                            <?php else: ?>
                                <?= Html::tag('span', '$' . Html::encode($model->price), ['class' => 'new']) ?>
                            <?php endif; ?>

                    </div>


                    <div class="average-rating">
                        <h4>Average Rating</h4>
                        <div class="star-rating">
                            <?php
                                $rating = round($averageRating*2)/2;

                                for ($i = 1; $i <= 5; $i++){
                                    if ($i <= $rating) {
                                        // Full star
                                        echo '<i class="fa fa-star" style="color: #ffcc00;"></i>';
                                    } elseif ($i - 0.5 == $rating) {
                                        // Half star
                                        echo '<i class="fa fa-star-half-o" style="color: #ffcc00;"></i>';
                                    } else {
                                        // Empty star
                                        echo '<i class="fa fa-star-o" style="color: #ccc;"></i>';
                                    }
                            }
                            ?>
                        </div>
                        <p>Average rating based on <?= count($reviews); ?> reviews.</p>
                    </div>
                    <p class="mt-30px"><?= $model->description?></p>

                    <div class="pro-details-quality">

                        <div class="pro-details-cart">
                            <?= Html::button('Add To Cart',[
                                'class' => 'action add-cart',
                                'title' => 'Add To Cart',
                                'data-id' => $model->id,
                                'hx-get'=>'/site/add-to-cart?id='.$model->id,
                                'hx-target'=>'.minicart-product-list#cart-list',
                                'hx-swap'=>'beforeend'
                            ]) ?>
                        </div>
                        <div class="pro-details-compare-wishlist pro-details-wishlist ">
                            <?= Html::a('<i class="pe-7s-like"></i>', '',
                                ['class' => 'action add-to-wishlist',
                                'title' => 'Add To Wishlist',
                                'data-id' => $model->id,
                                'hx-get'=>'/site/add-to-wishlist?id='.$model->id,
                                'hx-target'=>'.minicart-product-list#wish-list',
                                'hx-swap'=>'beforeend'
                            ]) ?>
                        </div>


                    </div>
                </div>
                <!-- product details description area start -->
                <div class="description-review-wrapper">
                    <div class="description-review-topbar nav">
                        <button data-bs-toggle="tab" data-bs-target="#des-details2">Information</button>
                        <button class="active" data-bs-toggle="tab" data-bs-target="#des-details1">Description</button>
                        <button data-bs-toggle="tab" data-bs-target="#des-details3">Reviews (02)</button>
                    </div>
                    <div class="tab-content description-review-bottom">
                        <div id="des-details2" class="tab-pane">
                            <div class="product-anotherinfo-wrapper text-start">
                                <ul>
                                    <?php foreach ($attributes as $attribute) : ?>
                                        <?= Html::tag('li',
                                            Html::tag('span',$attribute['attribute_name']). " ".$attribute['attribute_value']) ?>
                                    <?php endforeach;?>
                                </ul>
                            </div>
                        </div>
                        <div id="des-details1" class="tab-pane active">
                            <div class="product-description-wrapper">
                                <?= Html::tag('p',$model->description)?>
                            </div>
                        </div>
                        <div id="des-details3" class="tab-pane">
                            <div class="row">
                                <div class="col-lg-12" id="review-form">
                                <?php Pjax::begin(['id'=>'review-pjax','enablePushState'=>false,'timeout'=>false]); ?>


                                            <?= \common\components\ReviewWidget::widget([
                                                'newReview' => $newReview,
                                                'productId' => $model->id,
                                                'reviews' => $reviews,
                                            ]) ?>

                                <?php Pjax::end(); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- product details description area end -->
            </div>
        </div>
    </div>
</div>
<!-- Product Area Start -->

<?= $this->render('_recently_viewed',['title'=>"Recently Viewed Products",'model'=>$recentlyViewedProducts])?>
<!-- Product Area End -->
<?= $this->render('_recently_viewed',['title'=>"Similar Products",'model'=>$similarProducts])?>

<?= $this->render('_recently_viewed',['title'=>"Related Products",'model'=>$relatedProducts])?>

