<?php
/**
 *异常处理基类
 *
 *@package         Van_Exception_Base
 *@author          zengzf
 *@since           2016.06.07
 *@version         Van_Exception_Base:0.1
 */

/**引入Exception接口文件*/
require_once 'Van/Exception/Interface/Interface.php';

class Van_Exception_Base extends Exception implements Van_Exception_Interface
{
	/**
	 *@var 错误信息
	 */
	protected $errorMessage;

	/**
	 *获取错误信息
	 *
	 *@return string
	 */
	public function getErrorMessage($var = null) {
		if (is_string($var)) {
			$this->errorMessage = $var;
		} elseif (is_array($var)) {
			$this->errorMessage = join(',',$var);
		} else {
			$this->errorMessage = '错误异常';
		}
		$errorMsg = array();
		$errorMsg['errorFile']     = $this->getFile();
		$errorMsg['errorLine']     = $this->getLine();
		$errorMsg['errorMessage']  = $this->errorMessage; 
		$errorMsg['errorTime']     = date('Y-m-d H:i:s',time());
		return $errorMsg;
	}

	/**
	 *记录错误日志
	 *
	 *@return string
	 */
	public function setErrorMessage($logDir,$logName) {
		$logMsg  = '错误文件：'.$this->getFile()."\r\n";
		$logMsg .= '错误行数：'.$this->getLine()."\r\n";
		$logMsg .= '错误信息：'.$this->errorMessage."\r\n";
		$logMsg .= '错误时间：'.date('Y-m-d H:i:s')."\r\n\r\n";

		if (is_string($logDir) && is_string($logName)) {
			$logName = $logDir.'/'.$logName;
		} else {
			return false;
		}
		
		if(!is_dir($logDir)){
			if(mkdir($logDir)){
				chmod($logDir, 0777);
			}
		}

		if(!file_exists($logName) or !is_writable($logName)){
			if(touch($logName)){
				chmod($logName, 0766);
			}
		}

		file_put_contents($logName, $logMsg, FILE_APPEND);
	} 




}