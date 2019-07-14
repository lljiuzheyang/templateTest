<?php
/**
 * Created by PhpStorm.
 * User: jiuzheyang
 * Date: 2019/7/11
 * Time: 下午2:26
 */

namespace App\Http\Enums;


use App\Http\Helper\ResultHelper;

class CodeEnum
{
    /**
     * 获取状态码信息
     * @author 刘富胜
     * @param int $code 编码
     * @param string 消息
     *
     */
    public static function getMsg($code)
    {
        $arr = [
            ResultHelper::SUCCESS_CODE => '成功',
            ResultHelper::ERROR_CODE => '失败',
            ResultHelper::NOT_LOGGED_IN_CODE => '未登录',
            ResultHelper::NO_ACCESS_CODE => '未授权',
            ResultHelper::PARAMETER_ERROR_CODE => '参数错误',
            ResultHelper::WRONG_RESULT_FORMAT_CODE => '错误的结果格式',
            ResultHelper::REMOTE_HTTP_SERVER_RESPONDED_ERROR_CODE => '远程HTTP服务器响应了错误的状态码'
        ];

        if (!in_array($code, $arr)) {
            return '编码code参数错误';
        }

        return $arr[$code];
    }

}