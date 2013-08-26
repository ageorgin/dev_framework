<?php
namespace Application;

/**
 * Classe permettant d'accéder au données de configuration
 * @author AGE
 * @since	26/04/2011 AGE	Ajout du chargement du fichier de configuration en fonction de l'environnement
 * @since	27/04/2011 AGE	Chargement du type d'environnement avec l'instruction getEnv (préconisé par CANAL+) au lieu de $_SERVER
 *
**/
class Setting{
	
	private $__settingArray;
	
	/**
	 * @var object Setting Contient l'instance de la classe en cours
	 * @access private
	 */
	private static $instance;
	
	
/**
	 * Retourne l'instance de la classe ou en créer une et la retourne
	 * 
	 * @return object Setting
	 */
 	public static function getInstance () 
    {
        if (!isset(self::$instance)){
			self::$instance = new Setting();
		}

        return self::$instance;
    }
	
	/**
	 *  Constructeur
	 */
	function __construct(){
		// définition du fichier de configuration a charger en fonction de l'environnement
		$typeEnv = getenv('TYPE_ENVIRONNEMENT');
		if(isset($typeEnv) && $typeEnv != '' && file_exists(APPLICATION_ROOT.'/config/setting_'.strtolower($typeEnv).'.ini.php')){
			$this->__settingArray = parse_ini_file(APPLICATION_ROOT.'/config/setting_'.strtolower($typeEnv).'.ini.php', true);
		}else{
			$this->__settingArray = parse_ini_file(APPLICATION_ROOT.'/config/setting_prod.ini.php', true);
		}
	}
	
	/**
	 * Retourne un paramètre de configuration à partir de son nom et du bloc auquel il appartient
	 * 
	 * @param string $blockName le nom du bloc
	 * @param string $paramName le nom du parmètre
	 * return string la valeur du paramètre
	 */
	public function getParam($blockName, $paramName){
		if(array_key_exists($blockName, $this->__settingArray)){
			if(array_key_exists($paramName, $this->__settingArray[$blockName])){
				return $this->__settingArray[$blockName][$paramName];
			}
		}
		
		return null;
	}
}
?>