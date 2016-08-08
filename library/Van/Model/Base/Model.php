<?php
/**
 *类模型基类
 *
 *@package Van_Model_Base
 *@author  zengzf
 *@since   2016.06.11
 *@version Van_Model_Base:1.0
 */

/**引入Application接口文件*/
require_once 'Van/Model/Interface/Interface.php';

class Van_Model_Base implements Van_Model_Interface
{
	/**
	 *@var 数据库资源
	 */
	private $_db_conn;

	/**
	 *@var 主机名
	 */
	private $_db_host;

	/**
	 *@var 数据库名
	 */
	private $_db_name;

	/**
	 *@var 数据库用户名
	 */
	private $_db_user;

	/**
	 *@var 数据库密码
	 */
	private $_db_password; 

	/**
	 *@var 数据库表名
	 */
	private $_db_table;

	/**
	 *数据库连接
	 */
	public function __construct()
	{
		$this->_db_host = Van_APPLICATION::Config('db_host');
		$this->_db_name = Van_APPLICATION::Config('db_name');
		$this->_db_user = Van_APPLICATION::Config('db_user');
		$this->_db_password = Van_APPLICATION::Config('db_password');
		
		$this->_db_conn = @mysql_connect($this->_db_host, $this->_db_user, $this->_db_password);

		if ($this->_db_conn) {
			mysql_query('SET NAMES UTF8', $this->_db_conn);
			mysql_select_db($this->_db_name);
		} else {
			throw new Van_Exception("数据库连接失败");
		}

		$this->_db_table = isset($this->_db_table_name) ? $this->_db_table_name : get_class($this);
	}

	/**
	 *sql引擎转换
	 *
	 *@param  $whereName：string or array 查询条件限定名
	 *@param  $whereValue：string or array 查询条件限定值
	 *@return $where：查询限定条件
	 */
	public function Adaptertansql($whereName = null, $whereValue = null)
	{
		if (!empty($whereName) && !empty($whereValue)) {
			if (is_string($whereName) && is_string($whereValue)) {
				$whereArray = spliti(' +', $whereName);
				if (in_array('?', $whereArray)) {
					$where = str_replace('?', "'".$whereValue."'", $whereName);				
				} else {
					throw new Van_Exception("参数：'".$whereName."' 错误，缺少'?'");
				}
			} elseif (is_array($whereName) && is_array($whereValue)) {
				if (count($whereName) != count($whereValue)) {
					throw new Van_Exception("参数：'".$whereName."' 和参数：'".$whereValue."' 不对应");
				}
				$where = '';
				$countKey = 0;
				foreach ($whereName as $key => $whereNameValue) {
					$whereArray = spliti(' +', $whereNameValue);
					if (in_array('?', $whereArray)) {
						if ($countKey == ($key-1)) {
							$where .= str_replace('?', "'".$whereValue[$key]."'", $whereNameValue);
						} else {
							$where .= str_replace('?', "'".$whereValue[$key]."'", $whereNameValue)." AND ";
						}
					} else {
						throw new Van_Exception("参数：'".$whereNameValue."' 错误，缺少'?'");
					}
				}
			} else {
				throw new Van_Exception('参数：'.$whereName.' 或 '.$whereValue." 不是string或array");
			}
		} else {
			$where = null;
		}
		
		return $where;
	}

	/**
	 *数据库数据查询
	 *
	 *@param  $where：SQL Where条件
	 *@param  $whereRes：查询字段
	 *@param  $whereOrder：查询排序归类
	 *@param  $whereSort：查询排序方法
	 *@apram  $whereCount：查询返回条数
	 *@return array 数据库查询数据
	 */
	public function find($where = null, $whereRes = null, $whereOrder = null, $whereSort = null, $whereCount = null)
	{
		if (!empty($whereRes)) {
			if (is_string($whereRes)) {
				$sql = 'SELECT `'.$whereRes.'` FROM '.$this->_db_table;
			} elseif (is_array($whereRes)) {
				$sql = 'SELECT `';
				$countKey = 0;
				foreach ($whereRes as $key => $whereResValue) {
					if ($countKey == (count($whereRes)-1)) {
						$sql .= $whereResValue.'`';
					} else {
						$sql .= $whereResValue.'`, `';
					}
					$countKey++;
				}
				$sql .= ' FROM '.$this->_db_table;
			} else {
				throw new Van_Exception('参数：'.$whereRes." 不是string或array");
			}
		} else {
			$sql = 'SELECT * FROM '.$this->_db_table;
		}

		if (!empty($where) && is_string($where)) {
			$sql = $sql.' WHERE '.$where;
		}

		if (!empty($whereOrder)) {
			$sql = $sql.' '.strtoupper($whereOrder);
		}

		if (!empty($whereSort) && !empty($whereOrder)) {
			if (('desc' == strtolower($whereSort)) || ('asc' == strtolower($whereSort))) {
				$sql = $sql.' '.strtoupper($whereSort);
			}
		}

		if (!empty($whereCount)) {
			$whereCount = (int) $whereCount;
			if (is_int($whereCount)) {
				$sql = $sql.' LIMIT '.$whereCount;
			}
		}

		$findRes = mysql_query($sql, $this->_db_conn);
		if ($findRes) {
			return mysql_fetch_array($findRes);
		} else {
			return false;
		}	
	}

	/**
	 *数据库数据增加
	 *
	 *@param  $data：array 插入数据
	 *@param  bool
	 */
	public function insert($data = null)
	{
		if (!empty($data) && is_array($data)) {
			$sql = 'INSERT INTO '.$this->_db_table.' (';

			$countKey = 0;
			foreach ($data as $key => $value) {
				if ($countKey == (count($data)-1)) {
					$sql .= '`'.$key.'`) ';
				} else {
					$sql .= '`'.$key.'`, ';
				}
				$countKey++;
			}

			$sql .= 'VALUES (';
			$countKey = 0;
			foreach ($data as $key => $value) {
				if ($countKey == (count($data)-1)) {
					$sql .= "'".$value."')";
				} else {
					$sql .= "'".$value."', ";
				}
				$countKey++;
			}

			$insertRes = mysql_query($sql, $this->_db_conn);
			if ($insertRes) {
				return true;
			} else {
				return false;
			}
		} else {
			throw new Van_Exception('参数：'.$data.' 错误');
		}
	}

	/**
	 *数据库数据删除
	 *
	 *@param  $where：SQL删除条件
	 *@param  bool
	 */
	public function delete($where = null)
	{
		if (!empty($where) && is_string($where)) {
			$sql  = 'DELETE FROM '.$this->_db_table;
			$sql .= ' WHERE '.$where;
			$deleteRes = mysql_query($sql, $this->_db_conn);
			if ($deleteRes) {
				return true;
			} else {
				return false;
			}
		} else {
			throw new Van_Exception('参数：'.$where.' 错误');
		}
	}

	/**
	 *数据库数据更新
	 *
	 *@param  $where：SQL更新条件
	 *@param  $set：SQL更新数据
	 *@param  bool
	 */
	public function update($set = null, $where = null)
	{
		if (!empty($set) && is_array($set)) {
			$sql = 'UPDATE '.$this->_db_table.' SET ';
			$countKey = 0;
			foreach ($set as $key => $value) {
				if ($countKey == (count($set)-1)) {
					$sql .= "`".$key."` = '".$value."' WHERE ";
				} else {
					$sql .= "`".$key."` = '".$value."', ";
				}
				$countKey++;
			}
		} else {
			throw new Van_Exception('参数：'.$set.' 错误');
		}

		if (!empty($where) && is_string($where)) {
			$sql .= $where;
		} else {
			throw new Van_Exception('参数：'.$where.' 错误');
		}

		$updateRes = mysql_query($sql, $this->_db_conn);
		if ($updateRes) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 *数据库断开
	 */
	public function __destruct()
	{
		mysql_close($this->_db_conn);
	}
}