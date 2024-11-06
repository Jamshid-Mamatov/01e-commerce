<?php
namespace backend\resource;


use yii\filters\auth\HttpBearerAuth;

class Product  extends \common\models\Product
{


//    public $enableCsrfValidation = false;




    public function fields(){

        return ['id',
            'name',
            'price',
            'category_name'=>function($model){
            return $model->category ? $model->category->name : "";
            },
            'image'=>function($model){
                if ($model->productImages) {
                    return array_map(function($item){
                        return $item->image_path;
                    },$model->productImages);
                }


                return [];
            }
            ];
    }

//    public function extraFields(){
//
//        return ['productImages','category'];
//    }
}