<?php
/**
 *类自动引入基类
 *
 *@package Van_Loader_Base
 *@author  zengzf
 *@since   2016.06.11
 *@version Van_Loader_Base:1.0
 */

/**引入Application接口文件*/
require_once 'Van/Loader/Interface/Interface.php';

class Van_Loader_Base implements Van_Loader_Interface
{
	/**
	 *自动导入所有model类模型
	 *
	 *@param   类名
	 *@return  bool
	 */
	protected function _autoload_models($modelName) 
	{
		$includeRes = strtolower(Van_Application::Config('include_models'));
		if('on' !== $includeRes){
			return;
		}

		$modelsDir   = Van_Application::Config('models_dir');
		$modelFile  = $modelsDir.'/'.$modelName.'Model.php';

		if(file_exists($modelFile) && is_readable($modelFile)){
			return require_once $modelFile;
		}
	}

	/**
	 *自动包含所有controller类模型
	 *
	 *@param   控制器名
	 *@return  bool
	 */
	protected function _autoload_controller($controllerName) 
	{
		$controllerDir = Van_Application::Config('controller_dir');
		$controllerFile = $controllerDir.'/'.$controllerName.'Controller.php';

		if(file_exists($controllerFile) && is_readable($controllerFile)){
			return require_once $controllerFile;
		}else{
			throw new Van_Exception($controllerName.'控制器不存在','errorMessage');
		}
	}


}