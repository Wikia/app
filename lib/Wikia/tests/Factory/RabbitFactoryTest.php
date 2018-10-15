<?php
namespace Wikia\Factory;

use PHPUnit\Framework\TestCase;
use Wikia\Rabbit\DefaultTaskPublisher;
use Wikia\Rabbit\NullTaskPublisher;

class RabbitFactoryTest extends TestCase {

	use \MockGlobalVariableTrait;

	/** @var RabbitFactory $rabbitFactory */
	private $rabbitFactory;

	protected function setUp() {
		parent::setUp();

		$this->rabbitFactory = new RabbitFactory( new ServiceFactory() );
	}

	public function testTaskBrokerDisabled() {
		$this->mockGlobalVariable( 'wgTaskBrokerDisabled', true );

		$this->assertInstanceOf( NullTaskPublisher::class, $this->rabbitFactory->taskPublisher() );
	}

	public function testTaskBrokerEnabled() {
		$this->mockGlobalVariable( 'wgTaskBrokerDisabled', false );

		$this->assertInstanceOf( DefaultTaskPublisher::class, $this->rabbitFactory->taskPublisher() );
	}

	protected function tearDown() {
		parent::tearDown();

		$this->unsetGlobals();
	}
}
