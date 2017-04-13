<?php
/**
 * 比赛信息Model
 * User: chenlin15
 * Date: 17/3/3
 * Time: 10:25
 */

require_once 'Model.php';

class CompetitionsModel extends Model{

    protected $_tbName = '`tblCompetitions`';

    public function getCompetitionInfos($condition, $page=1, $pagesize=25) {
        $sql = 'SELECT `cpid`, `title`, `content`, `create_time`, `status`, `download`, `start_time`, `end_time`, `type`
                FROM ' . $this->_tbName;
        $whereArr = array();
        if (!empty($condition['cpid'])) {
            if (is_array($condition['cpid'])) {
                $whereArr['cpid'] = '`cpid` IN (' . implode(', ', $condition['cpid']);
            } else {
                $whereArr['cpid'] = '`cpid` = ' . $condition['cpid'];
            }
        }
        if (!empty($condition['type'])) {
            $whereArr['type'] = '`type` = ' . $condition['type'];
        }
        if (!empty($whereArr)) {
            $sql .= ' WHERE ' . implode(' AND ', $whereArr) . ') ';
        }
        $sql .= ' ORDER BY `start_time` DESC LIMIT ' . ($page - 1) * $pagesize . ', ' . $pagesize;
        $res = $this->Query($sql);
        return $res;
    }

    public function getTotal($condition) {
        $sql = 'SELECT COUNT(`cpid`) AS  `total`
                FROM ' . $this->_tbName;
        $whereArr = array();
        if (!empty($condition['cpid'])) {
            if (is_array($condition['cpid'])) {
                $whereArr['cpid'] = '`cpid` IN (' . implode(', ', $condition['cpid']);
            } else {
                $whereArr['cpid'] = '`cpid` = ' . $condition['cpid'];
            }
        }
        if (!empty($condition['type'])) {
            $whereArr['type'] = '`type` = ' . $condition['type'];
        }
        if (!empty($whereArr)) {
            $sql .= ' WHERE ' . implode(' AND ', $whereArr) . ') ';
        }
        $res = $this->Query($sql);
        return current($res);
    }

    public function getCompetitionInfoByCpids($cpids) {
        if (empty($cpids)) {
            return false;
        }
        $res = $this->getCompetitionInfos(array('cpid' => $cpids));
        $result = array();
        if (!empty($res)) {
            foreach ($res as $v) {
                $result[$v['cpid']] = $v;
            }
        }
        return $result;
    }

    public function addCompetitions($addArr) {
        if (empty($addArr)) {
            return false;
        }
        $res = $this->insert($addArr);
        return $res;
    }
}