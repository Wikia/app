<?php
namespace Wikia\SwiftSync;

use PHPUnit\Framework\TestCase;
use Wikia\Rabbit\TaskPublisher;

class SwiftSyncTaskProducerTest extends TestCase {

	/** @var SwiftSyncTaskProducer $swiftSyncTaskProducer */
	private $swiftSyncTaskProducer;

	protected function setUp() {
		parent::setUp();

		/** @var TaskPublisher|\PHPUnit_Framework_MockObject_MockObject $taskPublisher */
		$taskPublisher = $this->getMockForAbstractClass( TaskPublisher::class );
		$this->swiftSyncTaskProducer = new SwiftSyncTaskProducer( $taskPublisher );
	}

	public function testShouldRegisterItselfAsTaskProducer() {
		/** @var TaskPublisher|\PHPUnit_Framework_MockObject_MockObject $taskPublisher */
		$taskPublisher = $this->getMockForAbstractClass( TaskPublisher::class );
		$producer = null;

		$taskPublisher->expects( $this->once() )
			->method( 'registerProducer' )
			->with( $this->callback( function ( SwiftSyncTaskProducer $swiftSyncTaskProducer ) use ( &$producer )  {
				$producer = $swiftSyncTaskProducer;
				return true;
			} ) );

		$swiftSyncTaskProducer= new SwiftSyncTaskProducer( $taskPublisher );

		$this->assertSame( $swiftSyncTaskProducer, $producer );
	}

	/**
	 * @dataProvider opsProvider
	 * @param array $operations
	 */
	public function testShouldPassOperationsAsArgument( array $operations ) {
		foreach ( $operations as $operation ) {
			$this->swiftSyncTaskProducer->addOperation( $operation );
		}

		$tasks = $this->swiftSyncTaskProducer->getTasks();

		$this->assertCount( 1, $tasks );

		$data = $tasks[0]->serialize();

		$this->assertCount( 1, $data['args'][0]['task_list'] );
		$this->assertCount( 1, $data['args'][0]['task_list'][0]['calls'] );
		$this->assertEquals( [ 'synchronize', [ $operations ] ], $data['args'][0]['task_list'][0]['calls'][0] );
	}

	public function opsProvider() {
		yield [
			[
				[
					'op' => 'store',
					'dst' => 'mwstore://swift-backend/starwars/images/4/14/Test.png',
					'src' => 'mwstore://swift-backend/starwars/images/4/12/Test2.png',
				],
				[
					'op' => 'delete',
					'dst' => '',
					'src' => 'mwstore://swift-backend/starwars/images/4/12/Test2.png',
				],
			],
		];
	}
}
