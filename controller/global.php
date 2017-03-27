<?php
/**
 * 全局变量
 * User: chenlin15
 * Date: 17/3/2
 * Time: 17:35
 */

header("Content-Type: text/html; charset=utf8");

define('URI_HOST', dirname(dirname(__FILE__)));

define('COMPETITION_STATUS_NOMAL', 1); //比赛状态正常
define('COMPETITION_STATUS_DEL', 2); //比赛状态删除

define('ISHOW_COOKIE_NAME', 'MDISHOWSID');

//评论类型
define('COMMENT_TYPE_WORK', 1);//对作品评论
define('COMMENT_TYPE_COMPETITION', 2);//对比赛评论
define('COMMENT_TYPE_COMMENT', 3);//对评论进行评论