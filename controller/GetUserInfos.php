<?php
/**
 * Created by PhpStorm.
 * User: chenlin15
 * Date: 17/3/14
 * Time: 16:59
 */

require_once 'global.php';
require_once 'controllerBase.php';
require_once '../module/UserModel.php';

class getUserInfos extends controllerBase {
    protected $_fields = array('uid', 'uname');

    /**
     * getUserInfos constructor.
     */
    public function __construct() {
        $this->run();
    }

    public function run() {
        $params = $this->getParams();
        $userModel = new UserModel();
        $userinfos = $userModel->getUserInfos(array('uid' => $params['uid']));
        aj_output(ErrorMsg::SUCCESS, '', $userinfos);
    }
}

new getUserInfos();