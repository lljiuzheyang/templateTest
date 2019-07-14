<?php

/*
 * What extreme-vision team is that is 'one thing, a team, work together'
 */

namespace App\Http\Helper;

use App\Http\Enums\CodeEnum;
use Illuminate\Support\Facades\Log;
use ReflectionClass;

class ResultHelper
{
    /**
     * 结果状态码字段名.
     */
    const CODE_FIELD = 'status_code';

    /**
     * 结果信息字段名.
     */
    const MSG_FIELD = 'message';

    /**
     * 结果数据字段名.
     */
    const DATA_FIELD = 'data';

    /**
     * 兼容文件上传字段
     * 上传状态
     */
    const STATE = 'state';

    /**
     * 兼容文件上传字段
     * 上传URL.
     */
    const URL = 'url';

    /**
     * 兼容文件上传字段
     * 上传title.
     */
    const TITLE = 'title';

    /**
     * 兼容文件上传字段
     * 上传源.
     */
    const ORIGINAL = 'original';

    //成功
    const SUCCESS_CODE = 0;
    //失败
    const ERROR_CODE = 1;
    //未登录
    const NOT_LOGGED_IN_CODE = 2;
    //未授权
    const NO_ACCESS_CODE = 3;
    //参数错误
    const PARAMETER_ERROR_CODE = 4;
    //错误的结果格式
    const WRONG_RESULT_FORMAT_CODE = 5;
    //远程HTTP服务器响应了错误的状态码
    const REMOTE_HTTP_SERVER_RESPONDED_ERROR_CODE = 20005;

    /**
     * 静态是否已经初始化了.
     *
     * @var array
     */
    protected static $initialized_class = [];

    /**
     * 标准返回状态库，不同业务状态码首位数字应有所区别.
     *
     * @var array 标准状态库数组
     */
    protected static $result_dict = [];

    /**
     * 生成平台标准格式结果.
     *
     * @author 刘富胜
     * @create_time 2019-07-11
     *
     * @param int    $code    结果状态码，如果状态码在标准库里面存在，则会在errmsg中显示标准结果信息
     * @param string $msg     结果描述，如果标准库里存在标准结果信息，则会追加在标准结果信息之后，以逗号分隔
     * @param mixed  $data    业务结果数据
     * @param bool   $raw_msg 是否按照$msg原样输出结果描述，如果为false将会在标准库寻找对应的code并拼接至结果描述中
     *
     * @return array 生成的结果数组
     */
    public static function generate(int $code, string $msg = null, $data = null, $raw_msg = false)
    {
        static::init();

        return [
            static::CODE_FIELD => $code,
            static::MSG_FIELD  => static::getErrmsg($code, $msg, $raw_msg),
            static::DATA_FIELD => $data,
        ];
    }

    /**
     * 生成平台兼容图片格式结果.
     *
     * @author 刘富胜
     * @create_time 2019-07-11
     *
     * @param int    $code     结果状态码，如果状态码在标准库里面存在，则会在errmsg中显示标准结果信息
     * @param string $msg      结果描述，如果标准库里存在标准结果信息，则会追加在标准结果信息之后，以逗号分隔
     * @param string $url      图片链接
     * @param string $title    图片标题
     * @param string $original 图片源名
     * @param bool   $raw_msg  是否按照$msg原样输出结果描述，如果为false将会在标准库寻找对应的code并拼接至结果描述中
     *
     * @return array 生成的结果数组
     */
    public static function generateUpload(int $code, string $msg = null, string $url = null, string $title = '',
                                          string $original = '', $raw_msg = false)
    {
        static::init();

        return [
            static::STATE    => $raw_msg ? $msg : static::getErrmsg($code, $msg),
            static::URL      => $url,
            static::TITLE    => $title,
            static::ORIGINAL => $original,
        ];
    }

    /**
     * 根据异常生成标准格式结果.
     *
     * @author 刘富胜
     * @create_time 2019-07-11
     *
     * @param \Throwable $ex 异常信息
     *
     * @return array 生成的结果数组
     */
    public static function generateFromException(\Throwable $ex)
    {
        $errcode = $ex->getCode();

        return static::generate(0 === $errcode ? static::ERROR_CODE : $errcode, $ex->getMessage(),
            null, true);
    }

    /**
     * 根据状态码获取结果信息.
     *
     * @author 刘富胜
     * @create_time 2019-07-11
     *
     * @param int    $code        状态码
     * @param string $msg         结果信息，如果标准库存在，则会合并标准消息和$msg
     * @param bool   $raw_message 是否按照$msg原样输出结果描述，如果为false将会在标准库寻找对应的code并拼接至结果描述中
     *
     * @return string 结果信息
     */
    private static function getErrMsg(int $code, string $msg = null, $raw_message = false)
    {
        if ($raw_message && !empty($msg)) {
            return $msg;
        }

        return implode(',', array_filter([static::$result_dict[$code], $msg], function ($var) {
            return !empty($var);
        }));
    }

    /**
     * 初始化标准库，将当前类和继承类的常量放入数组中.
     *
     * @author 刘富胜
     * @create_time 2019-07-11
     */
    protected static function init()
    {
        $current_class = get_called_class();

        if (array_key_exists($current_class, static::$initialized_class)) {
            return;
        }

        $reflection = new ReflectionClass($current_class);

        $current_dict = array_flip($reflection->getConstants());

        static::$result_dict = static::$result_dict + $current_dict;

        static::$initialized_class[$current_class] = true;
    }

    /**
     * 抛出标准异常.
     *
     * @author 刘富胜
     * @create_time 2019-07-11
     *
     * @param int    $code        状态码
     * @param string $msg         异常信息，如果标准库存在，则会合并标准消息和$msg
     * @param bool   $raw_message 是否按照$msg原样输出结果描述，如果为false将会在标准库寻找对应的code并拼接至结果描述中
     *
     * @throws \Exception 标准异常
     */
    public static function throwException(int $code, string $msg = null, $raw_message = false)
    {
        static::init();

        $errmsg    = static::getErrMsg($code, $msg, $raw_message);
        $exception = new \Exception($errmsg, $code);

        Log::info($exception->getMessage());
        Log::info($exception->getCode());
        Log::info($exception->getTraceAsString());

        throw $exception;
    }

    /**
     * 获取未截断的TraceAsString.
     *
     * @author 刘富胜
     * @create_time 2019-07-11
     *
     * @param $exception \Exception
     *
     * @return string
     */
    public static function getExceptionTraceAsString($exception)
    {
        $rtn   = '';
        $count = 0;
        foreach ($exception->getTrace() as $frame) {
            $args = '';
            if (isset($frame['args'])) {
                $args = [];
                foreach ($frame['args'] as $arg) {
                    if (is_string($arg)) {
                        $args[] = "'".$arg."'";
                    } elseif (is_array($arg)) {
                        $args[] = 'Array';
                    } elseif (is_null($arg)) {
                        $args[] = 'NULL';
                    } elseif (is_bool($arg)) {
                        $args[] = ($arg) ? 'true' : 'false';
                    } elseif (is_object($arg)) {
                        $args[] = get_class($arg);
                    } elseif (is_resource($arg)) {
                        $args[] = get_resource_type($arg);
                    } else {
                        $args[] = $arg;
                    }
                }
                $args = join(', ', $args);
            }
            $rtn .= sprintf("#%s %s(%s): %s(%s)\n",
                $count,
                array_key_exists('file', $frame) ? $frame['file'] : '',
                array_key_exists('line', $frame) ? $frame['line'] : '',
                array_key_exists('function', $frame) ? $frame['function'] : '',
                $args);
            ++$count;
        }

        return $rtn;
    }

    /**
     * 根据标准结果判断是否抛出异常，如果结果不为成功则抛出异常，否则什么也不做.
     *
     * @author 刘富胜
     * @create_time 2019-07-11
     *
     * @param array $result 获取到的标准结果数组,例如['errcode' => 0 , 'errmsg' => 'xxx']
     *
     * @throws \Exception 如果结果不为成功，则抛出异常
     */
    public static function throwExceptionOnResultError(array $result)
    {
        if (!static::isValidResult($result)) {
            static::throwException(static::WRONG_RESULT_FORMAT_CODE);
        } elseif ($result[static::CODE_FIELD] !== static::SUCCESS_CODE) {
            static::throwException($result[static::CODE_FIELD], $result[static::MSG_FIELD], true);
        }
    }

    /**
     * 校验是否为标准的结果格式.
     *
     * @author 刘富胜
     * @create_time 2019-07-11
     *
     * @param array $result_data 待校验的结果数据
     *
     * @return bool 是否为标准结果格式
     */
    public static function isValidResult($result_data)
    {
        return is_array($result_data) && array_key_exists(static::CODE_FIELD, $result_data);
    }

    /**
     * 判断结果的状态是否等于预期
     *
     * @author 刘富胜
     * @create_time 2019-07-11
     *
     * @param array $result_data 结果数据
     * @param int   $errcode     预期结果状态码
     *
     * @return bool 判断结果
     */
    public static function isErrcodeEqualTo($result_data, $errcode)
    {
        return static::isValidResult($result_data) && $result_data[static::CODE_FIELD] === $errcode;
    }

    /**
     * 判断结果是否成功
     *
     * @author 刘富胜
     * @create_time 2019-07-11
     *
     * @param array $result_data 结果数据
     *
     * @return bool 是否成功
     */
    public static function isSucceed($result_data)
    {
        return static::isErrcodeEqualTo($result_data, static::SUCCESS_CODE);
    }

    /**
     * 返回json格式.
     *
     * @author 刘富胜
     * @create_time 2019-07-11
     *
     * @param $code
     * @param null $data
     *
     * @return array
     */
    public static function getInfo($code, $data = null)
    {
        if (0 == $code) {
            return [static::CODE_FIELD => $code, static::MSG_FIELD => CodeEnum::getMsg($code), static::DATA_FIELD => $data];
        }

        return [static::CODE_FIELD => $code, static::MSG_FIELD => CodeEnum::getMsg($code)];
    }
}
