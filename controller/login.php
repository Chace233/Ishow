<?php
/**
 * 登录
 * User: chenlin15
 * Date: 17/3/24
 * Time: 16:29
 */

require_once "controllerBase.php";
require_once "../module/UserModel.php";

class Login extends controllerBase {
    protected $_fields  = array('uname', 'passwd');
    protected $_islogin = false;

    public function __construct() {
        $this->run();
    }

    public function run() {
        $params = $this->getParams();
        if (empty($params['uname']) || empty($params['passwd'])) {
            aj_output(ErrorMsg::ERROR_ARGUMENT);
        }
        $userModel = new UserModel();
        $res = $userModel->getUserInfos(array('uname' => $params['uname'], 'passwd' => md5($params['passwd'])));
        if (empty($res)) {
            aj_output(ErrorMsg::NOUSER);
        }
        $this->_curUser = current($res);
        $this->_islogin = true;
        setcookie(ISHOW_COOKIE_NAME, $this->_curUser['uid'], time() + 3600 * 24 * 7);
        aj_output(ErrorMsg::SUCCESS, '登录成功', '');
    }
}

new Login();