<?php

/*
 * What extreme-vision team is that is 'one thing, a team, work together'
 */

namespace App\Http\Helper;

/**
 * 业务ID生成帮助类.
 */
class GenerateHelper
{
    /**
     * 生成36位UUID.
     *
     * @return string 全局唯一的UUID
     */
    public static function uuid()
    {
        list($usec, $sec) = explode(' ', microtime(false));
        $usec             = (string) ($usec * 10000000);
        $timestamp        = bcadd(bcadd(bcmul($sec, '10000000'), (string) $usec), '621355968000000000');
        $ticks            = bcdiv($timestamp, 10000);
        $maxUint          = 4294967295;
        $high             = bcdiv($ticks, $maxUint) + 0;
        $low              = bcmod($ticks, $maxUint) - $high;
        $highBit          = (pack('N*', $high));
        $lowBit           = (pack('N*', $low));
        $guid             = str_pad(dechex(ord($highBit[2])), 2, '0', STR_PAD_LEFT).str_pad(dechex(ord($highBit[3])), 2, '0', STR_PAD_LEFT).str_pad(dechex(ord($lowBit[0])), 2, '0', STR_PAD_LEFT).str_pad(dechex(ord($lowBit[1])), 2, '0', STR_PAD_LEFT).'-'.str_pad(dechex(ord($lowBit[2])), 2, '0', STR_PAD_LEFT).str_pad(dechex(ord($lowBit[3])), 2, '0', STR_PAD_LEFT).'-';
        $chars            = 'abcdef0123456789';
        for ($i = 0; $i < 4; ++$i) {
            $guid .= $chars[mt_rand(0, 15)];
        }
        $guid .= '-';
        for ($i = 0; $i < 4; ++$i) {
            $guid .= $chars[mt_rand(0, 15)];
        }
        $guid .= '-';
        for ($i = 0; $i < 12; ++$i) {
            $guid .= $chars[mt_rand(0, 15)];
        }

        return $guid;
    }

    /**
     * 判断字符串是否为uuid.
     *
     * @param $uuid string 输入的字符串
     *
     * @return bool
     */
    public static function isUuid($uuid)
    {
        $math = preg_match('/^[0-9a-z]{8}-[0-9a-z]{4}-[0-9a-z]{4}-[0-9a-z]{4}-[0-9a-z]{12}$/i', $uuid);
        if (!$math) {
            return false;
        }

        return true;
    }

    /**
     * 生成32位商户系统内部的订单号.
     *
     * @return string 商户订单号
     */
    public static function tradeNo()
    {
        return strtoupper(md5(uniqid(mt_rand(), true)));
    }

    /**
     * 生成16位唯一ID.
     *
     * @return string 商户订单号16位
     */
    public static function tradeNo16()
    {
        return uniqid(mt_rand(100, 999));
    }
}
