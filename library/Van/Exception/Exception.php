<?php
/**
 *Exception异常处理类
 *
 *@package Van_Exception
 *@author  zengzf
 *@since   2016.06.12
 *@version Van_Exception:0.1
 */

/**引入异常处理基类*/
require_once 'Van/Exception/Base/Exception.php';

class Van_Exception extends Van_Exception_Base
{
	/**
	 *@var 错误信息
	 */
	protected $errorMessage;

	/**
	 *@var 可选:string or array
	 *@var 返回指定错误信息
	 */
	protected $errorType;

	/**
	 *定义错误信息
	 *
	 *@param  $var:array or string
	 *@param  $options:array
	 */
	public function __construct($var = null,$options = array()) 
	{
		/**
		 *error异常置顶
		 */
		set_exception_handler(array($this,'getErrorMsg'));

		/**
		 *@param $var
		 */
		if (is_string($var) || is_array($var)) {
			$this->errorMessage = $var;
		} else {
			$this->errorMessage = null;
		}

		/**
		 *@param $options
		 */
		if (is_numeric($options)) {
			$options = (String) $options;
		}
		if (is_string($options) || is_array($options)) {
			$this->errorType = $options;
		} else {
			$this->errorType = null;
		}
	}

	/**
	 *获取错误信息
	 *
	 *@param  array or string
	 *@return errorMsg
	 */
	public function getErrorMsg($vanException)
	{
		if ('on' !== Van_Application::Config('is_showError')) {
			return;
		}

		$errorMessage = $vanException->getErrorMessage($vanException->errorMessage);

		if (empty($vanException->errorType)) {
			$errorMsg  = '错误文件：<b>'.$errorMessage['errorFile'].'</b><br>';
			$errorMsg .= '错误行号：<b>'.$errorMessage['errorLine'].'</b><br>';
			$errorMsg .= '错误信息：<b>'.$errorMessage['errorMessage'].'</b><br>';
			$errorMsg .= '错误时间：<b>'.$errorMessage['errorTime'].'</b><br>';
		} elseif (is_string($vanException->errorType)) {
			if (array_key_exists($vanException->errorType, $errorMessage)) {
				switch ($vanException->errorType) {
					case 'errorFile':
						$errorMsg = '错误文件：<b>'.$errorMessage['errorFile'].'</b>';
						break;
					case 'errorLine':
						$errorMsg = '错误行号：<b>'.$errorMessage['errorLine'].'</b>';
						break;
					case 'errorMessage':
						$errorMsg = '错误信息：<b>'.$errorMessage['errorMessage'].'</b>';
						break;
					case 'errorTime':
						$errorMsg = '错误时间：<b>'.$errorMessage['errorTime'].'</b>';
						break;
					default:
						break;
				}
			} else {
				$errorMsg  = '错误文件：<b>'.$errorMessage['errorFile'].'</b><br>';
				$errorMsg .= '错误行号：<b>'.$errorMessage['errorLine'].'</b><br>';
				$errorMsg .= '错误信息：<b>参数：'.$vanException->errorType.' 未知</b><br>';
				$errorMsg .= '错误时间：<b>'.$errorMessage['errorTime'].'</b><br>';
			}
		} elseif (is_array($vanException->errorType)) {
			$errorMsg = '';
			foreach ($vanException->errorType as $key => $value) {
				if (array_key_exists($value, $errorMessage)) {
					switch ($value) {
						case 'errorFile':
							$errorMsg .= '错误文件：<b>'.$errorMessage['errorFile'].'</b><br>';
							break;
						case 'errorLine':
							$errorMsg .= '错误行号：<b>'.$errorMessage['errorLine'].'</b><br>';
							break;
						case 'errorMessage':
							$errorMsg .= '错误信息：<b>'.$errorMessage['errorMessage'].'</b><br>';
							break;
						case 'errorTime':
							$errorMsg .= '错误时间：<b>'.$errorMessage['errorTime'].'</b><br>';
							break;
						default:
							break;
					}
				} else {
					$errorMsg = '错误文件：<b>'.$errorMessage['errorFile'].'</b><br>';
					$errorMsg .= '错误行号：<b>'.$errorMessage['errorLine'].'</b><br>';
					$errorMsg .= '错误信息：<b>数组键值：'.$value.' 未知</b><br>';
					$errorMsg .= '错误时间：<b>'.$errorMessage['errorTime'].'</b><br>';
				}
			}
		}
		echo $errorMsg;
	}

	/**
	 *错误日志记录
	 *
	 *@param 
	 *@return bool
	 */
	public function setErrorMsg()
	{
		if ('on' !== strtolower(Van_Application::Config('is_log'))) {
			return;
		}
		
		$logDir  = @Van_Application::Config('log_dir');
		$logName = @Van_Application::Config('log_name');

		if (!empty($logDir) && !empty($logName)) {
			$this->setErrorMessage($logDir,$logName);
		} else {
			throw new Van_Exception("日志记录路径错误");
		}	
	}

	/**
	 *错误日志记录
	 */
	public function __destruct()
	{
		$this->setErrorMsg();
	}

}