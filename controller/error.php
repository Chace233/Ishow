<?php
/**
 * Created by PhpStorm.
 * User: chenlin15
 * Date: 17/3/14
 * Time: 18:04
 */
class ErrorMsg{
    const SUCCESS           = 0;
    const NOUID             = 20001;//缺少uid
    const NOUNAME           = 20002;//缺少uname


    static $msg = array(
        self::SUCCESS          => '成功',
        self::NOUID            => '缺少uid参数',
        self::NOUNAME          => '缺少uname参数',
        self::ERRTEL           => '电话号码错误',
    );


    public static function getMsg($errno) {
        return self::$msg[$errno];
    }
}

