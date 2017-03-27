<?php
/**
 * 获取积分排行
 * User: chenlin15
 * Date: 17/3/27
 * Time: 16:34
 */
require_once 'controllerBase.php';
require_once '../module/ScoresModel.php';

class GetScoresRank extends controllerBase {
    protected $_fields = array('limit');

    public function __construct() {
        $this->run();
    }

    public function run() {
        $params = $this->getParams();
        $limit = isset($params['limit']) ? $params['limit'] : 20;
        $scoresModel = new ScoreModel();
        $res = $scoresModel->getScoresRank($limit);
        if (false === $res) {
            aj_output(ErrorMsg::ERROR_SUBMIT);
        }
        aj_output(ErrorMsg::SUCCESS, '', $res);
    }
}

new GetScoresRank();