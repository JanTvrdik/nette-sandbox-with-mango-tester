<?php declare(strict_types = 1);

require __DIR__ . '/../vendor/autoload.php';

$configurator = new Nette\Configurator;

// we need to override defaultExtensions because Nette\Configurator registers
// butch of extensions we don't need and that clash with the Mango Tester
$configurator->defaultExtensions = [
	'php' => Nette\DI\Extensions\PhpExtension::class,
	'constants' => Nette\DI\Extensions\ConstantsExtension::class,
	'extensions' => Nette\DI\Extensions\ExtensionsExtension::class,
	'decorator' => Nette\DI\Extensions\DecoratorExtension::class,
	'cache' => [Nette\Bridges\CacheDI\CacheExtension::class, ['%tempDir%']],
	'di' => [Nette\DI\Extensions\DIExtension::class, ['%debugMode%']],
	'database' => [Nette\Bridges\DatabaseDI\DatabaseExtension::class, ['%debugMode%']],
	'tracy' => [Tracy\Bridges\Nette\TracyExtension::class, ['%debugMode%', '%consoleMode%']],
	'inject' => Nette\DI\Extensions\InjectExtension::class,
];

$configurator->setDebugMode(true);
$configurator->setTempDirectory(__DIR__ . '/../temp/tests');

$configurator->createRobotLoader()
	->addDirectory(__DIR__ . '/../app')
	->addDirectory(__DIR__)
	->register();

$configurator->addParameters([
	'appDir' => __DIR__ . '/../app',
	'wwwDir' => __DIR__ . '/../www',
]);

$configurator->addConfig(__DIR__ . '/config/tests.neon');
$configurator->addConfig(__DIR__ . '/config/tests.local.neon');

Tester\Environment::setup();
Tester\Dumper::$maxPathSegments = 32;

return [$configurator, 'createContainer'];
