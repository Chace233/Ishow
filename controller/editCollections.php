<?php
/**
 * 取消收藏
 * User: chenlin15
 * Date: 17/3/23
 * Time: 16:00
 */

require_once 'controllerBase.php';
require_once '../module/CollectionsModel.php';

class EditCollections extends controllerBase {
    protected $_fields = array('op', 'ccid');

    public function __construct() {
        $this->run();
    }

    public function run() {
        $params = $this->getParams();
        if (empty($params['ccid'])) {
            aj_output(ErrorMsg::NOCCID);
        }
        $collectionsModel = new CollectionsModel();
        $res = $collectionsModel->getCollectionInfos(array('ccid' => $params['ccid']));
        if (empty($res)) {
            aj_output(ErrorMsg::ERROR_ARGUMENT);
        }
        $editArr = array(
            'status' => 2,
        );
        $whereArr = array(
            'ccid' => $params['ccid'],
        );
        $res = $collectionsModel->update($editArr, $whereArr);
        if (false === $res) {
            aj_output(ErrorMsg::ERROR_SUBMIT);
        }
        aj_output(ErrorMsg::SUCCESS);
    }
}

new EditCollections();