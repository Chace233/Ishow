<?php
/**
 * 获取评论
 * User: chenlin15
 * Date: 17/3/25
 * Time: 09:51
 */
require_once 'controllerBase.php';
require_once '../module/CommentModel.php';

class GetComments extends controllerBase {
    protected $_fields = array('obj', 'type', 'page', 'pagesize');

    public function __construct() {
        $this->run();
    }

    public function run() {
        $params = $this->getParams();
        if (empty($params['obj']) || empty($params['type'])) {
            aj_output(ErrorMsg::ERROR_ARGUMENT);
        }
        $condition = array(
            'obj_id'  => $params['obj'],
            'type'    => $params['type'],
        );
        $page = empty($params['page']) ? 1 : $params['page'];
        $pagesize = empty($params['pagesize']) ? 25 : $params['pagesize'];
        $commentModel = new CommentModel();
        $res = $commentModel->getCommentList($condition, $page, $pagesize);
        aj_output(ErrorMsg::SUCCESS, '', $res);
    }
}

new GetComments();