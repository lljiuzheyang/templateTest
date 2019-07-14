<?php

use Monolog\Handler\StreamHandler;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Log Channel
    |--------------------------------------------------------------------------
    |
    | This option defines the default log channel that gets used when writing
    | messages to the logs. The name specified in this option should match
    | one of the channels defined in the "channels" configuration array.
    |
    */

    'default' => env('LOG_CHANNEL', 'stack'),

    /*
    |--------------------------------------------------------------------------
    | Log Channels
    |--------------------------------------------------------------------------
    |
    | Here you may configure the log channels for your application. Out of
    | the box, Laravel uses the Monolog PHP logging library. This gives
    | you a variety of powerful log handlers / formatters to utilize.
    |
    | Available Drivers: "single", "daily", "slack", "syslog",
    |                    "errorlog", "monolog",
    |                    "custom", "stack"
    |
    */

    'channels' => [
        'stack' => [
            'driver' => 'stack',
            'channels' => ['single'],
        ],

        'single' => [
            'driver' => 'single',
            'path' => storage_path('logs/laravel.log'),
            'level' => 'debug',
        ],

        'daily' => [
            'driver' => 'daily',
            'path' => storage_path('logs/laravel.log'),
            'level' => 'debug',
            'days' => 7,
            // 防止队列使用root执行变更文件权限导致www-data写不进去 | 0666
            'permission' => 0666
        ],

        'slack' => [
            'driver' => 'slack',
            'url' => env('LOG_SLACK_WEBHOOK_URL'),
            'username' => 'Laravel Log',
            'emoji' => ':boom:',
            'level' => 'critical',
        ],

        'stderr' => [
            'driver' => 'monolog',
            'handler' => StreamHandler::class,
            'with' => [
                'stream' => 'php://stderr',
            ],
        ],

        'syslog' => [
            'driver' => 'syslog',
            'level' => 'debug',
        ],

        'errorlog' => [
            'driver' => 'errorlog',
            'level' => 'debug',
        ],

        // 自定义
        'info_daily' => [
            'driver' => 'daily',
            'path' => storage_path('logs/laravel-info.log'),
            'level' => 'debug',
            'days' => 7,
        ],

        'request_daily' => [
            'driver' => 'daily',
            'path' => storage_path('logs/laravel-request.log'),
            'level' => 'debug',
            'days' => 7,
        ],

        'query_daily' => [
            'driver' => 'daily',
            'path' => storage_path('logs/laravel-query.log'),
            'level' => 'debug',
            'days' => 7,
        ],

        'error_daily' => [
            'driver' => 'daily',
            'path' => storage_path('logs/laravel-error.log'),
            'level' => 'debug',
            'days' => 7,
        ],
    ],

];
