<?php
/**
 * 上传文件
 * User: chenlin15
 * Date: 17/3/27
 * Time: 10:23
 */
require_once 'controllerBase.php';

class UploadFile extends controllerBase {
    protected $_fields = array('type');

    public function __construct() {
        $this->run();
    }

    public function FileLimitSize() {
        return 20 * 1024 * 1024;
    }

    public function run() {
        $params = $this->getParams();
        $upload_file = $_FILES['file'];
        $file = $upload_file['tmp_name'];
        $filename = substr($file, strrpos($file, '/')+1);
        if (!isset($upload_file) || $upload_file['error'] != 0) {
            aj_output(ErrorMsg::ERRUPLOAD);
        }
        if ($params['type'] == 'pic' && !isImage($file)) {
            aj_output(ErrorMsg::ERRPIC);
        }
        if ($upload_file['size'] > $this->FileLimitSize()) {
            aj_output(ErrorMsg::TOOBIG);
        }
        if (file_exists(URI_HOST . "/template/upload/" . $filename)) {
            $res = array(
                'url' => 'http://101.200.59.83/images/upload/' . $filename,
            );
            aj_output(ErrorMsg::SUCCESS, '', $res);
        } else {
            $res = move_uploaded_file($file, '/Users/chenlin15/Documents/' . $filename);
            if (false === $res) {
                aj_output(ErrorMsg::ERRUPLOAD);
            }
            $res = array(
                'url' => 'http://101.200.59.83/images/' . $filename,
            );
            aj_output(ErrorMsg::SUCCESS, '' , $res);
        }
    }
}

new UploadFile();