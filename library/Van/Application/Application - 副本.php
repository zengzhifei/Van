<?php
/**
 *@package         Van_Application
 *@author          zengzf
 *@since           2016.06.07
 *@version         0.1
 */

/**引入应用主体基类文件*/
require_once 'Van/Application/Base/Application.php';

/**引入应用主体接口文件*/
require_once 'Van/Application/Interface/Interface.php';

class Van_Application extends Van_Application_Base implements Van_Application_Interface
{
	/**
	 *@var 配置文件 
	 */
	protected static $_Config;

	/**
	 *初始操作
	 */
	public function __construct($config = null)
	{	
		/**
		 *初始配置文件
		 */
		if (null !== $config) {
			self::$_Config = $config;
		}

		/**
		 *开启系统错误显示
		 */
		$this->showSystemError();
	}

	/**
	 *获取配置文件数据
	 *
	 *@param  数组键名
	 *@return 对应数组键值
	 */
	public static function Config($key = null) 
	{
		if (empty($key)) {
			return self::$_Config;
		}

		if (array_key_exists($key, self::$_Config)) {
			return self::$_Config[$key];
		}else{
			return false;
		}
	}

	/**
	 *开启系统警告显示
	 */
	public function showSystemError()
	{
		if ('on' !== self::Config('is_showSystemError')) {
			error_reporting(0);
		}
	}

	
}
