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
        $uid = $this->_curUser['uid'];
        $worksModel = new WorksModel();
        $res = $worksModel->getWorkInfos(array('create_uid' => $uid));
        aj_output(ErrorMsg::SUCCESS, '', $res);
    }
}

new GetWorkInfos();