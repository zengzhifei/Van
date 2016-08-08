<?php
/**
 *框架模板编译基类文件
 *
 *@package Van_View_Base
 *@author  zengzf
 *@since   2016.06.11
 *@version Van_View_Base：1.0
 */

/**引入View接口文件*/
require_once 'Van/View/Interface/Interface.php';

class Van_View_Base
{
	/**
	 *@var 模板文件路径
	 */
	private $templateDir;

	/**
	 *@var 编译文件路径
	 */
	private $compileDir;

	/**
	 *@var 左标记
	 */
	private $leftTag  = '<{';

	/**
	 *@var 右标记
	 */
	private $rightTag = '}>';

	/**
	 *@var 模板文件扩展名
	 */
	private $templateExt = '.vhtml';

	/**
	 *@var 编译文件扩展名
	 */
	private $compileExt = '.php';
	
	/**
	 *@var 临时变量
	 */
	private $currentTemp = '';

	/**
	 *@var 输出模板
	 */
	private $outputHtml;

	/**
	 *@var 变量池
	 */
	private $varPool = array();

	/**
	 *初始化设置
	 */
	public function __construct($templateDir, $compileDir, $leftTag = null, $rightTag = null)
	{
		$this->templateDir = $templateDir;
		$this->compileDir  = $compileDir;
		$this->leftTag     = empty($leftTag)  ? $this->leftTag  : $leftTag;
		$this->rightTag    = empty($rightTag) ? $this->rightTag : $rightTag;
	}

	/**
	 *分配变量
	 */
	public function _assign($tag, $var)
	{
		if (!empty($tag) && !empty($var)) {
			$this->varPool[$tag] = $var;	
		}
	}

	/**
	 *获取变量
	 */
	 public function getVar($tag)
	 {
	 	if (array_key_exists($tag, $this->varPool)) {
	 		return $this->varPool[$tag];
	 	}
	 }  
	 
	 /**
	  *编译模板文件
	  */
	 public function compile($templateName = null)
	 {
	 	$templateName = empty($templateName) ? $this->currentTemp : $templateName;

	 	$pattern  = '/'.preg_quote($this->leftTag);
	 	$pattern .= ' *\$([a-zA-Z0-9_]\w*) *';
	 	$pattern .= preg_quote($this->rightTag).'/';

	 	$this->outputHtml = preg_replace($pattern, '<?php echo $this->getVar($1)?>', $this->outputHtml);
		
		$compileFile = $this->compileDir.'/'.md5($templateName).$this->compileExt;
		return file_put_contents($compileFile, $this->outputHtml);	 
	 }

	 /**
	  *分配模板文件
	  */
	 public function _display($templateName = null)
	 {
	 	$templateFile = $this->templateDir.'/'.$templateName.$this->templateExt;
	 	$compileFile  = $this->compileDir.'/'.md5($templateName).$this->compileExt;

	 	if (!file_exists($templateFile)) {
	 		throw new Van_Exception('模板：'.$templateName.' 不存在');
	 	}

	 	if (file_exists($compileFile) && (filemtime($compileFile) >= filemtime($templateFile))) {
	 		include_once $compileFile;
	 	} else {
	 		$this->outputHtml = file_get_contents($templateFile);
	 		if ($this->compile($templateName)) {
	 			include_once $compileFile;
	 		}
	 	}
	 }


}