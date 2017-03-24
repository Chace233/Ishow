<?php
/**
 * 用户Model
 * User: chenlin15
 * Date: 17/3/3
 * Time: 10:24
 */

require_once 'Model.php';

class UserModel extends Model {
    protected $_tbName = '`tblUser`';

    /**
     * UserModel constructor.
     */
    public function __construct() {

    }

    public function getUserInfos($condition, $page = 1, $pagesize = 20) {
        $sql = "SELECT `uid`, `uname`, `tel`, `email`, `intro`, `feature`, `create_time`, `islogin`, `headpic`
                FROM " . $this->_tbName;
        $whereArr = array();
        if (!empty($condition['uid'])) {
            if (is_array($condition['uid'])) {
                $whereArr[] = "`uid` IN (" . implode(', ', $condition['uid']) . ")";
            } else {
                $whereArr[] = "`uid` = " . $condition['uid'];
            }
        }
        if (!empty($condition['uname'])) {
            $whereArr[] = "`uname` = '" . $condition['uname'] . "'";
        }
        if (!empty($condition['feature'])) {
            $whereArr[] = "`feature` = " . $condition['feature'];
        }
        if (!empty($condition['islogin'])) {
            $whereArr[] = "`islogin` = " . $condition['islogin'];
        }
        if (!empty($whereArr)) {
            $sql .= " WHERE " . implode(' AND ', $whereArr);
        }
        $sql .= " ORDER BY `create_time` DESC LIMIT " . ($page-1) * $pagesize . ", " . $pagesize;
        $res = $this->Query($sql);
        return $res;
    }

    public function addUser($addArr) {
        if (empty($addArr)) {
            return false;
        }
        $res = $this->insert($addArr);
        return $res;
    }

}