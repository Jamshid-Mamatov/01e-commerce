<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
/**
 * @var  $order
 * @var $cart_items
 */
?>

<div class="checkout-area pt-100px pb-100px">
    <div class="container">
        <div class="row">
            <!-- Billing Details -->
            <div class="col-lg-7">
                <div class="billing-info-wrap">
                    <h3>Billing Details</h3>

                    <?php $form = ActiveForm::begin(['action' => Url::to(['cart/checkout']), 'method' => 'post']); ?>
                    <div class="row">
                        <!-- First Name -->
                        <div class="col-lg-6 col-md-6">
                            <div class="billing-info mb-4">
                                <?= $form->field($order, 'first_name')->textInput()->label('First Name') ?>
                            </div>
                        </div>
<!--                         Last Name -->
                        <div class="col-lg-6 col-md-6">
                            <div class="billing-info mb-4">
                                <?= $form->field($order, 'last_name')->textInput()->label('Last Name') ?>
                            </div>
                        </div>


                        <div class="col-lg-12">
                            <div class="billing-select mb-4">

                                <?= $form->field($order, 'country')->textInput()->label('Country') ?>
                            </div>
                        </div>
  <!--                         Street Address-->
                        <div class="col-lg-12">
                            <div class="billing-info mb-4">
                                <?= $form->field($order, 'address')->textInput(['placeholder' => 'House number and street name'])->label('Street Address') ?>
                                <?= Html::input('text', 'address_2', '', ['placeholder' => 'Apartment, suite, unit etc.']) ?>
                            </div>
                        </div>
<!--                         Town / City-->
                        <div class="col-lg-12">
                            <div class="billing-info mb-4">
                                <?= $form->field($order, 'city')->textInput()->label('Town / City') ?>
                            </div>
                        </div>

<!--                       Phone -->
                        <div class="col-lg-6 col-md-6">
                            <div class="billing-info mb-4">
                                <?= $form->field($order, 'phone')->textInput()->label('Phone') ?>
                            </div>
                        </div>
                        <!-- Email Address -->
                        <div class="col-lg-6 col-md-6">
                            <div class="billing-info mb-4">
                                <?= $form->field($order, 'email')->textInput(['type' => 'email'])->label('Email Address') ?>
                            </div>
                        </div>
                    </div>


                    <!-- Additional Information -->
                    <div class="additional-info-wrap">

                        <div class="additional-info">
                            <?= $form->field($order,'comment')->textarea( ['','placeholder' => 'Notes about your order, e.g. special notes for delivery.']) ?>
<!--                            --><?php //= Html::textarea('order_notes', '', ['placeholder' => 'Notes about your order, e.g. special notes for delivery.']) ?>
                        </div>
                    </div>




                </div>
            </div>

            <!-- Order Summary -->
            <div class="col-lg-5 mt-md-30px mt-lm-30px">
                <div class="your-order-area">
                    <h3>Your order</h3>
                    <div class="your-order-wrap gray-bg-4">
                        <div class="your-order-product-info">
                            <div class="your-order-top">
                                <ul>
                                    <li>Product</li>
                                    <li>Total</li>
                                </ul>
                            </div>
                            <div class="your-order-middle">
                                <ul>
                                    <!-- Product items -->
                                    <?php foreach ($cart_items as $cart_item): ?>
                                        <li><span class="order-middle-left"><?= $cart_item->product->name ?> X <?= $cart_item->quantity ?></span> <span class="order-price">$<?= $cart_item->price * $cart_item->quantity ?></span></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                            <div class="your-order-bottom">
                                <ul>
<!--                                    <li class="your-order-shipping">Shipping</li>-->
                                    <li> <?= $form->field($order, 'delivery_type')->dropDownList(

                                            ['standard'=>'Standart', 'express'=>"Express", 'pickup'=>"Pickup"],
                                        ) ?> </li>

                                </ul>
                            </div>
                            <div class="payment-mehtod">
                                <ul>

                                    <li> <?= $form->field($order, 'payment_type')->dropDownList(

                                            [
                                                "cash"=>'Cash','click'=>"Click", 'bank_transfer'=>'Bank Transfer',
                                            ],

                                        ) ?> </li>

                                </ul>
                            </div>


                            <div class="your-order-total">
                                <ul>
                                    <li class="order-total">Total</li>
                                    <li>$<?= \common\models\Cart::totalAmount() ?></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="Place-order mt-25">
                        <?= Html::submitButton('Place Order',['class' => 'btn btn-primary bg-primary']) ?>
                    </div>
                </div>
            </div>
            <?php ActiveForm::end(); ?>