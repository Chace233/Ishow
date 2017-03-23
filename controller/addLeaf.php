<?php

/**
 * @author: zoubing
 * @date:   2017-3-21
 */

require_once 'global.php';
require_once 'controllerBase.php';
require_once '../module/IdeaTreeModel.php';

class addLeaf extends controllerBase {
    protected $_fields = array('platform', 'parent', 'idea', 'user_id');

    /**
     * getUserInfos constructor.
     */
    public function __construct() {
        $this->run();
    }

    public function run() {
        $ret_json = array('code' => 1, 'msg' => "error");
        $platform = $_GET['platform'];
        $params   = $_POST;

        if (empty($params['parent']) && empty($params['idea']) && empty($params['user_id'])){
            $ret_json["msg"]  = "params is error";
            echo(json_encode($ret_json));
            return false;
        }

        $ideaTreeModel = new IdeaTreeModel();
        $ret = $ideaTreeModel->addLeaf($params['parent'], $params['idea'], $params['user_id']);

        //translate to json type and send to browser
        if (!$ret){
            echo(json_encode($ret_json));
            return false;
        }
        
        $ret_json["code"] = 0;
        $ret_json["msg"]  = "success";
        echo(json_encode($ret_json));
        return true;
    }
}

new addLeaf();