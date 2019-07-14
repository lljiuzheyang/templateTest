<?php

namespace App\Http\Helper;

/**
 * 数组相关工具类
 *
 * @author 刘富胜
 * @version v1.0.0
 * @create_time 19-7-11 下午11:56
 *
 */
class ArrayHelper {

    /**
     * 获取数组的值
     * @author 刘富胜
     * @version v1.0.0
     * @create_time 19-7-11 下午11:56
     * @param array $array 要判断的数组
     * @param string|array $keys 键名或者键名数组，如果是数字将会递归获取子属性
     * @return mixed 数组的值
     */
    public static function getValue($array, $keys) {
        if (!is_array($keys)) {
            $keys = [$keys];
        }

        $tempValue = $array;
        foreach ($keys as $key) {
            if (is_array($tempValue) && array_key_exists($key, $tempValue)) {
                $tempValue = $tempValue[$key];
            } else {
                return null;
            }
        }

        return $tempValue;
    }

    /**
     * 过滤空的数组
     * @author 刘富胜
     * @version v1.0.0
     * @create_time 19-7-11 下午11:56
     * @param array $array 待过滤的数组
     * @return array 过滤后的数组
     */
    public static function filterEmpty($array) {
        return array_filter($array, function($var) {
            return !empty($var);
        });
    }

    /**
     * 合并数组，返回一个新的数组，相对官方的array_merge加入了非数组过滤、为空判断，防止碰到不合法参数返回空
     * @author 刘富胜
     * @version v1.0.0
     * @create_time 19-7-11 下午11:56
     * @param array $arrays 要合并的数组
     * @return array 合并后的数组
     */
    public static function merge(...$arrays) {
        $filteredArrays = array_filter($arrays, function($var) {
            return is_array($var) && !empty($var);
        });

        $filterCount = count($filteredArrays);

        if ($filterCount > 1) {
            return array_merge(...$filteredArrays);
        } else if ($filterCount === 1) {
            return array_shift($filteredArrays);
        } else {
            return [];
        }
    }

    /**
     * 将二维数组以某个字段值进行分组
     * @author 刘富胜
     * @version v1.0.0
     * @create_time 19-7-11 下午11:56
     * @param array $array 输入的二维数组
     * @param string $key 分组依据的字段名
     */
    public static function group(array $array, $key) {
        $result = [];

        foreach ($array as $innerArray) {
            $currentKey = $innerArray[$key];

            if (array_key_exists($currentKey, $result)) {
                array_push($result[$currentKey], $innerArray);
            } else {
                $result[$currentKey] = [$innerArray];
            }
        }

        return $result;
    }

    /**
     * 将数组中的所有字符串元素的值拼接起来，并以字符串形式返回(有子数组将会递归)
     * @author 刘富胜
     * @version v1.0.0
     * @create_time 19-7-11 下午11:56
     * @return string
     */
    public static function implode($arr, $spliter = ' ') {
        if (empty($arr) || !is_array($arr)) {
            return '';
        }

        $result = [];

        static::implodeInternal($result, $arr);

        return implode($spliter, $result);
    }

    private static function implodeInternal(&$result, $arr) {
        foreach ($arr as $item) {
            if (is_array($item)) {
                static::implodeInternal($result, $item);
            } else if (is_string($item)) {
                array_push($result, $item);
            }
        }
    }

}
