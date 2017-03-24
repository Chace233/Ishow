<?php
/**
 * 添加作品
 * User: chenlin15
 * Date: 17/3/23
 * Time: 16:17
 */

require_once 'controllerBase.php';
require_once '../module/WorksModel.php';

class AddWork extends controllerBase {
    protected $_fields = array('title', 'content', 'uid');

    public function __construct() {
        $this->run();
    }

    public function run() {
        $params = $this->getParams();
        if (empty($params['title']) || empty($params['content']) || empty($params['uid'])) {
            aj_output(ErrorMsg::ERROR_ARGUMENT);
        }
        $addArr = array(
            'title'       => $params['title'],
            'content'     => $params['content'],
            'create_time' => time(),
            'create_uid'  => $params['uid'],
            'title_key'   => md5($params['title']),
            'status'      => 1,
        );

        $worksModel = new WorksModel();
        $res = $worksModel->addWork($addArr);
        if (false === $res) {
            aj_output(ErrorMsg::ERROR_SUBMIT);
        }
        aj_output(ErrorMsg::SUCCESS, '', $res);
    }
}

new AddWork();