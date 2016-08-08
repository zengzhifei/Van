<?php
/**
 *模板文件类
 *
 *@package Van_View
 *@author  zengzf
 *@since   2016.06.19
 *@version Van_View：0.1
 */

/**
 *引入View基类文件
 */
require_once 'Van/View/Base/View.php';

class Van_View extends Van_View_Base
{
	/**
	 *初始化模板文件配置
	 */	
	public function __construct()
	{
		$viewDir = Van_Application::Config('view_dir');
		$templateName = Van_Application::Config('templates_dir');
		$templateDir  = $viewDir.'/'.$templateName;

		$compileName = Van_Application::Config('compiles_dir');
		$compileDir  = $viewDir.'/'.$compileName;

		parent::__construct($templateDir,$compileDir);
	}

	/**
	 *分配模板变量
	 */
	public function assign($tag, $var)
	{
		$this->_assign($tag, $var);
	}

	/**
	 *分配模板页面
	 */
	public function display($vhtmlName = null)
	{
		if (is_numeric($vhtmlName)) {
			$vhtmlName = (String) $vhtmlName;
		}

		if (is_string($vhtmlName)) {
			$this->_display($vhtmlName);
		}
	}
}