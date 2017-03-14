<?php
/**
 * Created by PhpStorm.
 * User: chenlin15
 * Date: 17/3/14
 * Time: 18:04
 */
class ErrorMsy{
    const SUCCESS           = 0;
    const NOUID             = 20001;//缺少uid
    const NOUNAME           = 20002;//缺少uname


    static $msy = array(
        self::SUCCESS          => '成功',
        self::NOUID            => '缺少uid参数',
        self::NOUNAME          => '缺少uname参数',
    );
}

