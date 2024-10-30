<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

?>
<div class="account-dashboard pt-100px pb-100px">

    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-3 col-lg-3">
                <!-- Nav tabs -->
                <div class="dashboard_tab_button" data-aos="fade-up" data-aos-delay="0">
                    <ul role="tablist" class="nav flex-column dashboard-list">
                        <li><a href="#dashboard" data-bs-toggle="tab" class="nav-link active">Dashboard</a></li>
                        <li> <a href="#orders" data-bs-toggle="tab" class="nav-link">Orders</a></li>
<!--                        <li><a href="#downloads" data-bs-toggle="tab" class="nav-link">Downloads</a></li>-->
                        <li><a href="#address" data-bs-toggle="tab" class="nav-link">Addresses</a></li>
                        <li><a href="#account-details" data-bs-toggle="tab" class="nav-link">Account details</a>
                        </li>
                        <li>
                            <?= Html::beginForm(['/site/logout'], 'post', ['class' => 'd-inline']) ?>
                            <?= Html::submitButton(
                                'Logout (' . Yii::$app->user->identity->username . ')',
                                ['class' => 'btn btn-link nav-link text-decoration-none p-0 m-0', 'style' => 'background: none; border: none;']
                            ) ?>
                            <?= Html::endForm() ?>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-sm-12 col-md-9 col-lg-9">
                <!-- Tab panes -->
                <div class="tab-content dashboard_content" data-aos="fade-up" data-aos-delay="200">
                    <div class="tab-pane fade show active" id="dashboard">
                        <h4>Dashboard </h4>
                        <p>From your account dashboard. you can easily check &amp; view your <a href="#">recent
                                orders</a>, manage your <a href="#">shipping and billing addresses</a> and <a href="#">Edit your password and account details.</a></p>
                    </div>
                    <div class="tab-pane fade" id="orders">
                    <?php Pjax::begin(['id'=>'orders-pjax','enablePushState'=>false]);?>

                        <h4>Orders</h4>
                        <div class="table_page table-responsive">
                            <?= \yii\grid\GridView::widget([
                                    'dataProvider' => $dataProvider,
                                    'columns' => [
                                            ['class' => 'yii\grid\SerialColumn', 'header' => 'Order'],

                                        [
                                                'attribute' =>'created_at',
                                            'format' => ['date', 'php:d-m-Y'],
                                            'header' => 'Order Date',
                                        ],
                                        [
                                                'attribute' =>'status',
                                                'header' => 'Status',
                                                'value' => function($model){
                                                    return Html :: tag('span', ucfirst($model->status) ,[
                                                            'class'=> $model->status
                                                    ]);
                                                },
                                                'format' => 'raw',
                                        ],
                                        [
                                                'attribute' =>'total',
                                                'header' => 'Total',
                                                'value' => function($model){
                                                    return '$' . number_format($model->total_amount, 2);
                                                }
                                        ],
                                        [
                                                'class' => 'yii\grid\ActionColumn',
                                            'header' => 'Actions',
                                            'template' => '{view}',
                                            'buttons' => [
                                                    'view' => function ($url, $model) {
                                                        return Html::a('View',Url::to(['order/view', 'id' => $model->id]), ['class' => 'view']);
                                                    },
                                                ]
                                        ],

                                    ]
                            ]); ?>
                        </div>

                    <?php Pjax::end();?>
                    </div>
                    <div class="tab-pane" id="address">
                    <?php Pjax::begin(['id'=>'address-details-pjax','enablePushState'=>false, 'timeout' => false]); ?>

                            <?= $this->render('_addressDetails', ['user_info' => $user_info]) ?>

                    <?php Pjax::end()?>
                    </div>
                    <div class="tab-pane" id="account-details">
                    <?php Pjax::begin(['id'=>'account-details-pjax','enablePushState'=>false, 'timeout' => false]); ?>

                            <h3>Account details </h3>
                            <?= $this->render('_accountDetails',['user_info'=>$user_info])?>

                    <?php Pjax::end()?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

