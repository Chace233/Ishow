<?php
/**
 * 收藏信息model
 * User: chenlin15
 * Date: 17/3/3
 * Time: 10:21
 */
include "Model.php";

class CollectionsModel extends Model {
    protected  $_tbName = '`tblCollections`';

    /**
     * CollectionsModel constructor.
     */
    public function __construct() {

    }

    public function getCollectionInfos($condition, $page = 1, $pagesize = 25) {
        $sql = 'SELECT `ccid`, `uid`, `obj_id`, `obj_type`, `create_time`
                FROM ' . $this->_tbName . ' ';
        $whereArr = array();
        if (!empty($condition['ccid'])) {
            $whereArr[] = '`ccid` = ' . $condition['ccid'];
        }
        if (!empty($condition['uid'])) {
            $whereArr[] = '`uid` = ' . $condition['uid'];
        }
        if (!empty($condition['obj_id'])) {
            $whereArr[] = '`obj_id` = ' . $condition['obj_id'];
        }
        if (!empty($condition['obj_type'])) {
            $whereArr[] = '`obj_type` = ' . $condition['obj_type'];
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