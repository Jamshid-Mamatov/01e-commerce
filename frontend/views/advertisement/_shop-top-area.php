<?php




use yii\helpers\Html;


//\common\components\Utils::printAsError($dataProvider->sort);
?>

<div class="shop-top-bar d-flex">
    <p class="compare-product"> <span><?= $dataProvider->count ?></span> Product Found of <span><?= $dataProvider->totalCount ?></span></p>



    <div class="select-shoing-wrap d-flex align-items-center">
        <div class="shot-product">
            <p>Sort By:</p>
        </div>
        <!-- Single Wedge End -->
        <div class="header-bottom-set dropdown">
            <button class="dropdown-toggle header-action-btn" data-bs-toggle="dropdown">
                Default <i class="fa fa-angle-down"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-right">
                <li><?= $dataProvider->sort->link('name') ?></li>
                <li><?= $dataProvider->sort->link('price') ?></li>
                <li><?= $dataProvider->sort->link('created_at') ?></li>

            </ul>
        </div>
        <!-- Single Wedge Start -->
    </div>
    <!-- Right Side End -->
</div>
