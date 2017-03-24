<?php
/**
 * User: chenlin15
 * Date: 17/2/28
 * Time: 14:27
 */
require_once "comment.php";
require_once "error.php";
require_once "score.conf.php";
require_once "global.php";
require_once "../module/UserModel.php";

class controllerBase {
    protected $_islogin = true;
    protected $_fields  = array(); //请求参数过滤
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
        $this->getCurUser();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $params = $_POST;
        } else if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $params = $_GET;
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

    /**
     * 获取当前用户信息
     * @return bool
     */
    public function getCurUser() {
        if ($this->_islogin) {
            $uid = $_COOKIE[ISHOW_COOKIE_NAME];
            $userModel = new UserModel();
            $userInfo = $userModel->getUserInfos(array('uid' => $uid));
            $this->_curUser = current($userInfo);
            if (empty($this->_curUser)) {
                aj_output(ErrorMsg::NOUSER);
            }
        }
        return true;
    }

}