<?php
/**
 * 添加评论
 * User: chenlin15
 * Date: 17/3/25
 * Time: 12:44
 */
require_once 'controllerBase.php';
require_once '../module/CommentModel.php';
require_once '../module/NotificationModel.php';
require_once '../module/WorksModel.php';
require_once '../module/CompetitionsModel.php';

class AddComment extends controllerBase {
    protected $_fields = array('obj', 'type', 'content');

    public function __construct() {
        $this->run();
    }

    public function run() {
        $params = $this->getParams();
        $uid = $this->_curUser['uid'];
        if (empty($params['obj']) || empty($params['type']) || empty($params['content'])) {
            aj_output(ErrorMsg::ERROR_ARGUMENT);
        }
        $addArr = array(
            'obj_id' => $params['obj'],
            'type'   => $params['type'],
            'content' => $params['content'],
            'uid'     => $uid,
            'create_time' => time(),
        );
        $commentModel = new CommentModel();
        $res = $commentModel->getCommentList(array('obj_id'=>$params['obj'], 'type'=>$params['type'], 'uid'=>$uid));
        if (!empty($res)) {
            aj_output(ErrorMsg::COMMENTED);
        }
        $res = $commentModel->insert($addArr);
        if (false === $res) {
            aj_output(ErrorMsg::ERROR_SUBMIT);
        }
        $addNotificatition = array(
            'obj_id'   => $params['obj'],
            'from_uid' => $uid,
            'type'     => $params['type'],
        );
        if ($params['type'] == COMMENT_TYPE_WORK) {
            $workModel = new WorksModel();
            $workInfos = $workModel->getWorkInfos(array('wid' => $params['obj']));
            $addNotificatition['uid'] = $workInfos[0]['create_uid'];
        }
        $notificationModel = new NotificationModel();
        $res = $notificationModel->insert($addNotificatition);
        if (false === $res) {
            aj_output(ErrorMsg::ERROR_SUBMIT);
        }
        aj_output(ErrorMsg::SUCCESS);
    }
}

new AddComment();