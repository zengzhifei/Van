<?php
/**
 *类自动引入基类
 *
 *@package Van_Loader
 *@author  zengzf
 *@since   2016.06.19
 *@version Van_Loader:1.0
 */

/**引入Loader基类文件*/
require_once 'Van/Loader/Base/Loader.php';

class Van_Loader extends Van_Loader_Base
{
	/**
	 *自动注册类
	 *spl_autoload_register();
	 */
	public function __construct()
	{
		spl_autoload_register(array($this,'autoload_models'));
	}

	/**
	 *自动导入所有model类模型
	 *
	 *@param   类名
	 *@return  bool
	 */
	public function autoload_models($modelName)
	{
		$this->_autoload_models($modelName);
	}

	/**
	 *自动包含所有controller类模型
	 *
	 *@param   控制器名
	 *@return  bool
	 */
	public static function autoload_controller($controllerName) 
	{ 
		return self::_autoload_controller($controllerName);
	}

}