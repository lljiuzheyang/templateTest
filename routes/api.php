<?php

use Dingo\Api\Routing\Router;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| here is where you can register api routes for your application. these
| routes are loaded by the routeserviceprovider within a group which
| is assigned the "api" middleware group. enjoy building your api!
|
*/

/**
 * @var Dingo\Api\Routing\Router $api
 */
$api = app('Dingo\Api\Routing\Router');

$api->version('v1', [
    'prefix'     => config('admin.route.prefix'),
    'namespace'  => 'App\Http\Controllers\Api',
    'middleware' => 'serializer:array',//返回数据结构为 ArraySerializer
], function (Router $api) {
    $api->post('/user/login', 'UserController@login');//用户登录
    // 需要 token 验证的接口
    $api->group(['middleware' => config('admin.route.middleware')], function (Router $api) {
        $api->post('/user/logout', 'UserController@logout');//退出登录
        $api->get('/user/info', 'UserController@info');//用户详情信息
        $api->get('test', 'TestController@test');//测试
        $api->get('/template-manager/list', 'TemplateManagerController@list');//模版列表
    });
});
