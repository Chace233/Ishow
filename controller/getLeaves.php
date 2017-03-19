<?php
/**
 * Created by PhpStorm.
 * User: chenlin15
 * Date: 17/3/14
 * Time: 16:59
 */

require_once 'global.php';
require_once 'controllerBase.php';
require_once '../module/IdeaTreeModel.php';

class getLeaves extends controllerBase {
    protected $_fields = array('uid', 'uname');

    /**
     * getUserInfos constructor.
     */
    public function __construct() {
        $this->run();
    }

    public function run() {
        $ret_json = array('code' => 1, 'msg' => "error");
        $params = $_GET;
        if (empty($params['parent'])){
            $ret_json["msg"]  = "params is error";
            echo(json_encode($ret_json));
            return false;
        }
        $ideaTreeModel = new IdeaTreeModel();
        $leaves = $ideaTreeModel->getLeaves("", 1);
        if (!$leaves){
            echo(json_encode($ret_json));
            return false;
        }


        //var_dump($leaves);
        //print_r($leaves);

        //translate to json type and send to browser
        $ret_json["code"] = 0;
        $ret_json["msg"]  = "success";
        $ret_json["data"] = $leaves;
        echo(json_encode($ret_json));
        return true;
    }
}

new getLeaves();