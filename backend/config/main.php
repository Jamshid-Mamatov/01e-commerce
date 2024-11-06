<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'api'=>[
            'class' => 'backend\modules\api\Module',
        ]
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'user' => [
            'identityClass' => 'common\models\User',
//            'enableAutoLogin' => true,
            'enableSession' => false,
            'loginUrl' => null,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning','info', 'trace'],
                    'logFile' => '@runtime/logs/app.log',
                    'logVars' => [], // Exclude $_SERVER, $_POST, etc., if you want fewer details

                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false,
            'rules' => [
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['api/auth', 'api/product', 'api/category','api/external-api'],  // Specify all controllers here
                    'pluralize' => false,
                    'extraPatterns' => [
                        'POST register' => 'register',  // POST request to /api/auth/register
                        'POST login' => 'login',        // POST request to /api/auth/login
                        'GET' => 'index',               // Default GET request to /api/product and /api/category
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/category',
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET <id:\d+>' => 'view',       // GET request to /api/category/<id>
//                        'POST <id:\d+>' => 'update',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/product',
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET <id:\d+>' => 'view',
                        // GET request to /api/product/<id>
                        'POST' => 'create',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/external-api',
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET' =>'index',
                    ],
                ],
                [
                    'pattern' => 'category/<id:\d+>/products',
                    'route' => 'product/category-products'
                ]
            ],
        ],


    ],
    'params' => $params,
];
