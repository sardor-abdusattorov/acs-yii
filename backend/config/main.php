<?php

use yii\log\FileTarget;

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
    'language' => 'ru',
    'bootstrap' => ['log'],
    'aliases' => [
        '@mdm/admin' => '@backend/extensions/mdm/yii2-admin'
    ],
     'modules' => [
        'rbac' => [
            'class' => 'mdm\admin\Module',
            'controllerMap' => [
                'assignment' => [
                    'class' => 'mdm\admin\controllers\AssignmentController',
                    'idField' => 'id',
                    'usernameField' => 'username',
                ],
            ],
            'layout' => 'left-menu',
            'mainLayout' => '@app/views/layouts/main.php',
        ],
            'gii' => [
                'class' => 'yii\gii\Module',
                'allowedIPs' => ['127.0.0.1', '::1', '195.158.15.189'],
                'generators' => [
                    'myCrud' => [
                        'class' => 'backend\generators\crud\Generator',
                        'templates' => [
                            'template' => '@app/generators/crud/template'
                        ]
                    ]
                ]
            ],
    ],
    'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => [
            'site/*',
        ]
    ],
    'components' => [
        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => yii\i18n\DbMessageSource::class,
                    'sourceLanguage' => 'en-US',
                    'forceTranslation' => true,
                ],
            ],
        ],
        'request' => [
            'enableCsrfValidation' => false,
            'csrfParam' => '_csrf-backend',
            'baseUrl' => '/admin',
        ],
        'formatter' => [
            'datetimeFormat' => 'php:H:i',
            'timeZone' => 'Asia/Tashkent',
        ],
       'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            'name' => 'advanced-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '' => 'site/index',
                'login' => 'site/login',
                'logout' => 'site/logout',
//                "<controller>/<action>/<id:\w+>" => '<controller>/<action>',
                "<controller>/<action>/<id:\w+>/<cat:\w+>" => '<controller>/<action>',
            ],
        ],

    ],
    'params' => $params,
];
