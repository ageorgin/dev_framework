<?php
namespace Application;

use \Zend\Config\Reader\Ini;
use Application\ControllerManager;
/**
 * Classe permettant de faire rapprochement entre une url et les fichiers PHP effectuant les traitements
 * @author AGE
 * @since	20/05/2011	AGE Ajout d'un test supplémentaire sur l'existence des tableaux de routage
 * @since	26/07/2013	AGE	Utilisation de Zend_Config pour gérer les routes et utilisation de Module\Controller\Action
 * @since	09/09/2013	AGE	Evolution méthode getRequestedUrl retourne "/" au lieu de "" pour la home
 *
**/
class Router{
	
	private $__routeArray;
// 	private $__pathPrefix = "";
	
	public function __construct(){
		// chargement du tableau de routage
		$reader = new \Zend\Config\Reader\Ini();
		$this->__routeArray = $reader->fromFile(APPLICATION_ROOT.'/config/route.ini.php', true);
				
		// chargement du path prefix défini
// 		$conf = Setting::getInstance();
// 		$this->__pathPrefix = $conf->getParam('general', 'path_prefix'); 
	}
	
	/**
	 * Fonction route
	 * Permet de lancer l'exécution de l'action du controller en fonction de l'url demandée 
	 */
	public function route(){
		// initialisation des variables
		//$viewFile = '';
		//$pageFile = '';
		$controllerManager = null;
		$idxUrlPattern = null;	
		
		// on recup�re l'url demand�e
		$requestedUrl = $this->getRequestedUrl($_SERVER['REQUEST_URI']);
				
		/* 
		 * On determine la page PHP a charger
		 * 3 cas possibles :
		 * 	-> l'url existe dans la liste des urls statiques. on inclus la page associ�es
		 *	-> l'url existe dans la liste des urls dynamiques. on inclus la page associ�es
		 *	-> l'url n'existe pas. on charge la page 404
		 */
		if(in_array($requestedUrl, $this->__routeArray['mapping_url_statique']['url_pattern'])){
			foreach($this->__routeArray['mapping_url_statique']['url_pattern'] as $keyUrlpattern => $valUrlPattern){
				if($valUrlPattern == $requestedUrl){
					$idxUrlPattern = $keyUrlpattern;
					break;
				}
			}
			
			if(isset($idxUrlPattern)
				&& array_key_exists($idxUrlPattern, $this->__routeArray['mapping_url_statique']['url_script'])){
				$controllerManager = new ControllerManager($this->__routeArray['mapping_url_statique']['url_script'][$idxUrlPattern]['module'],
															$this->__routeArray['mapping_url_statique']['url_script'][$idxUrlPattern]['controller'],
															$this->__routeArray['mapping_url_statique']['url_script'][$idxUrlPattern]['action']
									);
			}
			
		}else{  // on tente de charger la page depuis les urls dynamiques
			$controllerManager = $this->dynamicUrlExists($requestedUrl);
		}
		
		// on a bien une instance de ControllerManager
		if(isset($controllerManager)){
			$controllerManager->runController();	
		}else{
			throw new \Exception('No Controller class found');
		}
	}
	
	/**
	 * Fonction dynamicUrlExists
	 * permet de déterminer la ccontroller PHP et la vue pour les urls dynamiques définies dans le fichier de routage
	 * @param string $scriptUrl l'url demandée
	 * @return Application\ControllerManager une instance de la classe ControllerManager
	 */
	private function dynamicUrlExists($scriptUrl){
		$ret = null;
		$matches = array();
		
		if(isset($this->__routeArray['mapping_url_dynamique']['url_dynamique_pattern']) && is_array($this->__routeArray['mapping_url_dynamique']['url_dynamique_pattern'])){
			foreach($this->__routeArray['mapping_url_dynamique']['url_dynamique_pattern'] as $urlKey => $urlPattern){
				$regexpUrlPattern = $this->createRegexpFromDynamicUrlPattern($urlPattern);
				if(preg_match($regexpUrlPattern, $scriptUrl, $matches)){
					if(array_key_exists($urlKey, $this->__routeArray['mapping_url_dynamique']['url_dynamique_script'])){
						$ret = new ControllerManager($this->__routeArray['mapping_url_dynamique']['url_dynamique_script'][$urlKey]['module'],
								$this->__routeArray['mapping_url_dynamique']['url_dynamique_script'][$urlKey]['controller'],
								$this->__routeArray['mapping_url_dynamique']['url_dynamique_script'][$urlKey]['action']
						);
						
						$nbMatches = count($matches);
						for($i = 1; $i < $nbMatches; $i++){
							// nom par défaut des paramètres de route : param1, param2, ...., paramX
							$name = 'param'.$i;
							// si on a défini une surcharge des nom par défaut dans la configuration de la route on utilise la surcharge
							if(array_key_exists($name, $this->__routeArray['mapping_url_dynamique']['url_dynamique_script'][$urlKey])){
								$name = $this->__routeArray['mapping_url_dynamique']['url_dynamique_script'][$urlKey][$name];
							}
							$ret->addRouteParam($name, $matches[$i]);
						}
						
						
						break;
					}
				}
			}
		}
		
		return $ret;
	}
	
	/**
	 * Fonction createRegexpFromDynamicUrlPattern
	 * Contruit une expression regulière correcte à partir d'une url dynamique
	 * Permet d'utiliser des pattern d'url simples
	 * 
	 * @param string $urlPattern l'url dynamique
	 * @return string l'expression regulière
	 */
	private function createRegexpFromDynamicUrlPattern($urlPattern){
		$ret = '/^'.str_replace(array('/', '*'), array('\/', '([^\/]*)'), $urlPattern).'$/';
		
		return $ret;
	}
	
	/**
	 * Fonction getRequestedUrl
	 * permet de déterminer la page demandée
	 * @param $requestUri
	 * @return unknown_type
	 */
	private function getRequestedUrl($requestUri){
		$ret = '';
		
		// on isole uniquement la partie URL (suppression des parametres en GET)
		if(strpos($requestUri, '?')){
			$ret = substr($requestUri, 0, strpos($requestUri, '?'));
		}else{
			$ret = $requestUri;
		}
		
		// application du path-prefix
		if(isset($this->__pathPrefix) && $this->__pathPrefix != ''){
			$ret = str_replace($this->__pathPrefix.'/', '', $ret);
		}
		
		// supression du caractère '/' de fin
		if('/' === substr($ret, -1)){
			$ret = substr($ret, 0, strlen($ret) - 1);
		}
		
		// ajout d'un / si $ret est vide --> il s'agit de la home
		if('' === $ret){
			$ret = '/';
		}
		
		return $ret;
	}
}
?>