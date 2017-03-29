<?php
/**
 * 修改作品
 * User: chenlin15
 * Date: 17/3/29
 * Time: 11:08
 */

require_once 'controllerBase.php';
require_once '../module/WorksModel.php';

class EditWork extends controllerBase {
    protected $_fields = array('wid', 'title', 'content', 'type', 'pic', 'op'); //op:操作类型  edit:修改  del:删除 默认为修改

    public function __construct() {
        $this->run();
    }

    public function run() {
        $params = $this->getParams();
        if (empty($params['wid'])) {
            aj_output(ErrorMsg::NOWID);
        }
        $workModel = new WorksModel();
        $whereArr = array(
            'wid' => $params['wid'],
        );
        $res = $workModel->getWorkInfos($whereArr);
        if (empty($res)) {
            aj_output(ErrorMsg::NOWORK);
        }
        if (!empty($params['op']) && $params['op'] == 'del') {
            $editArr = array(
                'status' => 2,
            );
            $res = $workModel->update($editArr, $whereArr);
            if (false === $res) {
                aj_output(ErrorMsg::ERROR_SUBMIT);
            }
        } else {
            $editArr = array();
            if (!empty($params['title'])) {
                $editArr['title'] = $params['title'];
                $editArr['title_key'] = md5($params['title']);
            }
            if (!empty($params['content'])) {
                $editArr['content'] = $params['content'];
            }
            if (!empty($params['type'])) {
                $editArr['type'] = $params['type'];
            }
            if (!empty($params['pic'])) {
                $editArr['pic'] = $params['pic'];
            }
            if (!empty($editArr)) {
                $res = $workModel->update($editArr, $whereArr);
                if (false === $res) {
                    aj_output(ErrorMsg::ERROR_SUBMIT);
                }
            }
        }
        aj_output(ErrorMsg::SUCCESS);
    }
}

new EditWork();