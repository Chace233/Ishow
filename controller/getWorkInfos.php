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
    protected $_fields = array('op', 'type', 'wid', 'type', 'page', 'pagesize');

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
        if ($params['op'] == 'user') {
            $uid = $this->_curUser['uid'];
            $res = $worksModel->getWorkInfos(array('create_uid' => $uid, 'status' => 1));
        } else if (!empty($params['wid'])) {
            $res = $worksModel->getWorkInfos(array('wid' => $params['wid']));
        } else{
            $page = empty($params['page']) ? 1 : $params['page'];
            $pagesize = empty($params['pagesize']) ? 15 : $params['pagesize'];
            $condition = array(
                'status' => 1
            );
            if (!empty($params['type'])){
                $condition['type'] = $params['type'];
            }
            if (!empty($params['op'])) {
                $condition['op'] = $params['op'];
            }
            $result = $worksModel->getWorkInfos($condition, $page, $pagesize);
            $total = $worksModel->getTotalOfWorks($condition);
            $res = array(
                'total'    => current($total),
                'page'     => $page,
                'pagesize' => $pagesize,
                'list'     => $result,
            );
        }
        aj_output(ErrorMsg::SUCCESS, '', $res);
    }
}

new GetWorkInfos();