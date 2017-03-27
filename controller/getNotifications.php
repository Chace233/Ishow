<?php
/**
 * 获取推送消息
 * User: chenlin15
 * Date: 17/3/26
 * Time: 12:08
 */
require_once 'controllerBase.php';
require_once '../module/NotificationModel.php';

class GetNotification extends controllerBase {
    protected $_fields = array('type', 'status', 'page', 'pagesize');

    public function __construct() {
        $this->run();
    }

    public function run() {
        $params = $this->getParams();
        $uid = $this->_curUser['uid'];
        $condition = array(
            'uid' => $uid,
        );
        if (isset($params['type'])) {
            $condition['type'] = $params['type'];
        }
        if (isset($params['status'])) {
            $condition['status'] = $params['status'];
        }
        $page = empty($params['page']) ? 1 : $params['page'];
        $pagesize = empty($params['pagesize']) ? 25 : $params['pagesize'];
        $notificationModel = new NotificationModel();
        $res = $notificationModel->getNotificationsList($condition, $page, $pagesize);
        aj_output(ErrorMsg::SUCCESS, '', $res);
    }
}

new GetNotification();