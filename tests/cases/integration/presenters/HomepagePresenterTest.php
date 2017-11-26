<?php declare(strict_types = 1);

namespace AppTests\Presenters;

use Mangoweb\Tester\Infrastructure\TestCase;
use Mangoweb\Tester\PresenterTester\PresenterTester;

$testContainerFactory = require __DIR__ . '/../../../bootstrap.php';


/**
 * @testCase
 */
class HomepagePresenterTest extends TestCase
{
	/** @var PresenterTester */
	private $presenterTester;


	public function __construct(PresenterTester $presenterTester)
	{
		$this->presenterTester = $presenterTester;
	}


	public function testActionDefaultRendersOk()
	{
		$testRequest = $this->presenterTester->createRequest('Homepage');

		$testResponse = $this->presenterTester->execute($testRequest);

		$testResponse->assertRenders([
			'Congratulations!',
			'You have successfully created your Nette Framework project.',
			'We hope you enjoy this framework!',
		]);
	}


	public function testActionFooReturnsNotFound()
	{
		$testRequest = $this->presenterTester->createRequest('Homepage')
			->withParameters(['action' => 'foo']);

		$testResponse = $this->presenterTester->execute($testRequest);

		$testResponse->assertBadRequest(404);
	}
}


HomepagePresenterTest::run($testContainerFactory);
