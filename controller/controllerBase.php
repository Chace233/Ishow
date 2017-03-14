<?php
/**
 * User: chenlin15
 * Date: 17/2/28
 * Time: 14:27
 */
require_once "comment.php";

class controllerBase {
    protected $_islogin = true;
    protected $_fields  = array();
    protected $_curUser = array();
    /**
     * 初始化
     */
    public function __construct() {

    }

    /**
     * 获取表单数据
     */
    public function getParams() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $params = $_POST['request'];
        } else if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $params = $_GET['request'];
        }
        $safeParams = array();
        if (!empty($params)) {
            foreach ($params as $key => $v) {
                if (!empty($this->_fields) && !in_array($key, $this->_fields)) {
                    continue;
                }
                if (is_array($v)) {
                    foreach ($v as $kk => $vv) {
                        $safeParams[$key][$kk] = htmlEncode($vv);
                    }
                }else {
                    $safeParams[$key] = htmlEncode($v);
                }
            }
        }
        //$this->addPageView($this->_curUser, $safeParams);  添加用户访问的记录
        return $safeParams;
    }

}