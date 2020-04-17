<?php

$includes = require __DIR__ . '/config.php';

$config = [
    'id'         => 'app',
    'basePath'   => dirname( __DIR__ ),
    'bootstrap'  => [ 'log' ],
    'aliases'    => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => \yii\helpers\ArrayHelper::merge( [
        'request'      => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'o4SkWEhER5trkLnOMWRh-H28uzZlRXa6',
        ],
        'user'         => [
            'identityClass'   => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'response'     => [
            'format'        => yii\web\Response::FORMAT_JSON,
            'formatters'    => [
                \yii\web\Response::FORMAT_JSON => [
                    'class'         => 'yii\web\JsonResponseFormatter',
                    'prettyPrint'   => YII_DEBUG,
                    'encodeOptions' => JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE,
                ],
            ],
            'charset'       => 'UTF-8',
            'on beforeSend' => function ($event) {

                $response = $event->sender;
                $answer = [
                    'success' => $response->isSuccessful,
                    'code'    => $response->statusCode,
                ];
                if ($response->data !== null) {
                    $answer['data'] = $response->data;
                }
                $response->data = $answer;
            },
        ],
    ], [
        $includes['config']
    ] ),
    'params'     => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
