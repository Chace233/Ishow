<?php
/**
 * 获取用户列表
 * User: chenlin15
 * Date: 17/3/29
 * Time: 11:42
 */
require_once 'controllerBase.php';
require_once '../module/UserModel.php';

class GetUserList extends controllerBase {
    protected $_fields = array('page', 'pagesize');

    public function __construct() {
        $this->run();
    }

    public function run () {
        $params = $this->getParams();
        $page = empty($params['page']) ? 1 : $params['page'];
        $pagesize = empty($params['pagesize']) ? 25 : $params['pagesize'];
        $condition = array();
        $userModel = new UserModel();
        $res = $userModel->getUserInfos($condition, $page, $pagesize);
        $total = $userModel->getUserTotal($condition);
        aj_output(ErrorMsg::SUCCESS, '', array('total' => $total, 'page' => $page, 'pagesize' => $pagesize, 'list' => $res));
    }
}