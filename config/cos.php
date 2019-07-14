<?php
/**
 * Created by PhpStorm.
 * User: 王志豪
 * Date: 2019/2/25
 * Time: 11:33
 */
return [
    'region'      => env('COS_REGION', null),
    'credentials' => [
        'secretId'  => env('COS_SECRET_ID', null),
        'secretKey' => env('COS_SECRET_KEY', null),
    ],
    'appId'       => env('COS_APP_ID')
];
