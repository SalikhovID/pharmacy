<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => \yii\caching\FileCache::class,
        ],
        'db' => [
            'class' => \yii\db\Connection::class,
            'dsn' => 'pgsql:host='.env('DB_HOST').';port=5432;dbname='.env('DB_NAME'),
            'username' => env('DB_USER'),
            'password' => env('DB_PASS'),
            'charset' => 'utf8',
        ]
    ],
];
