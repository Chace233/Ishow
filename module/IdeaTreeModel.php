<?php

/**
 * Base Model(数据层基类)
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
}

?>