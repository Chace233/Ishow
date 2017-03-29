<?php
/**
 * 添加比赛信息
 * User: chenlin15
 * Date: 17/3/27
 * Time: 16:56
 */
require_once 'controllerBase.php';
require_once '../module/CompetitionsModel.php';

class AddCompetition extends controllerBase {
    protected $_fields = array('title', 'content', 'download', 'start_time', 'end_time', 'type', 'pic');

    public function __construct() {
        $this->run();
    }

    public function run() {
        $params = $this->getParams();
        if ($this->_curUser['feature'] == 1) {
            aj_output(ErrorMsg::)
        }
        if (empty($params['title']) || empty($params['content'])) {
            aj_output(ErrorMsg::ERROR_ARGUMENT);
        }
        if (mb_strlen($params['title']) > 1000) {
            aj_output(ErrorMsg::TOOLONG);
        }
        if (mb_strlen($params['content']) > 10000) {
            aj_output(ErrorMsg::TOOLONG);
        }
        $addArr = array(
            'title'       => $params['title'],
            'content'     => $params['content'],
            'create_time' => time(),
            'status'      => 1,
            'download'    => empty($params['download']) ? '' : $params['download'],
            'start_time'  => empty($params['start_time']) ? time() : $params['start_time'],
            'end_time'    => empty($params['end_time']) ? time()+24*3600 : $params['end_time'],
            'type'        => 10,
            'pic'         => empty($params['pic']) ? '' : $params['pic'],
        );
        if ($addArr['start_time'] == $params['end_time']) {
            aj_output(ErrorMsg::ERROR_ARGUMENT, '开始时间和结束时间不能相同');
        }
        $competitionModel = new CompetitionsModel();
        $res = $competitionModel->addCompetitions($addArr);
        if (false === $res) {
            aj_output(ErrorMsg::ERROR_SUBMIT);
        }
        aj_output(ErrorMsg::SUCCESS, '', $res);
    }
}

new AddCompetition();