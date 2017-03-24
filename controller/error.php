<?php
/**
 * Created by PhpStorm.
 * User: chenlin15
 * Date: 17/3/14
 * Time: 18:04
 */
class ErrorMsg{
    const SUCCESS           = 0;
    const ERROR_SUBMIT      = 20001;//提交失败
    const NOUID             = 20002;//缺少uid
    const NOUNAME           = 20003;//缺少uname
    const ERRTEL            = 20004;//电话号码错误
    const NOOBJ             = 20005;//没有传obj参数
    const NOTYPE            = 20006;//没有传type参数
    const COLLECTED         = 20007;//已经收藏过了
    const NOCCID            = 20008;//缺少ccid参数
    const ERROR_ARGUMENT    = 20009;//参数错误


    static $msg = array(
        self::SUCCESS          => '成功',
        self::ERROR_SUBMIT     => '提交失败',
        self::NOUID            => '缺少uid参数',
        self::NOUNAME          => '缺少uname参数',
        self::ERRTEL           => '电话号码错误',
        self::NOOBJ            => '缺少obj参数',
        self::NOTYPE           => '缺少type参数',
        self::COLLECTED        => '已经收藏过了',
        self::NOCCID           => '缺少ccid参数',
        self::ERROR_ARGUMENT   => '参数错误',
    );


    public static function getMsg($errno) {
        return self::$msg[$errno];
    }
}

