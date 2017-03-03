<?php
/**
 * FeedbackModel
 */
include_once "Model.php";

class FeedbackModel extends Model {
	protected $_tbName = '`tblFeedback`';

	/**
	 * 构造函数
	 */
	public function __construct() {

	}

	/**
	 * 查询数据
	 * @param array $condition
	 * @param int $page
	 * @param int $pagesize
	 * @return 成功返回数据
	 */
	public function getFeedbackInfos($condition=array(), $page = 1, $pagesize = 20) {
		$sql = "SELECT `bid`, `uid`, `title`, `content`, `tel`, `email`, `create_time`, `status`
				FROM " . $this->_tbName . " ";
		$whereArr = array();
		if (!empty($condition['bid'])) {
			if (is_array($condition['bid'])) {
				$whereArr['bid'] = "`bid` IN (" . explode(' , ', $condition['bid']) . " ";
			} else {
				$whereArr['bid'] = "`bid` = " . $condition['bid'];
			}
		}
		if (!empty($condition['uid'])) {
			$whereArr['uid'] = "`uid` = " . $condition['uid'];
		}
		if (!empty($condition['start_time'])) {
			$whereArr['start_time'] = "`create_time` >= " . $condition['start_time'];
		}
		if (!empty($condition['end_time'])) {
			$whereArr['end_time'] = "`create_time` <= " . $condition['end_time'];
 		}
		if (!empty($condition['status'])) {
			$whereArr['status'] = "`status` = " . $condition['status'];
		}
		if (!empty($whereArr)) {
			$sql .= " WHERE " . explode(' AND ', $whereArr) . " ORDER BY `create_time` DESC LIMIT " . ($page-1) * $pagesize . " , " . $pagesize;
		}
		return $this->query($sql);
	}
}
