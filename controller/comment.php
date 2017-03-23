<?php

/**
 * 公共方法
 */


require_once 'error.php';

/**
 * 过滤
 * @param string $content 过滤内容
 * @return string 编码后的字符串
 */
function htmlEncode($content) {
    $order   = array("\r\n", "\n", "\r", "'");
    $replace = array("<br />", "<br />", "<br />", '&#39;');
    $content = str_replace($order, $replace, $content);
    $replace = array("");
    $order   = array("'<script.*?>.*?</script>'siU");
    $content = preg_replace($order, $replace, $content);
    return $content;
}

/**
 * 获取客户端请求IP地址
 * @return string
 */
function getIp() {
    $realip = '';
    if (isset($_SERVER)) {
        if (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $realip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            foreach ($arr as $ip) {
                $ip = trim($ip);
                if (strtolower($ip) != 'unknown') {
                    $realip = $ip;
                    break;
                }
            }
        } elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $realip = $_SERVER['REMOTE_ADDR'];
        } else {
            $realip = '0.0.0.0';
        }
    } else {
        if (getenv('HTTP_CLIENT_IP')) {
            $realip = getenv('HTTP_CLIENT_IP');
        } elseif (getenv('HTTP_FORWARDED_FOR')) {
            $realip = getenv('HTTP_FORWARDED_IP');
        } elseif (getenv('REMOTE_ADDR')) {
            $realip = getenv('REMOTE_ADDR');
        } else {
            $realip = '0.0.0.0';
        }
    }
    return $realip;
}

/**
 * 获取头像地址
 */
function getAvatarUrl() {


}


function aj_output ($errno, $errmsg = '', $result = '', $callback = '') {
    if (empty($errno)) {
        $errmsg = ErrorMsg::getMsy($errmsg);
    }
    $output = array('errno' => $errno, 'errmsg' => $errmsg, 'result' => $result);
    if (preg_match('/[A-Za-z].*/', $callback)) {
        echo ' ' . $callback . '(' . json_encode($output, JSON_UNESCAPED_UNICODE) . ')';
    } else {
        echo json_encode($output, JSON_UNESCAPED_UNICODE);
    }
    exit(0);
}

