<?php

namespace common\rbac;
use common\components\Utils;
use yii\rbac\Rule;

class AuthorRule extends Rule {
    public $name = 'isAuthor';

    public function execute($user, $item, $params) {
//        Utils::printAsError($user);
        return isset($params['post']) ? $params['post']->created_by == $user : false;
    }
}