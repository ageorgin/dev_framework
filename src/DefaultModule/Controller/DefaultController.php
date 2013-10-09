<?php
namespace DefaultModule\Controller;
use Application\Controller;

class DefaultController extends Controller{
	
	public function init(){
		
	}
	
	public function aboutAction(){
		echo 'ABOUT';
		
		// ne pas utiliser de view twig
		$this->setRenderView(false);
	}
	
	public function getVersionAction(){
		echo 'V 1.0';
	
		// ne pas utiliser de view twig
		$this->setRenderView(false);
	}
	
	public function indexAction(){
		echo 'HOME';
		
		// ne pas utiliser de view twig
		$this->setRenderView(false);
	}
}