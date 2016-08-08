<?php
class index extends Van_Controller
{
	public function indexAction() 
	{ 
		$this->assign('title','Van轻量级PHP框架');
		$this->display();	
	}
}