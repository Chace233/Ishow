<?php

/**
 * IdeaTree Model
 * @author zoubing
 */

require_once 'Model.php';

class IdeaTreeModel extends Model {
    protected $tb_ideatree = '`ideatree`';
    protected $tb_ideatree_root = '`ideatree_root`';
    protected $tb_ideatree_mark = '`ideatree_mark`';


    public function getLeaves($root, $pid) {
        $sql = "SELECT * FROM ". $this->tb_ideatree ." WHERE `PID`=".$pid;

		if (!empty($root)) {
           $sql .= " WHERE `ROOT`=".$root;
		}
        $res = $this->QueryAll($sql);

        $rows = array();
        for($i=0;$i<sizeof($res);$i++){
            $rows[$i]['user_id']   = $res[$i]['uid'];
            $rows[$i]['leaf_id']   = $res[$i]['tid'];
            $rows[$i]['parent_id'] = $res[$i]['pid'];
        }

    	return $rows;
    }

    public function getUserLeaves($root, $uid) {
        $sql = "SELECT * FROM ". $this->tb_ideatree ." WHERE `UID`=".$uid;

		if (!empty($root)) {
           $sql .= " WHERE `ROOT`=".$root;
		}
        $res = $this->QueryAll($sql);

        $rows = array();
        for($i=0;$i<sizeof($res);$i++){
            $rows[$i]['user_id']   = $res[$i]['uid'];
            $rows[$i]['leaf_id']   = $res[$i]['tid'];
            $rows[$i]['parent_id'] = $res[$i]['pid'];
        }

    	return $rows;
    }

    public function getLeaf($root, $tid) {
        $sql = "SELECT text FROM ". $this->tb_ideatree ." WHERE `TID`=".$tid;

		if (!empty($root)) {
           $sql .= " WHERE `ROOT`=".$root;
		}
        $res = $this->Query($sql);

    	return $res["text"];
    }

    public function addLeaf($pid, $text, $uid) {
        $data = array('pid' => $pid, 'text' => $text, 'uid' => $uid);

        $ret = $this->insertRaw($data,'`ideatree`');
        return $ret==0?false:true;
    }

    public function modifyLeaf($tid, $text){
        $whereArr = array('tid' => $tid);
        $setArr   = array('text' => $text);

        $ret = $this->updateRaw($setArr, $whereArr, '`ideatree`');
        return $ret;
    }
}

?>