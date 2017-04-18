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
    protected $_fields = array('title', 'content', 'type', 'file_url');

    public function __construct() {
        $this->run();
    }

    public function run() {
        $params = $this->getParams();
        if (empty($params['title'])) {
            aj_output(ErrorMsg::ERROR_ARGUMENT);
        }
        $worksModel = new WorksModel();
        $res = $worksModel->getWorkInfos(array('title_key' => md5($params['title'])));
        if (!empty($res)) {
            aj_output(ErrorMsg::HAVEDTITLE);
        }
        $addArr = array(
            'title'       => $params['title'],
            'content'     => $params['content'],
            'create_time' => time(),
            'create_uid'  => $this->_curUser['uid'],
            'title_key'   => md5($params['title']),
            'status'      => 1,
            'type'        => empty($params['type']) ? 0 : $params['type'],
            'file_url'    => empty($params['file_url']) ? '' : $params['file_url'],
        );
        if ($params['type'] == 20) {
            $addArr['pic'] = 'images/image2.jpg';
        } else if ($params['type'] == 21) {
            $addArr['pic'] = 'images/image2-1.jpg';
        } else if ($params['type'] == 22) {
            $addArr['pic'] = 'images/image3.jpg';
        } else if ($params['type'] == 23) {
            $addArr['pic'] = 'images/image3-1.jpg';
        }
        $worksModel->startTransaction();
        $res = $worksModel->addWork($addArr);
        if (false === $res) {
            $worksModel->rollback();
            aj_output(ErrorMsg::ERROR_SUBMIT, 'insert workModel error');
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
            aj_output(ErrorMsg::ERROR_SUBMIT, 'insert scoreModel error');
        }
        $worksModel->commit();
        aj_output(ErrorMsg::SUCCESS, '', $res);
    }
}

new AddWork();

