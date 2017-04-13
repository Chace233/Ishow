<?php
/**
 * 点赞model
 * User: chenlin15
 * Date: 17/3/3
 * Time: 10:24
 */
require_once "Model.php";

class VoteModel extends Model {
    protected  $_tbName = '`tblVote`';

    /**
     * CollectionsModel constructor.
     */
    public function __construct() {

    }

    public function getVoteInfos($condition, $page = 1, $pagesize = 25) {
        $sql = 'SELECT `vid`, `uid`, `uid2`, `obj_id`, `type`, `create_time`
                FROM ' . $this->_tbName . ' ';
        $whereArr = array();
        if (!empty($condition['vid'])) {
            $whereArr[] = '`vid` = ' . $condition['vid'];
        }
        if (!empty($condition['uid'])) {
            $whereArr[] = '`uid` = ' . $condition['uid'];
        }
        if (!empty($condition['uid2'])) {
            $whereArr[] = '`uid2` = ' . $condition['uid2'];
        }
        if (!empty($condition['obj_id'])) {
            $whereArr[] = '`obj_id` = ' . $condition['obj_id'];
        }
        if (!empty($condition['type'])) {
            $whereArr[] = '`type` = ' . $condition['type'];
        }
        if (!empty($condition['start_time'])) {
            $whereArr[] = '`create_time` >= ' . $condition['start_time'];
        }
        if (!empty($condition['end_time'])) {
            $whereArr[] = '`create_time` <= ' . $condition['end_time'];
        }
        if (!empty($whereArr)) {
            $sql .= ' WHERE ' . implode(' AND ', $whereArr);
        }
        $sql .= ' ORDER BY `create_time` DESC LIMIT ' . ($page-1) * $pagesize . ', ' . $pagesize;
        $res = $this->Query($sql);
        return $res;
    }
}