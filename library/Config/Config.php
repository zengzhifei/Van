<?php
/**
 *框架配置
 *@package Config
 */
return $config = array(

	/************************************类导入配置********************************/
	/**
	 *自动引入类开关
	 *'on'：开启(默认)；'off'：关闭
	 */
	'include_models' => 'on',

	/**
	 *类文件目录
	 *默认：models
	 */
	'models_dir'     => APPLICATION_PATH.'/models',

	/**
	 *控制器目录
	 *默认：controller
	 */
	'controller_dir' => APPLICATION_PATH.'/controller',
	
	/*******************************模板路径配置****************************************/
	/**
	 *页面文件路径
	 *默认：view
	 */
	'view_dir'  => APPLICATION_PATH.'/view',

	/**
	 *页面模板文件名称
	 *默认：templates
	 */
	'templates_dir'  => 'templates',

	/**
	 *页面编译文件路径
	 *默认：compiles
	 */
	'compiles_dir'    => 'compiles',

	/*******************************日记记录配置************************************/
	/**
	 *日志记录开关
	 *'on'：开启(默认)；'off'：关闭
	 */
	'is_log'         => 'on',
	
	/**
	 *日志目录
	 */
	'log_dir'        => VAN_PATH.'/public/log',

	/**
	 *日志文件
	 */
	'log_name'       => 'log.txt',

	/*******************************错误显示配置************************************/
	/**
	 *框架错误显示开关
	 *'on'：开启(默认)；'off'：关闭
	 */
	'is_showException'       => 'on',

	/**
	 *系统警告显示开关
	 *'on'：开启(默认)；'off'：关闭
	 */
	'is_showSystemException' => 'on',
	
	/*******************************URL模式配置***************************************/
	/**
	 *URL模式
	 *0：普通模式(默认)；1：pathinfo模式
	 */
	'url_model'        => 0,
	
	/**
	 *普通模式
	 *控制器：默认controller
	 */
	'url_controller'   => 'controller',

	/**
	 *普通模式
	 *方法名：默认action
	 */
	'url_action'       => 'action',

	/******************************DB数据库配置*****************************************/
	
	/**
	 *主机名
	 */
	'db_host'          => 'localhost',

	/**
	 *数据库名
	 */
	'db_name'          => 'sust',

	/**
	 *数据库用户名
	 */
	'db_user'          => 'root',

	/**
	 *数据库密码
	 */
	'db_password'      => '112233',

);