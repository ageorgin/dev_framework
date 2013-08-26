<?php
namespace Application;

/**
 * Classe ControllerManager 
 * Pilote l'exécution d'un controller à partir d'une route
 * @author aggin
 * @since 26/07/2013
 */

class ControllerManager{
	/**
	 * Le nom du module
	 * @var string
	 */
	private $moduleName = '';
	
	/**
	 * Le nom du controller
	 * @var string
	 */
	private $controllerName = '';
	
	/**
	 * Le nom de l'action
	 * @var string
	 */
	private $actionName = '';
	
	private $httpParam = array(
							'route' => array(),
							'get' => array(),
							'post' => array()
	);
	
	public function __construct($moduleName, $controllerName, $actionName){
		$this->moduleName = $moduleName;
		$this->controllerName = $controllerName;
		$this->actionName = $actionName;
	}
	
	/**
	 * Fonction runController
	 * Intancie un controller, lance l'exécution de la méthode d'action du controller et lance le rendu du template si il est activé
	 * @throws Exception
	 */
	public function runController(){
		if(!file_exists(__DIR__.'/../src/'.$this->moduleName.'Module/Controller/'.$this->controllerName.'Controller.php')){
			throw new Exception('File '.__DIR__.'/../src/'.$this->moduleName.'Module/Controller/'.$this->controllerName.'Controller.php doesn\'t exists');
		}
		
		// contruction du nom de la classe du controller
		$controllerClass = $this->moduleName.'Module\\Controller\\'.$this->controllerName.'Controller';
		
		// instanciation du controller
		$controllerInstance = new $controllerClass;
		
		// Set des paramètres de route
		$controllerInstance->setRouteParam($this->httpParam['route']);
		
		// exécution de la classe XXXAction du controller
		if(is_callable(array($controllerInstance, $this->actionName.'Action'))){
			$retCall = call_user_func(array($controllerInstance, $this->actionName.'Action'));
		}else{
			throw new \BadMethodCallException('Error while calling "'.$this->actionName.'Action" method on controller "'.$controllerClass.'"');
		}
		
		// le rendu de la vue est activé dans le controller
		if($controllerInstance->getRenderView()){
			$twigLoader = new \Twig_Loader_Filesystem(__DIR__.'/../src/'.$this->moduleName.'Module/views/'.$this->controllerName);
			$twig = new \Twig_Environment($twigLoader);
			
			echo $twig->render($this->actionName.'.html.twig', $controllerInstance->getView());
		}
	}
	
	/**
	 * 
	 * @param unknown $paramType
	 * @param unknown $paramName
	 * @param unknown $paramValue
	 */
	private function addParam($paramType, $paramName, $paramValue){
			$this->httpParam[$paramType][$paramName] = $paramValue;
	}
	
	/**
	 * 
	 * @param unknown $paramName
	 * @param unknown $paramValue
	 */
	public function addRouteParam($paramName, $paramValue){
		$this->addParam('route', $paramName, $paramValue);
	}
	
	/**
	 * 
	 * @param unknown $paramName
	 * @param unknown $paramValue
	 */
	public function addGetParam($paramName, $paramValue){
		$this->addParam('get', $paramName, $paramValue);
	}
	
	/**
	 * 
	 * @param unknown $paramName
	 * @param unknown $paramValue
	 */
	public function addPostParam($paramName, $paramValue){
		$this->addParam('post', $paramName, $paramValue);
	}
}