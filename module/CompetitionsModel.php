<?php
/**
 * 比赛信息Model
 * User: chenlin15
 * Date: 17/3/3
 * Time: 10:25
 */

include 'Model.php';

class CompetitionsModel extends Model{
    protected $_tbName = '`tblCompetitions`';

    /**
     * 构造函数
     */
	public function __construct() {

    }

    public function addCompetitions($addArr) {
        if (empty($addArr)) {
            return false;
        }
        $res = $this->insert($addArr);
        return $res;
    }
}