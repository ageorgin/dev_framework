<?php
require_once(__DIR__.'/../Application/bootstrap.php');

use Symfony\Component\Console\Application;
use Application\Command\AddRouteCommand;

$console = new Application();
$console->add(new AddRouteCommand());
$console->run();