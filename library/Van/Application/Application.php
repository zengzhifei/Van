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
	public function __construct($config)
	{
		parent::__construct($config);
	}
	
}
