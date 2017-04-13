<?php
/**
 * Created by PhpStorm.
 * User: chenlin15
 * Date: 17/3/14
 * Time: 16:59
 */

require_once 'global.php';
require_once 'controllerBase.php';
require_once '../module/UserModel.php';
require_once '../module/ScoresModel.php';

class getUserInfos extends controllerBase {
    protected $_fields = array('uname');

    /**
     * getUserInfos constructor.
     */
    public function __construct() {
        $this->run();
    }

    public function run() {
        $params = $this->getParams();
        $userModel = new UserModel();
        if (!isset($params['uname'])) {
            $condition = array(
                'uname' => $this->_curUser['uname'],
            );
        } else {
            $condition = array(
                'uname' => $params['uname'],
            );
        }
        $userinfos = $userModel->getUserInfos($condition);
        $scoresModel = new ScoreModel();
        $userinfos[0]['scores'] = current($scoresModel->getUserScoresSum($userinfos[0]['uid']));
        aj_output(ErrorMsg::SUCCESS, '', $userinfos);
    }
}

new getUserInfos();