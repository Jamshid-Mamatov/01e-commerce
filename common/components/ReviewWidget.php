<?php

namespace common\components;

use yii\base\Widget;

class ReviewWidget extends Widget
{
    public $newReview;
    public $productId;
    public $reviews;

    public function init()
    {
        parent::init();
        // You can set default values or process data here if needed
    }

    public function run()
    {
        // Render the widget content with the passed data
        return $this->render('review', [
            'newReview' => $this->newReview,
            'productId' => $this->productId,
            'reviews' => $this->reviews,
        ]);
    }
}