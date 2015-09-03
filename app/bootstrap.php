<?php
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/others/functions.php';
$configurator = new Nette\Configurator;

$configurator->setDebugMode(true);
$configurator->enableDebugger(__DIR__ . '/../log');

$configurator->setTempDirectory(__DIR__ . '/../temp');

$configurator->createRobotLoader()
	->addDirectory(__DIR__)
	->addDirectory(__DIR__.'/../vendor/others')
	->register();

$configurator->addConfig(__DIR__ . '/config/config.neon');
Tracy\Debugger::getBar()->addPanel(new \Asterix\LogPanel);
\Kdyby\Events\DI\EventsExtension::register($configurator);
$container = $configurator->createContainer();

return $container;
