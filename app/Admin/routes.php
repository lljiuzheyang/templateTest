<?php
//注册login、rbac等路由
Admin::registerDefaultRoutes();

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', [
    'prefix' => config('admin.route.prefix'),
    'namespace' => config('admin.route.namespace'),
    'middleware' => [],//返回数据结构为 ArraySerializer
], function ($api) {
    $api->group(['middleware' => config('admin.route.middleware')], function ($api) {//需要登陆鉴权的路由
    });
});