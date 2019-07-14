<?php

/*
 * What extreme-vision team is that is 'one thing, a team, work together'
 */

namespace App\Http\Controllers\Api;

use App\Http\Helper\ResultHelper;
use App\Http\Requests\Api\UserAuthRequest;
use Encore\Admin\Services\UserService;
use Encore\Admin\Transformers\UserTransformer;

class UserController extends Controller
{
    /**
     * @var :inject userService;
     */
    protected $userService;

    /**
     * UserController constructor.
     *
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * 登录.
     *
     * @description 南瑞用户登录 用户名 密码
     *
     * @author 刘富胜
     * @create_time 2019-7-12
     *
     * @param UserAuthRequest $request username=>用户名，password=>密码
     */
    public function login(UserAuthRequest $request)
    {
        $token = $this->userService->getLoginToken($request->username, $request->password);
        if (!$token) {
            return ResultHelper::generate(ResultHelper::ERROR_CODE, '未激活或用户名、密码错误',
                [], true);
        }
        $transformer = new UserTransformer();
        $data        = array_merge(
            $this->userService->respondWithToken($token),
            $transformer->transform($this->userService->getUserByAuthApi())
        );

        return ResultHelper::generate(ResultHelper::SUCCESS_CODE, '', $data, true);
    }

    /**
     * 获取用户信息.
     *
     * @description 获取用户详情信息
     *
     * @author 刘富胜
     * @create_time 2019-7-12
     */
    public function info()
    {
        $transformer = new UserTransformer();
        $data        = array_merge(
            $transformer->transform($this->userService->getUserByAuthApi()
            )
        );

        return ResultHelper::generate(ResultHelper::SUCCESS_CODE, '', $data, true);
    }

    /**
     * 退出登录.
     *
     * @description 退出登录
     *
     * @author 刘富胜
     * @create_time 2019-7-12
     */
    public function logout()
    {
        auth()->logout();

        return ResultHelper::generate(ResultHelper::SUCCESS_CODE, '', [], true);
    }
}
