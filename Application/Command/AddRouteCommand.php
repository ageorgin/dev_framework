<?php
namespace Application\Command;

/**
 * Classe ajoutant la commande route:add à la console
 * @author AGE
 * @since	06/09/2013
 *
 **/

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class AddRouteCommand extends Command
{
	protected function configure(){
		$this
		->setName('route:add')
		->setDescription('Add new route in '.APPLICATION_ROOT.'/config/route.ini.php');
		;
	}
	
	protected function execute(InputInterface $input, OutputInterface $output){
		// load current route.ini
		$reader = new \Zend\Config\Reader\Ini();
		$route = $reader->fromFile(APPLICATION_ROOT.'/config/route.ini.php', true);
				
		// init dialog Helper
		$dialog = $this->getHelperSet()->get('dialog');
		
		// ask for route type (static | dynamic)
		$typeName = array('static', 'dynamic');
		$routeType = $dialog->askAndValidate(
				$output,
				'Please enter route type ['.implode('|', $typeName).'] (default to static) : ',
				function ($answer) use ($typeName){
					if(!in_array($answer, $typeName)){
						throw new \RuntimeException(
								'Type must be '.implode(' or ', $typeName)
						);
					}
					return $answer;
				},
				false,
				'static'
		);
		
		// ask for route id
		$routeId = $dialog->askAndValidate(
				$output,
				'Please enter ID for the route : ',
				function ($answer) use ($routeType, $route){
					$keyMapping = 'mapping_url_statique';
					$keyPattern = 'url_pattern';
					if('dynamic' == $routeType){
						$keyMapping = 'mapping_url_dynamique';
						$keyPattern = 'url_dynamique_pattern';
					}

					
					if(array_key_exists($answer, $route[$keyMapping][$keyPattern])){
						throw new \RuntimeException(
								'ID "'.$answer.'" already exists please enter another'
						);
					}
					
					return $answer;
				}
		);
		
		// ask for route uri
		$routeUri = $dialog->askAndValidate(
				$output,
				'Please enter uri route : ',
				function ($answer) use ($routeType, $route){
					$keyMapping = 'mapping_url_statique';
					$keyPattern = 'url_pattern';
					if('dynamic' == $routeType){
						$keyMapping = 'mapping_url_dynamique';
						$keyPattern = 'url_dynamique_pattern';
					}
					
					if('static' === $routeType && false !== strpos($answer, '*')){
						throw new \RuntimeException(
								'Uri "'.$answer.'" seems to be dynamic but you choosed static route type. Please enter another'
						);
					}
					
					if(in_array($answer,  $route[$keyMapping][$keyPattern])){
						throw new \RuntimeException(
								'Uri "'.$answer.'" already exists please enter another'
						);
					}
					
					return $answer;
				}
		); 
		
		
		// ask for Module
		$module = $dialog->ask(
				$output,
				'Please enter module name : '
		);
		
		// ask for Controller
		$controller = $dialog->ask(
				$output,
				'Please enter controller name : '
		);
		
		// ask for Action
		$action = $dialog->ask(
				$output,
				'Please enter action method name : '
		);
		
		// add new configuration to route.ini
		if('dynamic' == $routeType){
			$keyMapping = 'mapping_url_dynamique';
			$route[$keyMapping]['url_dynamique_pattern'][$routeId] = $routeUri;
			$route[$keyMapping]['url_dynamique_script'][$routeId]['module'] = ucfirst(strtolower($module));
			$route[$keyMapping]['url_dynamique_script'][$routeId]['controller'] = ucfirst(strtolower($controller));
			$route[$keyMapping]['url_dynamique_script'][$routeId]['action'] = lcfirst($action);
		}else{
			$keyMapping = 'mapping_url_statique';
			$route[$keyMapping]['url_pattern'][$routeId] = $routeUri;
			$route[$keyMapping]['url_script'][$routeId]['module'] = ucfirst(strtolower($module));
			$route[$keyMapping]['url_script'][$routeId]['controller'] = ucfirst(strtolower($controller));
			$route[$keyMapping]['url_script'][$routeId]['action'] = lcfirst($action);
		}
		
		// write configuration to file
		$writer = new \Zend\Config\Writer\Ini();
		$writer->toFile(APPLICATION_ROOT.'/config/route.ini.php', $route);
		
		$output->writeln('Route added with success');
	}
}