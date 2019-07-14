<?php
/**
 * Created by PhpStorm.
 * User: jiuzheyang
 * Date: 2019/7/10
 * Time: 下午3:42
 */

namespace App\Http\Controllers\Api;


use App\Http\Helper\ResultHelper;
use Encore\Admin\Services\UserService;
use Encore\Admin\Transformers\UserTransformer;

class TestController extends Controller
{
    /**
     * UserController constructor.
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * 测试
     * @description 就单单是个测试
     * @author 刘富胜
     * @create_time 201919-7-11
     */
    public function test()
    {

        $transformer = new UserTransformer();
        $api = $transformer->transform($this->userService->getUserByAuthApi());
        dd($this->userService->getUserByAuthApi()->avatar);
        return ResultHelper::generate(ResultHelper::SUCCESS_CODE,'', $this->userService->getUserByAuthApi()->avatar ,false);
    }

}