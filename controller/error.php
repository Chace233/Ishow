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
    const ERREMAIL          = 20010;//email错误
    const ERRUID            = 20011;//UID错误,查询不到该uid
    const ERRNAMED          = 20012;//uname重复
    const NOWORK            = 20013;//没有改作品
    const NOPASSWD          = 20014;//没有输入密码
    const NOUSER            = 20015;//没有该用户
    const HAVEDTITLE        = 20016;//title重复
    const ERRUPLOAD         = 20017;//文件上传错误
    const TOOBIG            = 20018;//文件太大
    const ERRPIC            = 20019;//图片格式错误
    const TOOLONG           = 20010;//输入的内容太长了


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
        self::ERREMAIL         => 'email错误',
        self::ERRUID           => 'UID错误,查询不到该UID',
        self::ERRNAMED         => '该uname已经被使用',
        self::NOWORK           => '没有该作品',
        self::NOPASSWD         => '缺少密码',
        self::NOUSER           => '没有该用户',
        self::HAVEDTITLE       => '已经存在改title',
        self::ERRUPLOAD        => '文件上传错误',
        self::TOOBIG           => '文件太大了',
        self::ERRPIC           => '图片格式错误',
        self::TOOLONG          => '输入的内容太长了',
    );


    public static function getMsg($errno) {
        return self::$msg[$errno];
    }
}

