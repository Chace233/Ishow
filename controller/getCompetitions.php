<?php
/**
 * 获取比赛信息列表
 * User: chenlin15
 * Date: 17/3/27
 * Time: 15:45
 */
require_once 'controllerBase.php';
require_once '../module/CompetitionsModel.php';

class GetCompetitions extends controllerBase {
    protected $_fields = array('page', 'pagesize', 'cpid');

    public function __construct() {
        $this->run();
    }

    public function run() {
        $params = $this->getParams();
        $page = empty($params['page']) ? 1 : $params['page'];
        $pagesize = empty($params['pagesize']) ? 25 : $params['pagesize'];
        $condition = array();
        if (!empty($params['cpid'])) {
            $condition['cpid'] = $params['cpid'];
        }
        $competitionModel = new CompetitionsModel();
        $res = $competitionModel->getCompetitionInfos($condition, $page, $pagesize);
        $total = $competitionModel->getTotal($condition);
        $result = array();
        if (!empty($res)) {
            $result = array(
                'page'     => $page,
                'pagesize' => $pagesize,
                'total'    => current($total),
                'list'     => $res,
            );
        }
        aj_output(ErrorMsg::SUCCESS, '', $result);
    }
}

new GetCompetitions();