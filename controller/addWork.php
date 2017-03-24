<?php
/**
 * 添加作品
 * User: chenlin15
 * Date: 17/3/23
 * Time: 16:17
 */

require_once 'controllerBase.php';
require_once '../module/WorksModel.php';
require_once '../module/ScoresModel.php';

class AddWork extends controllerBase {
    protected $_fields = array('title', 'content', 'uid', 'type');

    public function __construct() {
        $this->run();
    }

    public function run() {
        $params = $this->getParams();
        if (empty($params['title']) || empty($params['content'])) {
            aj_output(ErrorMsg::ERROR_ARGUMENT);
        }
        $addArr = array(
            'title'       => $params['title'],
            'content'     => $params['content'],
            'create_time' => time(),
            'create_uid'  => $this->_curUser['uid'],
            'title_key'   => md5($params['title']),
            'status'      => 1,
            'type'        => empty($params['type']) ? 0 : $params['type'],
        );
        $worksModel = new WorksModel();
        $worksModel->startTransaction();
        $res = $worksModel->addWork($addArr);
        if (false === $res) {
            $worksModel->rollback();
            aj_output(ErrorMsg::ERROR_SUBMIT);
        }
        $scoreModel = new ScoreModel();
        $addArr = array(
            'action' => ScoreConfig::SUBMITWORK,
            'uid'    => $this->_curUser['uid'],
            'from_uid' => 0,
        );
        $res = $scoreModel->addScoreRecord($addArr);
        if (false === $res) {
            $worksModel->rollback();
            aj_output(ErrorMsg::ERROR_SUBMIT);
        }
        $worksModel->commit();
        aj_output(ErrorMsg::SUCCESS, '', $res);
    }
}

new AddWork();