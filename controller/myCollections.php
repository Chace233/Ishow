<?php
/**
 * User: chenlin15
 * Date: 17/3/17
 * Time: 11:25
 */

require_once 'controllerBase.php';
require_once '../module/CollectionsModel.php';
require_once '../module/WorksModel.php';
require_once '../module/CompetitionsModel.php';

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
        $res = $collectionsModel->getCollectionInfos(array('uid' => $params['uid'], 'status' => 1));
        $wids = array();
        $cpids = array();
        if (empty($res)) {
            aj_output(ErrorMsg::SUCCESS);
        }
        foreach ($res as $v) {
            if (1 == $v['obj_type']) {
                $wids[$v['obj_id']] = $v['obj_id'];
            } else if (2 == $v['obj_type']) {
                $cpids[$v['obj_id']] = $v['obj_id'];
            }
        }
        if (!empty($wids)) {
            $worksMode = new WorksModel();
            $workInfos = $worksMode->getWorkInfosByWids($wids);
        }
        if (!empty($cpids)) {
            $competitionsModel = new CompetitionsModel();
            $competitionInfos = $competitionsModel->getCompetitionInfoByCpids($cpids);
        }
        $result = array();
        foreach($res as $v) {
            $r = array();
            $r['ccid'] = $v['ccid'];
            $r['uid']  = $v['uid'];
            $r['obj']  = $v['obj_id'];
            $r['type'] = $v['obj_type'];
            if (1 == $v['obj_type']) {
                $r['title']         = $workInfos[$v['obj_id']]['title'];
                $r['content']       = $workInfos[$v['obj_id']]['content'];
                $r['create_time']   = $workInfos[$v['obj_id']]['create_time'];
                $r['status']        = $workInfos[$v['obj_id']]['status'];
                $r['titdownloadle'] = $workInfos[$v['obj_id']]['download'];
                $r['start_time']    = $workInfos[$v['obj_id']]['start_time'];
                $r['end_time']      = $workInfos[$v['obj_id']]['end_time'];
                $r['type']          = $workInfos[$v['obj_id']]['type'];
            } else if (2 == $v['obj_type']) {
                $r['title']          = $competitionInfos[$v['obj_id']]['title'];
                $r['content']        = $competitionInfos[$v['obj_id']]['content'];
                $r['create_time']    = $competitionInfos[$v['obj_id']]['create_time'];
                $r['comment_num']    = $competitionInfos[$v['obj_id']]['comment_num'];
                $r['collection_num'] = $competitionInfos[$v['obj_id']]['collection_num'];
                $r['brower_num']     = $competitionInfos[$v['obj_id']]['brower_num'];
                $r['title_key']      = $competitionInfos[$v['obj_id']]['title_key'];
                $r['status']         = $competitionInfos[$v['obj_id']]['status'];
                $r['vote_num']       = $competitionInfos[$v['obj_id']]['vote_num'];
            }
            $result[] = $r;
        }
        aj_output(ErrorMsg::SUCCESS,'', $result);
    }
}
new MyCollections();