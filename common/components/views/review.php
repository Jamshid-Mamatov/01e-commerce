<?php

/**
 * @var $reviews common\models\Review[]
 * @var $newReview common\models\Review
 * @var $pagination yii\data\Pagination
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;


?>

<?php if (!empty($reviews)) : ?>
    <div class="review-wrapper">
        <?php foreach ($reviews as $review) : ?>

            <div class="single-review">
                <div class="review-content">
                    <div class="review-top-wrap">
                        <div class="review-left">
                            <div class="reviwer-info">
                                <?= \yii\helpers\Html::encode($review->user->username) ?>
                                (<?= Yii::$app->formatter->asDate($review->created_at) ?>)

                            </div>

                            <div class="reviewer-info">
                                Rating : <?= str_repeat("★", $review->rating). str_repeat('☆', 5 - $review->rating) ?>
                            </div>
                        </div>
                    </div>
                    <div class="review-bottom">
                        <p><?= \yii\helpers\Html::encode($review->comment) ?></p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

        </div>

<?php endif;?>
<!-- Review submission form -->


    <?php if (!Yii::$app->user->isGuest): ?>
        <div class="review-form">
            <h3>Submit Your Review</h3>

            <?php $form = ActiveForm::begin(['options' => ['data-pjax' => true]]); ?>
            <?= $form->field($newReview, 'rating')->dropDownList([5 => '5 Stars', 4 => '4 Stars', 3 => '3 Stars', 2 => '2 Stars', 1 => '1 Star'], ['prompt' => 'Select rating']) ?>
            <?= $form->field($newReview, 'comment')->textarea(['rows' => 4]) ?>
            <?= Html::submitButton('Submit Review', ['class' => 'btn btn-primary btn-hover-color-primary','style' => 'opacity: 1 !important; visibility: visible !important; display: inline-block !important;']) ?>
            <?php ActiveForm::end(); ?>
        </div>
    <?php else: ?>

    <p>Please <a href="<?= Yii::$app->urlManager->createUrl(['site/login']) ?>">login</a> to submit a review.</p>
<?php endif; ?>




