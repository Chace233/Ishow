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
}