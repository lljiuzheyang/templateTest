<?php

/*
 * What extreme-vision team is that is 'one thing, a team, work together'
 */

Admin::registerDefaultRoutes();

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', [
    'prefix'     => config('admin.route.prefix'),
    'namespace'  => config('admin.route.namespace'),
    'middleware' => [], //返回数据结构为 ArraySerializer
], function ($api) {
    $api->group(['middleware' => config('admin.route.middleware')], function ($api) {//需要登陆鉴权的路由
    });
});
