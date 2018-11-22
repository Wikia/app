<?php
namespace Wikia\Rabbit;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Exception\AMQPExceptionInterface;
use PhpAmqpLib\Message\AMQPMessage;
use PHPUnit\Framework\TestCase;
use Wikia\Tasks\AsyncTaskList;
use Wikia\Tasks\Queues\Queue;
use Wikia\Tasks\Queues\SMWQueue;
use Wikia\Tasks\Tasks\BaseTask;

class TestTask extends BaseTask {
	public function job() {}
}

/**
 * @group Integration
 */
class DefaultTaskPublisherIntegrationTest extends TestCase {

	const TEST_WIKI_ID = 123;
	const OTHER_WIKI_ID = 456;

	const CONSUME_TIMEOUT_SECONDS = 1;

	/** @var ConnectionManager $rabbitConnectionManager */
	private $rabbitConnectionManager;

	/** @var DefaultTaskPublisher $defaultTaskPublisher */
	private $defaultTaskPublisher;

	/** @var AMQPChannel $channel */
	private $channel;

	protected function setUp() {
		parent::setUp();

		$this->rabbitConnectionManager = new ConnectionManager( 'localhost', 5672, 'guest', 'guest' );
		$this->defaultTaskPublisher = new DefaultTaskPublisher( $this->rabbitConnectionManager );

		try {
			$this->channel = $this->rabbitConnectionManager->getChannel( '/' );
			$this->channel->queue_declare( Queue::MAIN_QUEUE_NAME );
			$this->channel->queue_declare( Queue::SMW_QUEUE_NAME );
		} catch ( \ErrorException $connectionErrorException ) {
			$this->markTestSkipped( 'Could not connect to Rabbit. Probably it is not running.' );
		}
	}

	public function testPublishSingleTask() {
		$task = ( new TestTask() )->wikiId( static::TEST_WIKI_ID );
		$task->call( 'job' );

		/** @var AsyncTaskList $list */
		list( $list ) = $task->convertToTaskLists();

		$this->defaultTaskPublisher->pushTask( $list );
		$this->defaultTaskPublisher->doUpdate();

		$consumer = $this->createDeliveryVerifier( $task, $list );

		$this->registerConsumer( Queue::MAIN_QUEUE_NAME, $consumer );
		$this->waitForConsumers();
	}

	public function testPublishTasksToDifferentQueues() {
		$task = ( new TestTask() )->wikiId( static::TEST_WIKI_ID );
		$task->call( 'job' );

		$taskTwo = ( new TestTask() )->wikiId( static::TEST_WIKI_ID );
		$taskTwo->setQueue( SMWQueue::NAME );
		$taskTwo->call( 'job' );

		/** @var AsyncTaskList $list */
		list( $list ) = $task->convertToTaskLists();
		/** @var AsyncTaskList $list */
		list( $listTwo ) = $taskTwo->convertToTaskLists();

		$this->defaultTaskPublisher->pushTask( $list );
		$this->defaultTaskPublisher->pushTask( $listTwo );

		$this->defaultTaskPublisher->doUpdate();

		$consumer = $this->createDeliveryVerifier( $task, $list );
		$smwConsumer = $this->createDeliveryVerifier( $taskTwo, $listTwo );

		$this->registerConsumer( Queue::MAIN_QUEUE_NAME, $consumer );
		$this->registerConsumer( ( new SMWQueue() )->name(), $smwConsumer );

		$this->waitForConsumers();
	}

	public function testPublishSingleTaskForMultipleWikis() {
		$task = ( new TestTask() )->wikiId( [ static::TEST_WIKI_ID, static::OTHER_WIKI_ID ] );
		$task->call( 'job' );

		$lists = $task->convertToTaskLists();

		foreach ( $lists as $list ) {
			$this->defaultTaskPublisher->pushTask( $list );
		}

		$this->defaultTaskPublisher->doUpdate();

		$received = 0;

		// Ack every message and disable consumer after processing two
		$consumer = function ( AMQPMessage $msg ) use ( &$received ) {
			$info = $msg->delivery_info;
			/** @var AMQPChannel $channel */
			$channel = $info['channel'];

			$channel->basic_ack( $info['delivery_tag'] );

			if ( ++$received >= 2 ) {
				$channel->basic_cancel( $info['consumer_tag'] );
			}
		};

		$this->registerConsumer( Queue::MAIN_QUEUE_NAME, $consumer );
		$this->waitForConsumers();

		$this->assertEquals( 2, $received, 'Expected to receive exactly two messages' );
	}

	public function testShouldPublishTaskFromTaskProducer() {
		$task = ( new TestTask() )->wikiId( 123 );
		$task->call( 'job' );

		/** @var AsyncTaskList $list */
		list( $list ) = $task->convertToTaskLists();

		$producer = new class( $list ) implements TaskProducer {

			private $task;

			public function __construct( AsyncTaskList $task ) {
				$this->task = $task;
			}

			public function getTasks() {
				yield $this->task;
			}
		};

		$this->defaultTaskPublisher->registerProducer( $producer );
		$this->defaultTaskPublisher->doUpdate();

		$consumer = $this->createDeliveryVerifier( $task, $list );

		$this->registerConsumer( Queue::MAIN_QUEUE_NAME, $consumer );
		$this->waitForConsumers();
	}

	/**
	 * Create a consumer that verifies the delivery of the given task and then de-registers itself
	 *
	 * @param BaseTask $task
	 * @param AsyncTaskList $list
	 * @return callable
	 */
	private function createDeliveryVerifier( BaseTask $task, AsyncTaskList $list ): callable {
		return function ( AMQPMessage $msg ) use ( $task, $list ) {
			// Disable our test consumer since we were just waiting for this message
			$this->ackMsgDisableConsumer( $msg->delivery_info );

			$this->assertEquals( 'mediawiki', $msg->get( 'app_id' ) );

			$data = json_decode( $msg->body, true );

			$this->assertEquals( $list->getId(), $data['id'] );
			$this->assertEquals( $task->getWikiId(), $data['args'][0]['wiki_id'] );
			$this->assertEquals( get_class( $task ), $data['args'][0]['task_list'][0]['class'] );
		};
	}

	/**
	 * Acknowledge this incoming Rabbit message and de-register the consumer.
	 * @param array $info message delivery info
	 */
	private function ackMsgDisableConsumer( array $info ) {
		/** @var AMQPChannel $channel */
		$channel = $info['channel'];

		$channel->basic_ack( $info['delivery_tag'] );
		$channel->basic_cancel( $info['consumer_tag'] );
	}

	private function registerConsumer( string $queue, callable $consumer ) {
		$this->channel->basic_consume(
			$queue,
			uniqid(),
			false,
			false,
			false,
			false,
			$consumer
		);
	}

	private function waitForConsumers() {
		while ( count( $this->channel->callbacks ) ) {
			$this->channel->wait( null, false, static::CONSUME_TIMEOUT_SECONDS );
		}
	}

	protected function tearDown() {
		parent::tearDown();

		$this->channel->queue_delete( Queue::MAIN_QUEUE_NAME );
		$this->channel->queue_delete( Queue::SMW_QUEUE_NAME );
		$this->rabbitConnectionManager->close();
		$this->channel = null;

		\DeferredUpdates::clearPendingUpdates();
	}
}
