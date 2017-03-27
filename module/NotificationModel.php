<?php
/**
 * 消息model
 * User: chenlin15
 * Date: 17/3/25
 * Time: 12:51
 */
require_once 'Model.php';

class NotificationModel extends Model {
    protected $_tbName = '`tblNotification`';
    protected $_tbUser = '`tblUser`';

    public function __construct() {

    }

    public function getNotificationsList($condition, $page = 1, $pagesize = 25) {
        $sql = "SELECT n.`id`, n.`status`, n.`type`, n.`obj_id`, u.`uname`, n.`create_time`
                FROM " . $this->_tbName . " AS `n` LEFT JOIN " . $this->_tbUser . " AS `u` ON n.`from_uid` = u.`uid`";
        $whereArr = array();
        if (!empty($condition['uid'])) {
            $whereArr[] = 'n.`uid` = ' . $condition['uid'];
        }
        if (!empty($condition['type'])) {
            $whereArr[] = 'n.`type` = ' . $condition['type'];
        }
        if (!empty($condition['status'])) {
            $whereArr[] = 'n.`status` = '. $condition['status'];
        }
        if (!empty($whereArr)) {
            $sql .= ' WHERE ' . implode(' AND ', $whereArr);
        }
        $sql .= ' ORDER BY `create_time` DESC LIMIT ' . ($page-1)*$pagesize . ', ' . $pagesize;
        $res = $this->Query($sql);
        return $res;
    }
}