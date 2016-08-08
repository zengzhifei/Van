<?php
/**
 *Exception接口
 *
 *@package Van_Exception_Interface
 *@author  zengzf
 *@since   2016.06.12
 *@version Van_Exception_Interface:0.1
 */
interface Van_Exception_Interface
{
	/**
	 *获取错误信息
	 *
	 *@return array['errorFile'=>'','errorLine'=>'','errorMessage'=>,'errorTime'=>'']
	 */
	public function getErrorMessage();

	/**
	 *错误日志记录
	 *
	 *@param  string:log_dir
	 *@param  string:log_name
	 *@return bool
	 */
	public function setErrorMessage($logDir,$logName);
}