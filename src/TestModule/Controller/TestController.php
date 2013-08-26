<?php
namespace TestModule\Controller;
use Application\Controller;

class TestController extends Controller{
	
	public function init(){
		
	}
	
	public function testAction(){
		$this->view['name'] = 'World';
	}
	
	public function editUserAction(){
		echo 'action editUser';
		
		var_dump($this);
		
		var_dump($this->hasRouteParam('id'));
		
		// ne pas utiliser de view twig
		$this->setRenderView(false);
	}
	
	public function userProfileAction(){
		echo 'action userProfile';
		
		var_dump($this);
		
		// ne pas utiliser de view twig
		$this->setRenderView(false);
	}
}