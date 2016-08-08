<?php
/**
 *框架核心文件
 *
 *@package Van
 *@author  zengzf
 *@since   2016.06.11
 *@version Van：1.0
 */
class Van{
	/**
	 *定义框架配置文件
	 *
	 *@var $_Config;
	 */
	private $_Config;

	/**
	 *初始化操作
	 */
	public function __construct($options = null) {
		/**
		 *设置编码方式
		 */
		header("Content-type:text/html;charset=utf-8");
		
		/**
		 *导入框架配置文件
		 */
		if (!empty($options) && is_string($options)) {
			$this->_Config = $this->import_config($options);
		}

		/**
		 *导入框架核心文件
		 */
		//$this->import_van();
		require_once 'Van/Application/Application.php';
		$application = new Van_Application($this->_Config);
		$application->application_start();
	}

	/**
	 *导入框架配置文件
	 *@param 配置文件名
	 */
	private function import_config($options)
	{
		$configDir = get_include_path();
		$configFile = $configDir.'/'.$options;

		if (file_exists($configFile) && is_readable($configFile)) {
			return require_once $configFile;
		}
	}

	/**
	 *导入框架核心文件
	 */
	private function import_van()
	{
		/**
		 *引入应用主体文件
		 *Application.php
		 */
		require_once 'Van/Application/Application.php';
		$application = new Van_Application($this->_Config);

		/**
		 *引入异常处理文件
		 *Exception.php
		 */
		require_once 'Van/Exception/Exception.php';

		/**
		 *引入自动自动注册类文件
		 *Loader.php
		 */
		require_once 'Van/Loader/Loader.php';
		$loader = new Van_Loader();

		/**
		 *引入模板文件
		 *View.php
		 */
		require_once 'Van/View/View.php';

		/**
		 *引入控制层文件
		 *Controller.php
		 */
		require_once 'Van/Controller/Controller.php';

		/**
		 *引入模型类文件
		 *Model.php
		 */
		require_once 'Van/Model/Model.php';
	}

	/**
	 *引导至对应控制器和方法
	 */
	public function run() {
		$urlModel = (int) Van_Application::Config('url_model');
		if (0 === $urlModel) {
			$urlController = strtolower(Van_Application::Config('url_controller'));
			$urlAction     = strtolower(Van_Application::Config('url_action'));

			$controller = $_GET[$urlController] ? $_GET[$urlController] : 'index';
			$action     = $_GET[$urlAction] ? $_GET[$urlAction] : 'index';
		} 

		$action = $action.'Action';

		if(Van_Loader::autoload_controller($controller)) {
			$actionArray = get_class_methods($controller);
			if (!in_array($action, $actionArray)) {
				throw new Van_Exception("不存在：".$action." 方法");
			}

			$controllerObj = new $controller;
			$controllerObj->$action();
		}
	}

}
