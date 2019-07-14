<?php

/*
 * What extreme-vision team is that is 'one thing, a team, work together'
 */

namespace App\Http\Helper;

/**
 * 请求帮助类.
 *
 * @author 刘富胜
 *
 * @version v1.0.0
 * @create_time 19-7-11 下午11:56
 */
class RequestHelper
{
    /**
     * GET请求
     *
     * @param string $url     URL
     * @param array  $fields  URL参数
     * @param array  $options curl参数
     *
     * @return array 远程服务器返回结果
     */
    public static function get($url, array $fields = [], $options = [])
    {
        if (!empty($fields)) {
            $url = $url.'?'.http_build_query($fields);
        }

        return static::http($url, $options);
    }

    /**
     * DELETE 请求
     *
     * @param string $url     HTTP URL
     * @param array  $fields  查询参数
     * @param array  $options CURL参数
     *
     * @return array 远程服务器返回结果
     */
    public static function delete($url, array $fields = [], $options = [])
    {
        if (!empty($fields)) {
            $url = $url.'?'.http_build_query($fields);
        }

        return static::http($url, [
                CURLOPT_CUSTOMREQUEST => 'DELETE',
            ] + $options);
    }

    /**
     * POST请求 上传JSON数据 数组会自动转成JSON.
     *
     * @param string $url        URL
     * @param string $postFields JSON数据，数组会自动转成JSON
     * @param array  $fields     URL参数
     * @param array  $options    curl参数
     *
     * @return array 远程服务器返回结果
     */
    public static function postJson($url, $post_fields, array $fields = [], $options = [])
    {
        if (!empty($fields)) {
            $url = $url.'?'.http_build_query($fields);
        }
        if (is_array($post_fields)) {
            $post_fields = json_encode($post_fields, JSON_UNESCAPED_UNICODE);
        }

        $headers = ['Content-Type: application/json'];
        if (array_key_exists(CURLOPT_HTTPHEADER, $options)) {
            $input_headers = $options[CURLOPT_HTTPHEADER];

            if (!is_array($input_headers)) {
                $input_headers = [$input_headers];
            }

            $headers = ArrayHelper::merge($headers, $input_headers);
        }

        return static::http($url, [
                CURLOPT_POST       => true,
                CURLOPT_POSTFIELDS => $post_fields,
                CURLOPT_HTTPHEADER => $headers,
            ] + $options
        );
    }

    /**
     * 发送http请求并尝试将结果解析成JSON各式.
     *
     * @param $url
     * @param array $options cURL选项设置
     *
     * @return mixed HTTP返回结果
     */
    protected static function http($url, array $options = [])
    {
        $options = [
                CURLOPT_URL            => $url,
                CURLOPT_TIMEOUT        => 30,
                CURLOPT_CONNECTTIMEOUT => 30,
                CURLOPT_RETURNTRANSFER => true,
            ] + (false !== stripos($url, 'https://') ? [
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_SSLVERSION     => 1, // 微信官方屏蔽了ssl2和ssl3, 启用更高级的ssl
            ] : []) + $options;
        $curl = curl_init();
        curl_setopt_array($curl, $options);
        $contents = curl_exec($curl);
        $curlInfo = curl_getinfo($curl);
        curl_close($curl);

        if (isset($curlInfo['http_code']) && 200 == $curlInfo['http_code']) {
            $data = json_decode($contents, true);
            // 请求成功，但解码失败。
            if (!$data) {
                return $contents;
            }

            return $data;
        }
        ResultHelper::throwException(ResultHelper::REMOTE_HTTP_SERVER_RESPONDED_ERROR_CODE,
                "{$curlInfo['http_code']}|||{$contents}");
    }
}
