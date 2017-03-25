<?php
/**
 * 查询发布作品信息
 * User: chenlin15
 * Date: 17/3/24
 * Time: 11:11
 */

require_once "controllerBase.php";
require_once "../module/WorksModel.php";

class GetWorkInfos extends controllerBase {
    protected $_fields = array('op', 'type', 'wid');

    /**
     * GetWorkInfos constructor.
     */
    public function __construct() {
        $this->run();
    }

    /**
     * 入口函数
     * @param $params
     * @return json
     */
    public function run() {
        $params = $this->getParams();
        $worksModel = new WorksModel();
        if (!isset($params['op'])) {
            $uid = $this->_curUser['uid'];
            $res = $worksModel->getWorkInfos(array('create_uid' => $uid, 'status' => 1));
        } else if ($params['op'] == 'list') {
            $res = $worksModel->getWorkInfos(array('status' => 1));
        } else if (empty($params['wid'])) {
            $res = $worksModel->getWorkInfos(array('wid' => $params['wid']));
        }
        aj_output(ErrorMsg::SUCCESS, '', $res);
    }
}

new GetWorkInfos();