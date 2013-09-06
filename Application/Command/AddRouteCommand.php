<?php
namespace Application\Command;

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
		$route = $reader->fromFile(APPLICATION_ROOT.'/config/test_route.ini.php', true);
				
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
					if('dynamic' == $routeType){
						$keyMapping = 'mapping_url_dynamique';
					}

					
					if(array_key_exists($answer, $route[$keyMapping]['url_pattern'])){
						throw new \RuntimeException(
								'ID "'.$answer.'" already exists please enter another'
						);
					}
					
					return $answer;
				}
		);
		
		// ask for route uri
		
		// ask for Module
		
		// ask for Controller
		
		// ask for Action
		
		$output->writeln($routeType.' # '.ucfirst($routeId));
	}
}