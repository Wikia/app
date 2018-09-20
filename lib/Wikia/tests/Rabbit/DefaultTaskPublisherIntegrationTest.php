<?php
namespace Wikia\Rabbit;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Exception\AMQPExceptionInterface;
use PhpAmqpLib\Message\AMQPMessage;
use PHPUnit\Framework\TestCase;
use Wikia\Tasks\AsyncTaskList;
use Wikia\Tasks\Queues\Queue;
use Wikia\Tasks\Tasks\BaseTask;

class TestTask extends BaseTask {
	public function job() {}
}

/**
 * @group Integration
 */
class DefaultTaskPublisherIntegrationTest extends TestCase {

	const TEST_WIKI_ID = 123;
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
		} catch ( AMQPExceptionInterface $e ) {
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

		$consumer = function ( AMQPMessage $msg ) use ( $task, $list ) {
			$this->assertEquals( 'mediawiki', $msg->get( 'app_id' ) );

			$data = json_decode( $msg->body, true );

			$this->assertEquals( $list->getId(), $data['id'] );
			$this->assertEquals( $task->getWikiId(), $data['args'][0]['wiki_id'] );
			$this->assertEquals( get_class( $task ), $data['args'][0]['task_list'][0]['class'] );
		};

		$this->channel->basic_consume(
			Queue::MAIN_QUEUE_NAME,
			getmypid(),
			false,
			false,
			false,
			false,
			$consumer
		);

		while ( count( $this->channel->callbacks ) ) {
			$this->channel->wait( null, false, static::CONSUME_TIMEOUT_SECONDS );
		}
	}

	protected function tearDown() {
		parent::tearDown();

		$this->channel->queue_delete( Queue::MAIN_QUEUE_NAME );

		$this->rabbitConnectionManager->close();
		$this->channel = null;
	}
}
