<?php
/**
 *应用主体基类文件
 *
 *@package         Van_Application_Base
 *@author          zengzf
 *@since           2016.06.30
 *@version         Van_Application_Base:1.0
 */

class Van_Application_Base
{	
	/**
	 *@var 配置文件 
	 */
	protected static $_Config;

	/**
	 *初始化应用
	 */
	public function __construct($config = null)
	{	
		/**
		 *初始配置文件
		 */
		if (null !== $config) {
			self::$_Config = $config;
		}
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
	 *应用主体启动命令
	 */
	public function application_start()
	{	
		$this->check_configs();

		$this->import_vans();
	}

	/**
	 *检测框架异常显示配置
	 */
	protected function check_configs()
	{
		defined('IS_SHOW_EXCEPTION') 
			|| define('IS_SHOW_EXCEPTION', self::Config('is_showException'));

		defined('IS_SHOW_SYSTEM_EXCEPTION') 
			|| define('IS_SHOW_SYSTEM_EXCEPTION', self::Config('is_showSystemException'));
		
	}

	/**
	 *导入应用核心文件
	 */
	protected function import_vans()
	{
		/**
		 *导入异常处理文件
		 */
		require_once 'Van/Exception/Exception.php';

		/**
		 *导入自动注册文件
		 */
		require_once 'Van/Loader/Loader.php';
		$loader = new Van_Loader();

		/**
		 *导入模板编译引擎文件
		 */
		require_once 'Van/View/View.php';

		/**
		 *导入控制器文件
		 */
		require_once 'Van/Controller/Controller.php';

		/**
		 *导入模型文件
		 */
		require_once 'Van/Model/Model.php';

	}
}