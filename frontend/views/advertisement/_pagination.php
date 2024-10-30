<?php
?>

<div class="pro-pagination-style text-center text-lg-center" data-aos="fade-up" data-aos-delay="200">
    <div class="pages">
        <ul>
            <li class="li">
                <?= \yii\widgets\LinkPager::widget([
                    'pagination' => $pages,
                    'options' => ['class' => 'pages'], // Custom class for styling
                    'nextPageLabel' => '<i class="fa fa-angle-right"></i>',
                    'prevPageLabel' => '<i class="fa fa-angle-left"></i>',
                    'linkOptions' => ['class' => 'page-link'],
                    'activePageCssClass' => 'active', // Active page class
                    'disabledPageCssClass' => 'disabled', // Disabled button class
                    'maxButtonCount' => 5, // Number of pagination links to show
                ]) ?>
            </li>
        </ul>
    </div>
</div>
