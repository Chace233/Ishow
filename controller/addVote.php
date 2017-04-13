<?php
/**
 * Created by PhpStorm.
 * User: chenlin15
 * Date: 17/3/23
 * Time: 11:30
 */
require_once "controllerBase.php";
require_once "../module/VoteModel.php";
require_once "../module/WorksModel.php";
require_once "../module/ScoresModel.php";

class AddCollections extends controllerBase {
    protected $_fields = array('obj', 'type');

    /**
     * AddCollections constructor.
     */
    public function __construct() {
        $this->run();
    }

    public function run() {
        $params = $this->getParams();
        $params['uid'] = $this->_curUser['uid'];
        if (empty($params['obj'])) {
            aj_output(ErrorMsg::NOOBJ);
        }
        /*if (empty($params['type'])) {
            aj_output(ErrorMsg::NOTYPE);
        }*/
        $voteModel = new VoteModel();
        $res = $voteModel->getVoteInfos(array('uid' => $params['uid'], 'obj_id' => $params['obj'], 'obj_type' => $params['type']));
        if (!empty($res)) {
            aj_output(ErrorMsg::VOTEED);
        }
        $workModel = new WorksModel();
        $workInfo = $workModel->getWorkInfos(array('wid' => $params['obj']));
        if (empty($workInfo)) {
            aj_output(ErrorMsg::NOWORK);
        }

        $condition = array(
            'uid'         => $params['uid'],
            'uid2'        => $workInfo[0]['create_uid'],
            'obj_id'      => $params['obj'],
            'type'        => empty($params['type']) ? 1 : $params['type'],
            'create_time' => time(),
        );
        $voteModel->startTransaction();
        $res = $voteModel->insert($condition);
        if (false === $res) {
            $voteModel->rollback();
            aj_output(ErrorMsg::ERROR_SUBMIT);
        }
        $scoreModel = new ScoreModel();
        $addArr = array(
            'action'    => ScoreConfig::VOTE,
            'from_uid'  => $params['uid'],
            'uid'       => $workInfo[0]['create_uid'],
        );
        $res = $scoreModel->addScoreRecord($addArr);
        if (false === $res) {
            $voteModel->rollback();
            aj_output(ErrorMsg::ERROR_SUBMIT);
        }

        $voteModel->commit();
        aj_output(ErrorMsg::SUCCESS, '', $res);
    }
}
new AddCollections();