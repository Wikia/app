<?php
namespace Wikia\Purger;

use PHPUnit\Framework\TestCase;
use Wikia\Rabbit\TaskPublisher;
use Wikia\Tasks\AsyncCeleryTask;

class CeleryPurgerTest extends TestCase {

	/** @var CeleryPurger $purger */
	private $purger;

	protected function setUp() {
		parent::setUp();

		/** @var TaskPublisher|\PHPUnit_Framework_MockObject_MockObject $taskPublisher */
		$taskPublisher = $this->getMockForAbstractClass( TaskPublisher::class );
		$this->purger = new CeleryPurger( $taskPublisher );
	}

	public function testShouldRegisterItselfAsTaskProducer() {
		/** @var TaskPublisher|\PHPUnit_Framework_MockObject_MockObject $taskPublisher */
		$taskPublisher = $this->getMockForAbstractClass( TaskPublisher::class );
		$producer = null;

		$taskPublisher->expects( $this->once() )
			->method( 'registerProducer' )
			->with( $this->callback( function ( CeleryPurger $purger ) use ( &$producer )  {
				$producer = $purger;
				return true;
			} ) );

		$purger = new CeleryPurger( $taskPublisher );

		$this->assertSame( $purger, $producer );
	}

	/**
	 * @dataProvider urlProvider
	 *
	 * @param string[] $urls
	 * @param array $expected
	 */
	public function testShouldCreateTasksPerServiceByUrl( array $urls, array $expected ) {
		$count = 0;

		$this->purger->addUrls( $urls );

		/** @var AsyncCeleryTask $task */
		foreach ( $this->purger->getTasks() as $task ) {
			$count++;

			$data = $task->serialize();

			list( $urls, $keys, $service ) = $data['args'];

			$this->assertEquals( $expected[$service], $urls, "Should purge correct set of URLs for service: $service" );
			$this->assertEmpty( $keys, 'Should not purge surrogate keys when none given' );
		}

		$this->assertEquals( count( $expected ), $count, 'Expected to generate task for each service' );
	}

	public function urlProvider() {
		yield [
			[
				'https://starwars.wikia.com/wiki/Darth_Vader',
				'http://community.wikia.com/wiki/Main_Page',
				'https://vignette.wikia.nocookie.net/cardfight/images/d/dc/Gentle_Persuasion.jpg/revision/latest?cb=20150827145148',
				'https://random.fandom.com/wikia.php?controller=MercuryApi',
			],
			[
				'mediawiki' => [ 'https://starwars.wikia.com/wiki/Darth_Vader', 'http://community.wikia.com/wiki/Main_Page', 'https://random.fandom.com/wikia.php?controller=MercuryApi', ],
				'mercury' => [ 'https://random.fandom.com/wikia.php?controller=MercuryApi', ],
				'vignette' => [ 'https://vignette.wikia.nocookie.net/cardfight/images/d/dc/Gentle_Persuasion.jpg/revision/latest?cb=20150827145148', ],
			]
		];
	}

	public function testShouldCreateTaskForServiceByUrlAndSurrogateKey() {
		$inputUrls = [ 'https://starwars.wikia.com/wiki/Darth_Vader' ];

		$this->purger->addUrls( $inputUrls );
		$this->purger->addSurrogateKey( 'test-key' );

		/** @var AsyncCeleryTask $task */
		foreach ( $this->purger->getTasks() as $task ) {
			$data = $task->serialize();

			list( $urls, $keys, $service ) = $data['args'];

			$this->assertEquals( 'mediawiki', $service );
			$this->assertEquals( $inputUrls, $urls, "Should purge correct set of URLs" );
			$this->assertEquals( [ 'test-key' ], $keys, 'Should purge given surrogate key in mediawiki service' );
		}
	}

	public function testShouldCreateNoTasksWhenNoUrlsNorKeysWereGiven() {
		$count = 0;

		foreach ( $this->purger->getTasks() as $task ) {
			$count++;
		}

		$this->assertEquals( 0, $count, 'Should create no tasks when there is nothing to purge' );
	}
}
