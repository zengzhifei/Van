<?php
/**
 *@package         Van_Controller_Base
 *@author          zengzf
 *@since           2016.06.10
 *@version         Van_Controller_Base:0.1
 */

/**引入Controller接口文件*/
require_once 'Van/Controller/Interface/Interface.php';

class Van_Controller_Base implements Van_Controller_Interface
{
	/** 
	 *控制器间跳转
	 *
	 *@param $controllerName：控制器名
	 *@param $actionName：方法名
	 *@param $option：判断是否当前控制器，1：是，0：不是
	 */
	protected function _forward($controllerName,$actionName,$option = null)
	{
		if (empty($controllerName) || empty($actionName)) {
			throw new Van_Exception("缺少参数");
		}

		$methods = get_class_methods($controllerName);
		if (!in_array($actionName, $methods)) {
			throw new Van_Exception("找不到：<b>".$actionName.' </b>方法');
		}
    	
    	if (!$option) {
			$controllerFileName = APPLICATION_PATH.'/controller/'.$controllerName.'Controller.php';
			
			if (file_exists($controllerFileName)) {
				require_once $controllerFileName;
			}

			$controller = new $controllerName;
			$controller->$actionName();
		} elseif (1 === $option) {
			eval("$controllerName::$actionName();");
		}
	}

	/**
	 *控制期内跳转
	 *
	 *@param $controller： 当前控制器名
	 *@param $actionName：方法名
	 *@param $option：是否存在该方法
	 */
	protected function _render($controllerName, $actionName, $option = null)
	{
		if (empty($actionName)) {
			throw new Van_Exception("缺少参数");
		}

		if (1 === $option) {
			eval("$controllerName::$actionName();");
		} else {
			throw new Van_Exception("找不到：<b>".$actionName.' </b>方法');
		}

	}


}