<?php


use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;

?>


<div class="shop-category-area pt-100px pb-100px">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?= $this->render('_shop-top-area', ['dataProvider' => $dataProvider]);?>
<!-- Tab Content Area Start -->

                <div class="row">
                    <div class="col">
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="shop-grid">
                                <div class="row mb-n-30px">

                                <?= ListView::widget([
                                    'dataProvider' => $dataProvider,
                                    'itemView' => '_product_item', // This view file renders each product
                                    'layout' => "{items}", // Customize the layout if needed

                                    'options' => [
                                            'tag' => false,
                                    ],
                                    'itemOptions' => [
                                            'tag' => false,
                                    ],
                                    'summary' => false, // Disable the "Showing X of Y items" text

                                ]); ?>
                            </div>
                            </div>
                        </div>
                    </div>


                </div>
                <?= $this->render('_pagination', ['pages' => $dataProvider->pagination]) ?>
<!-- --- -->

            </div>
        </div>
    </div>
</div>