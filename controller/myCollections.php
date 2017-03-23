<?php
/**
 * User: chenlin15
 * Date: 17/3/17
 * Time: 11:25
 */

require_once 'controllerBase.php';
require_once '../module/CollectionsModel.php';

class MyCollections extends controllerBase {
    protected $_fields = array('uid');

    public function __construct() {
        $this->run();
    }

    public function run() {
        $params = $this->getParams();
        if (empty($params['uid'])) {
            aj_output(ErrorMsg::NOUID);
        }
        $collectionsModel = new CollectionsModel();
        $res = $collectionsModel->getCollectionInfos(array('uid' => $params['uid']));
        aj_output(ErrorMsg::SUCCESS,'', $res);
    }
}
new MyCollections();