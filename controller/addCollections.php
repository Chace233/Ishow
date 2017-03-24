<?php
/**
 * Created by PhpStorm.
 * User: chenlin15
 * Date: 17/3/23
 * Time: 11:30
 */
require_once "controllerBase.php";
require_once "../module/CollectionsModel.php";

class AddCollections extends controllerBase {
    protected $_fields = array('uid', 'obj', 'type');

    /**
     * AddCollections constructor.
     */
    public function __construct() {
        $this->run();
    }

    public function run() {
        $params = $this->getParams();
        if (empty($params['uid'])) {
            aj_output(ErrorMsg::NOUID);
        }
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
        $condition = array(
            'uid'         => $params['uid'],
            'obj_id'      => $params['obj'],
            'obj_type'    => $params['type'],
            'create_time' => time(),
        );
        $res = $collectionsModel->insert($condition);
        if (false === $res) {
            aj_output(ErrorMsg::ERROR_SUBMIT);
        }
        aj_output(ErrorMsg::SUCCESS, '', $res);
    }
}
new AddCollections();