<?php
/**
 * Created by PhpStorm.
 * User: chenlin15
 * Date: 17/3/14
 * Time: 19:39
 */

require_once 'controllerBase.php';
require_once '../module/UserModel.php';

class updateUserInfo extends controllerBase {
    protected $_fields = array('uname', 'tel', 'email', 'intro', 'feature', 'headpic', 'passwd');

    public function __construct() {
        $this->run();
    }

    public function run() {
        $params = $this->getParams();
        $params['uid'] = $this->_curUser['uid'];
        $where['uid'] = $params['uid'];
        $edit = array();
        $userModel = new UserModel();
        $res = $userModel->getUserInfos($where['uid']);
        if (empty($res)) {
            aj_output(ErrorMsg::ERRUID);
        }
        if (!empty($params['tel']) && preg_match('/^1[34578]{1}\d{9}$/', $params['tel']) === 0) {
            aj_output(ErrorMsg::ERRTEL);
        }
        if (!empty($params['email']) && 0 === preg_match('/^[a-zA-Z0-9_-]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$/', $params['email'])) {
            aj_output(ErrorMsg::ERREMAIL);
        }
        if (!empty($params['uname']) && $params['uname'] != $res[0]['uname']) {
            $resname = $userModel->getUserInfos(array('uname' => $params['uname']));
            if (!empty($resname)) {
                aj_output(ErrorMsg::ERRNAMED);
            }
        }
        if (!empty($params['uname'])) {
            $edit['uname'] = $params['uname'];
        }
        if (!empty($params['email'])) {
            $edit['email'] = $params['email'];
        }
        if (!empty($params['tel'])) {
            $edit['tel'] = $params['tel'];
        }
        if (!empty($params['intro'])) {
            $edit['intro'] = $params['intro'];
        }
        if (!empty($params['feature'])) {
            $edit['feature'] = $params['feature'];
        }
        if (!empty($params['headpic'])) {
            $edit['headpic'] = $params['headpic'];
        }
        if (!empty($params['passwd'])) {
            $edit['passwd'] = md5($params['passwd']);
        }
        $res = $userModel->update($edit, $where);
        if (false === $res) {
            aj_output(ErrorMsg::ERROR_SUBMIT);
        }
        aj_output(ErrorMsg::SUCCESS);
    }
}

new updateUserInfo();