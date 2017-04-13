<?php
/**
 * 上传文件
 * User: chenlin15
 * Date: 17/3/27
 * Time: 10:23
 */
require_once 'controllerBase.php';

function getMillisecond() {
    list($t1, $t2) = explode(' ', microtime());
    return (float)sprintf('%.0f',(floatval($t1)+floatval($t2))*1000);
}

function create_guid(){ 
    $microTime = microtime(); 
    list($a_dec, $a_sec) = explode(" ", $microTime); 
    $dec_hex = dechex($a_dec* 1000000); 
    $sec_hex = dechex($a_sec); 
    ensureLength($dec_hex, 5); 
    ensureLength($sec_hex, 6); 
    $guid = ""; 
    $guid .= $dec_hex; 
    $guid .= createGuidSection(3); 
    $guid .= '-'; 
    $guid .= createGuidSection(4); 
    $guid .= '-'; 
    $guid .= createGuidSection(4); 
    $guid .= '-'; 
    $guid .= createGuidSection(4); 
    $guid .= '-'; 
    $guid .= $sec_hex; 
    $guid .= createGuidSection(6); 
    return $guid; 
} 

function ensureLength(&$string, $length){    
    $strlen = strlen($string);    
    if($strlen < $length)    
    {    
        $string = str_pad($string,$length,"0");    
    }    
    else if($strlen > $length)    
    {    
        $string = substr($string, 0, $length);    
    }   
 } 

function createGuidSection($characters){ 
    $return = ""; 
    for($i=0; $i<$characters; $i++) 
    { 
        $return .= dechex(mt_rand(0,15)); 
    } 
    return $return; 
}

class UploadFile extends controllerBase {
    protected $_fields = array('type');

    public function __construct() {
        $this->run();
    }

    public function FileLimitSize() {
        return 20 * 1024 * 1024;
    }
    
    public function randFileName(){
        return getMillisecond(). "-" .create_guid();
    }

    public function run() {
        $params = $this->getParams();
        $upload_file = $_FILES['file'];
        $file = $upload_file['tmp_name'];
        $filename = basename($_FILES['file']['name']);//substr($file, strrpos($file, '/')+1);
        if (!isset($upload_file) || $upload_file['error'] != 0) {
            aj_output(ErrorMsg::ERRUPLOAD);
        }
        if (isset($params['type']) && $params['type'] == 'pic' && !isImage($file)) {
            aj_output(ErrorMsg::ERRPIC);
        }
        if ($upload_file['size'] > $this->FileLimitSize()) {
            aj_output(ErrorMsg::TOOBIG);
        }
        
        $tmpFileName = $this->randFileName() . ".jpg";
        $res = move_uploaded_file($file, URI_HOST . "/template/images/upload/" . $tmpFileName);
        if (false === $res) {
            aj_output(ErrorMsg::ERRUPLOAD);
        }
        $res = array(
            'url' => 'http://127.0.0.1/template/images/upload/' . $tmpFileName,
        );
        aj_output(ErrorMsg::SUCCESS, '' , $res);


        /*
        if (file_exists(URI_HOST . "/template/images/upload/" . $filename)) {
            $res = array(
                'url' => 'http://101.200.59.83/template/images/upload/' . $filename,
            );
            aj_output(ErrorMsg::SUCCESS, '', $res);
        } else {
            $res = move_uploaded_file($file, URI_HOST . "/template/images/upload/" . $filename);
            if (false === $res) {
                aj_output(ErrorMsg::ERRUPLOAD);
            }
            $res = array(
                'url' => 'http://101.200.59.83/template/images/upload/' . $filename,
            );
            aj_output(ErrorMsg::SUCCESS, '' , $res);
        }*/
    }
}

new UploadFile();