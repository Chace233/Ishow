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

    public function __construct() {
        $this->run();
    }

    public function run() {
        $params = $this->getParams();
        $where['uid'] = $params['uid'];
        $edit['tel'] = $params['tel'];
        $userModel = new UserModel();
        $res = $userModel->update($edit, $where);
        if (false === $res) {
            aj_output(ErrorMsg::ERROR_SUBMIT);
        }
        aj_output(ErrorMsg::SUCCESS);
    }
}

new updateUserInfo();