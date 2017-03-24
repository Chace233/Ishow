<?php
/**
 * Created by PhpStorm.
 * User: chenlin15
 * Date: 17/3/23
 * Time: 11:30
 */
require_once "controllerBase.php";
require_once "../module/CollectionsModel.php";
require_once "../module/WorksModel.php";

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
        if (empty($params['type'])) {
            aj_output(ErrorMsg::NOTYPE);
        }
        $collectionsModel = new CollectionsModel();
        $res = $collectionsModel->getCollectionInfos(array('uid' => $params['uid'], 'obj_id' => $params['obj'], 'obj_type' => $params['type']));
        if (!empty($res)) {
            aj_output(ErrorMsg::COLLECTED);
        }
        $workModel = new WorksModel();
        if ($params['type'] == 1) {
            $workInfo = $workModel->getWorkInfos(array('wid' => $params['obj']));
            if (empty($workInfo)) {
                aj_output(ErrorMsg::NOWORK);
            }
        }
        $condition = array(
            'uid'         => $params['uid'],
            'obj_id'      => $params['obj'],
            'obj_type'    => $params['type'],
            'create_time' => time(),
        );
        $collectionsModel->startTransaction();
        $res = $collectionsModel->insert($condition);
        if (false === $res) {
            $collectionsModel->rollback();
            aj_output(ErrorMsg::ERROR_SUBMIT);
        }
        $scoreModel = new ScoreModel();
        if ($params['type'] == 1) {
            $addArr = array(
                'action'    => ScoreConfig::COLLECTED,
                'from_uid'  => $params['uid'],
                'uid'       => $workInfo[0]['create_uid'],
            );
            $res = $scoreModel->addScoreRecord($addArr);
            if (false === $res) {
                $collectionsModel->rollback();
                aj_output(ErrorMsg::ERROR_SUBMIT);
            }
        }
        $collectionsModel->commit();
        aj_output(ErrorMsg::SUCCESS, '', $res);
    }
}
new AddCollections();