<?php
//定义应用路径
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

//定义环境路径
 defined('VAN_PATH')
 	|| define('VAN_PATH',realpath(dirname(__FILE__).'/..'));

//包含框架路径
set_include_path(VAN_PATH.'/library');

//引入框架核心文件
require_once 'Van/Van.php';

//创建框架主体
$van = new Van('Config/Config.php');

//运行应用
$van->run();
