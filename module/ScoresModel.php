<?php
/**
 * 积分Model
 * User: chenlin15
 * Date: 17/3/3
 * Time: 10:23
 */

require_once "Model.php";
require_once "../controller/score.conf.php";

class ScoreModel extends Model {
    protected $_tbName = '`tblScores`';
    protected $_tbUser = '`tblUser`';

    public function __construct() {

    }

    /**
     * 添加积分记录
     * @param $addArr
     * @return bool
     */
    public function addScoreRecord($addArr) {
        if (empty($addArr['action']) || empty($addArr['uid'])) {
            return false;
        }
        if (!isset($addArr['create_time'])) {
            $addArr['create_time'] = time();
        }
        if (!isset($addArr['scores'])) {
            $addArr['scores'] = ScoreConfig::$_rules[$addArr['action']];
        }
        $res = $this->insert($addArr);
        return $res;
    }

    /**
     * 获取用户总积分
     * @param $uid
     * @return mixed
     */
    public function getUserScoresSum($uid) {
        $sql = "SELECT SUM(`scores`) AS `scores`
                FROM " . $this->_tbName . "
                WHERE `uid` = " . $uid ;
        $res = $this->Query($sql);
        return current($res);
    }

    /**
     * 获取积分排行
     * @param $limit
     * @return 成功返回结果
     */
    public function getScoresRank($limit=20) {
        $sql = "SELECT a.`scores`, u.`uname`, u.`headpic`
                FROM (
                    SELECT `uid`, SUM(`scores`) AS `scores`
                    FROM " . $this->_tbName . "
                    GROUP BY `uid`
                    ) AS `a`
                LEFT JOIN " . $this->_tbUser . " AS `u` ON a.`uid` = u.`uid`
                ORDER BY a.`scores` DESC LIMIT " . $limit;
        $res = $this->Query($sql);
        return $res;
    }
}