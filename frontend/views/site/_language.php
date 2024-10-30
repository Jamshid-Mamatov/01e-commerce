<?php

use yii\helpers\Html;
?>
<!--<div class="dropdown">-->
<!--    <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">-->
<!--        <i class="flag-icon flag-icon-us"></i> English-->
<!--    </button>-->
<!--    <ul class="dropdown-menu">-->
<!--        <a class="dropdown-item" href="--><?php //= \yii\helpers\Url::to(['site/language', 'lang' => 'en']) ?><!--">-->
<!--            <i class="flag-icon flag-icon-us"></i> English-->
<!--        </a>-->
<!--        <a class="dropdown-item" href="--><?php //= \yii\helpers\Url::to(['site/language', 'lang' => 'ru']) ?><!--">-->
<!--            <i class="flag-icon flag-icon-ru"></i> Russian-->
<!--        </a>-->
<!--        <a class="dropdown-item" href="--><?php //= \yii\helpers\Url::to(['site/language', 'lang' => 'uz']) ?><!--">-->
<!--            <i class="flag-icon flag-icon-uz"></i> Uzbek-->
<!--        </a>-->
<!--    </ul>-->
<!--</div>-->

<select class="selectpicker language-selector" data-width="fit">
    <option data-content='<span class="flag-icon flag-icon-us"></span> English' value="<?= \yii\helpers\Url::to(['site/language', 'lang' => 'en']) ?>" <?= Yii::$app->language === 'en' ? 'selected' : '' ?>>English</option>
    <option data-content='<span class="flag-icon flag-icon-ru"></span> Russian' value="<?= \yii\helpers\Url::to(['site/language', 'lang' => 'ru']) ?>" <?= Yii::$app->language === 'ru' ? 'selected' : '' ?>>Russian</option>
    <option data-content='<span class="flag-icon flag-icon-uz"></span> Uzbek' value="<?= \yii\helpers\Url::to(['site/language', 'lang' => 'uz']) ?>" <?= Yii::$app->language === 'uz' ? 'selected' : '' ?>>Uzbek</option>
</select>
