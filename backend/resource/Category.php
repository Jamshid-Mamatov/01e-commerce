<?php

namespace backend\resource;

class Category extends \common\models\Category
{

    public function fields()
    {
        return ['id',
            'name',
            'parent_id'
        ];
    }

    public function extraFields(){
        return ['parent','products'];
    }
}