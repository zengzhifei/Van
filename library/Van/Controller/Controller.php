<?php
/**
 *@package         Van_Controller
 *@author          zengzf
 *@since           2016.06.10
 *@version         0.1
 */

/**引入Controller基类文件*/
require_once 'Van/Controller/Base/Controller.php';

class Van_Controller extends Van_Controller_Base
{
	/**
	 *模板对象
	 */
	private $van_view;

	/**
	 *初始化模板
	 */
	public function __construct()
	{
		$this->van_view = new Van_View();
	}

	/**
	 *分配模板变量
	 */
	public function assign($tag, $var)
	{
		$this->van_view->assign($tag, $var);
	}

	/**
	 *页面分配
	 *
	 *@param $htmlName：文件名称
	 */
	public function display($vhtmlName = null) 
	{
		if (empty($vhtmlName)) {
			$backtrace = debug_backtrace();
			$functionName = $backtrace[1]['function'];
			$functionName = str_replace('Action', '', $functionName);
			$vhtmlName = $functionName; 
		}

		$this->van_view->display($vhtmlName);
	}

	/** 
	 *控制器间跳转
	 *
	 *@param $controllerName：控制器名
	 *@param $actionName：方法名
	 */
	public function forward($controllerName, $actionName)
	{
		$backtrace = debug_backtrace();
		$className = trim($backtrace[1]['class']);
		$controllerName = trim($controllerName);
		$option = strtolower($controllerName) == strtolower($className) ? 1 : 0;
		
		$this->_forward($controllerName, $actionName, $option);
	}

	/**
	 *控制器内跳转
	 *
	 *@param $actionName：方法名
	 */
	public function render($actionName)
	{
		$backtrace = debug_backtrace();
		$controllerName = $backtrace[1]['class'];
		$methodsArray = get_class_methods($controllerName);
		$actionName = trim($actionName);
		$option = in_array($actionName, $methodsArray) ? 1 : 0;

		$this->_render($controllerName, $actionName, $option);
	}

}