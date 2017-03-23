<?php
/**
 * Created by PhpStorm.
 * User: chenlin15
 * Date: 17/3/17
 * Time: 11:33
 */

require_once 'controllerBase.php';
require_once '../module/UserModel.php';

class register extends controllerBase {
    protected $_fields = array('uname', 'tel', 'email', 'intro', 'feature');

    public function __construct() {
        $this->run();
    }

    public function run() {
        $params = $this->getParams();
        if (empty($params['uname'])) {
            aj_output(ErrorMsg::NOUNAME);
        }
        if (!empty($params['tel']) && preg_match('/^1[34578]{1}\d{9}$/', $params['tel'])) {
            aj_output(ErrorMsg::ERRTEL);
        }
        $addArr = array(
            'uname' => $params['uname'],
        );
    }
}