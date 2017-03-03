<?php

/**
 * Base Model(数据层基类)
 * @author chenlin
 */
include '../conf/db.conf.php';

class Model {
	protected $_tbName = '';
	protected $_mdb    = null;
	protected $_sdb    = null;
	private static $_dbArray = array();

	/**
	 * 单例
	 * @param string $dbName 数据库名
	 * @return object 数据库连接对象
	 */
	public static function getInstance($dbName = 'ishow') {
		global $conf;
		if (empty(self::$_dbArray[$dbName]) || (self::$_dbArray[$dbName]->isConnected === false)) {
			$db = new mysqli($conf['db']['host'], $conf['db']['user'], $conf['db']['password'],$dbName);
			self::$_dbArray[$dbName] = $db;
		}
		return self::$_dbArray[$dbName];
	}

	/**
	 * 写连接(主链接)
	 */
	public function masterConn() {
		if (empty($this->_mdb)) {
			$this->_mdb = self::getInstance();
			if (empty($this->_mdb)) {
				sleep(1);
				$this->_mdb = self::getInstance();
			}
		}
	}

	/**
	 * 读连接
	 */
	public function slaveConn() {
		if (empty($this->_sdb)) {
			$this->_sdb = self::getInstance();
			if (empty($this->_sdb)) {
				sleep(1);
				$this->_sdb = self::getInstance();
			}
		}
	}

	/**
	 * 查询
	 * @param string $sql 查询语句
	 * @return 成功返回结果
	 */
	public function query($sql) {
		if (empty($sql)) {
			return false;
		}
		$this->slaveConn();
		$res = $this->_sdb->query($sql,MYSQLI_USE_RESULT);
		$row=$res->fetch_all();
		return $row;
	}

	/**
	 * 获取一条记录
	 * @param $sql
	 * @return array|bool
	 */
	public function getRow($sql) {
		$res = $this->query($sql);
		if (false === $res) {
			return false;
		}
		return empty($res) ? array() : $res[0];
	}

	/**
	 * 获取一个字段的记录
	 * @param $sql
	 * @return bool|mixed|null
	 */
	public function getField($sql) {
		$res = $this->getRow($sql);
		if (false === $res) {
			return false;
		}
		return is_array($res) ? current($res) : null;
	}

	/**
	 * 批量插入
	 * @param $sql
	 * @return bool
	 */
	public function batchInsert($sql) {
		if (empty($sql)) {
			return false;
		}
		$this->masterConn();
		$res = $this->_mdb->query($sql);
		return $res;
	}

	/**
	 * @param $sql
	 * @return 成功返回id
	 */
	public function insert($sql) {
		if (empty($sql)) {
			return false;
		}
		$this->masterConn();
		$res = $this->_mdb->query($sql);
		if (false === $res) {
			return false;
		}
		return $this->_mdb->insert_id;
	}

	/**
	 * 更新
	 * @param $sql
	 * @return bool
	 */
	public function update($sql) {
		if (empty($sql)) {
			return false;
		}
		$this->masterConn();
		$res = $this->_mdb->query($sql);
		if (false === $res) {
			return false;
		}
		return $res;
	}

	/**
	 * 删除
	 * @param $sql
	 * @return bool
	 */
	public function delete($sql) {
		if (empty($sql)) {
			return false;
		}
		$this->masterConn();
		$res = $this->_mdb->query($sql);
		return $res;
	}

	/**
	 * 开始一个事物
	 * @return mixed
	 */
	public function startTransaction() {
		$this->masterConn();
		$res = $this->_mdb->begin_transaction(MYSQLI_TRANS_START_READ_WRITE);
		return $res;
	}

	/**
	 * 事物提交
	 * @return mixed
	 */
	public function commit() {
		return $this->_mdb->commit();
	}

	/**
	 * 事物回滚
	 * @return mixed
	 */
	public function rollback() {
		return $this->_mb->rollback();
	}

	public function getError() {
		$this->masterConn();
		$error = array(
			'errno' => $this->_mdb->errno(),
			'error' => $this->_mdb->error(),
		);
		return $error;
	}
}

