<?php
namespace Application;

/**
 * Classe Controller
 * Classe mère de tous les controlleurs
 * @author aggin
 * @since 26/07/2013
 */

class Controller{
	
	/**
	 * Tableau contenant les variables transmises à la vue
	 * @var array
	 */
	protected $view = array();
	
	/**
	 * Flag permettant de savoir si on fait le rendu de la vue ou pas
	 * @var boolean
	 */
	protected $renderView = true;
	
	/**
	 * tableau contenant les paramètres transmis dans la route
	 * @var array
	 */
	protected $routeParam = array();
	
	public function __construct(){
		$this->init();
	}
	
	/**
	 * Fonction init
	 * Permet de centraliser des traitements communs à toutes les actions d'un controller
	 */
	public function init(){}
	
	/**
	 * Fonction hasGetParam
	 * Permet de déterminer si il y a des paramètres transmis en GET
	 * si le paramètre $paramName est transmis permet de savoir si le paramètre a bien été transmis
	 * @param string $paramName
	 * @return boolean
	 */
	public function hasGetParam($paramName = null){
		if(isset($paramName)){
			return isset($_GET[$paramName]);
		}else{
			return count($_GET)>0;
		}

		return false;
	}
	
	/**
	 * Fonction hasRouteParam
	 * Permet de déterminer si il y a des paramètres de route
	 * si le paramètre $paramName est transmis on ne vérifie que si ce paramètre existe
	 * @param string $paramName
	 * @return boolean
	 */
	public function hasRouteParam($paramName = null){
		if(isset($paramName)){
			return isset($this->routeParam[$paramName]);
		}else{
			return count($this->routeParam)>0;
		}
		
		return false;
	}
	
	/******************************************************
	 * Getter / Setter
	 ******************************************************/
	public function getView()
	{
	    return $this->view;
	}

	public function setView($view)
	{
	    $this->view = $view;
	}

	public function getRenderView()
	{
	    return $this->renderView;
	}

	public function setRenderView($renderView)
	{
	    $this->renderView = $renderView;
	}

	public function getRouteParam()
	{
	    return $this->routeParam;
	}

	public function setRouteParam($routeParam)
	{
	    $this->routeParam = $routeParam;
	}
}