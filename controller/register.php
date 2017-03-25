<?php
/**
 * 用户注册
 * User: chenlin15
 * Date: 17/3/17
 * Time: 11:33
 */

require_once 'controllerBase.php';
require_once '../module/UserModel.php';

class register extends controllerBase {
    protected $_fields = array('uname', 'tel', 'email', 'intro', 'feature', 'headpic', 'passwd');
    protected $_islogin = false;

    public function __construct() {
        $this->run();
    }

    public function run() {
        $params = $this->getParams();
        if (empty($params['uname'])) {
            aj_output(ErrorMsg::NOUNAME);
        }
        if (empty($params['passwd'])) {
            aj_output(ErrorMsg::NOPASSWD);
        }
        $userModel = new UserModel();
        $res = $userModel->getUserInfos(array('uname' => $params['uname']));
        if (!empty($res)) {
            aj_output(ErrorMsg::ERRNAMED);
        }
        if (!empty($params['tel']) && 0 === preg_match('/^1[34578]{1}\d{9}$/', $params['tel'])) {
            aj_output(ErrorMsg::ERRTEL);
        }
        if (!empty($params['email']) && 0 === preg_match('/^[a-zA-Z0-9_-]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$/', $params['email'])) {
            aj_output(ErrorMsg::ERREMAIL);
        }
        $addArr = array(
            'uid'         => time() + 1,
            'uname'       => $params['uname'],
            'tel'         => empty($params['tel']) ? '' : $params['tel'],
            'email'       => empty($params['email']) ? '' : $params['email'],
            'intro'       => empty($params['intro']) ? '' : $params['intro'],
            'feature'     => empty($params['feature']) ? 1 : $params['feature'],
            'headpic'     => empty($params['headpic']) ? '' : $params['headpic'],
            'create_time' => time(),
            'passwd'      => md5($params['passwd']),
        );
        $res = $userModel->insert($addArr);
        if (false === $res) {
            aj_output(ErrorMsg::ERROR_SUBMIT);
        }
        aj_output(ErrorMsg::SUCCESS);
    }
}

new register();