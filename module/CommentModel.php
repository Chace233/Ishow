<?php
/**
 * 评论信息Model
 * User: chenlin15
 * Date: 17/3/3
 * Time: 10:22
 */
require_once "Model.php";

class CommentModel extends Model {
    protected $_tbName = '`tblcomment`';
    protected $_tbUser = '`tblUser`';

    /**
     * CommentModel constructor.
     */
    public function __construct() {

    }

    public function getCommentList($condition, $page=1, $pagesize=25) {
        $sql = "SELECT c.`cid`, c.`obj_id`, c.`type`, c.`content`, c.`uid`, c.`create_time`, u.`uname`, u.`feature`, u.`headpic`, u.`tel`, u.`email`, u.`intro`
                FROM " . $this->_tbName . " AS `c` LEFT JOIN " . $this->_tbUser . " AS `u` ON c.`uid` = u.`uid`";
        $whereArr = array();
        if (!empty($condition['cid'])) {
            if (is_array($condition['cid'])) {
                $whereArr[] = "`cid` IN (" . implode(',' , $condition['cid']) . ")";
            } else {
                $whereArr[] = "`cid` = " . $condition['cid'];
            }
        }
        if (!empty($condition['obj_id'])) {
            $whereArr[] = "`obj_id` = " . $condition['obj_id'];
        }
        if (!empty($condition['type'])) {
            $whereArr[] = "`type` = " . $condition['type'];
        }
        if (!empty($condition['uid'])) {
            $whereArr[] = "c.`uid` = " . $condition['uid'];
        }
        if (!empty($condition['status'])) {
            $whereArr[] = "`status` = " . $condition['status'];
        }
        if (!empty($whereArr)) {
            $sql .= " WHERE " . implode(' AND ', $whereArr);
        }
        $sql .= " ORDER BY `create_time` DESC LIMIT " . ($page - 1) * $pagesize . ", " . $pagesize;
        $res = $this->Query($sql);
        return $res;
    }
}