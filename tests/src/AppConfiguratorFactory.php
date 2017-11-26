<?php declare(strict_types = 1);

namespace AppTests;

use Mangoweb\Tester\DatabaseCreator\DatabaseCreator;
use Mangoweb\Tester\Infrastructure\Container\IAppConfiguratorFactory;
use Nette\Configurator;
use Nette\DI\Container;


class AppConfiguratorFactory implements IAppConfiguratorFactory
{
	/** @var DatabaseCreator */
	private $databaseCreator;


	public function __construct(DatabaseCreator $databaseCreator)
	{
		$this->databaseCreator = $databaseCreator;
	}


	public function create(Container $testContainer): Configurator
	{
		$testDatabaseName = $this->databaseCreator->getDatabaseName();
		$testContainerParameters = $testContainer->getParameters();

		$configurator = new Configurator;
		$configurator->setDebugMode(TRUE);
		$configurator->setTempDirectory($testContainerParameters['tempDir']);

		$configurator->addConfig("$testContainerParameters[appDir]/config/config.neon");
		$configurator->addConfig("$testContainerParameters[appDir]/config/config.local.neon");
		$configurator->addConfig([
			'database' => [
				'dsn' => sprintf('mysql:host=127.0.0.1;dbname=%s', $testDatabaseName),
			],
			'services' => [
				'database.default.connection' => [
					'setup' => [
						new \Nette\DI\Statement('@databaseCreator::createTestDatabase')
					],
				],
			],
		]);

		return $configurator;
	}

}
