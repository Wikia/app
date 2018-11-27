<?php

namespace Wikia\Rabbit;

use PhpAmqpLib\Exception\AMQPExceptionInterface;
use PhpAmqpLib\Message\AMQPMessage;
use Wikia\Logger\Loggable;
use Wikia\Tasks\AsyncTaskList;
use Wikia\Tracer\WikiaTracer;

/**
 * A default task publisher implementation that publishes tasks to RabbitMQ.
 */
class DefaultTaskPublisher implements TaskPublisher {

	use Loggable;

	/** @var ConnectionManager $rabbitConnectionManager */
	private $rabbitConnectionManager;

	/** @var TaskProducer[] $producers task producers registered for publish */
	private $producers = [];

	/** @var AsyncTaskList[] $tasks LIFO queue storing tasks to be published */
	private $tasks = [];

	public function __construct( ConnectionManager $rabbitConnectionManager ) {
		$this->rabbitConnectionManager = $rabbitConnectionManager;

		// Schedule doUpdate() to be executed at the end of the request
		\Hooks::register( 'RestInPeace', [ $this, 'doUpdate' ] );
	}

	/**
	 * Push a task to be queued.
	 * @param AsyncTaskList $task
	 * @return string ID of the task
	 */
	public function pushTask( AsyncTaskList $task ): string {
		$this->tasks[] = $task;

		return $task->getId();
	}

	public function registerProducer( TaskProducer $producer ) {
		$this->producers[] = $producer;
	}

	/**
	 * Publish queued tasks to RabbitMQ.
	 * Called at the end of the request lifecycle.
	 */
	function doUpdate() {
		foreach ( $this->producers as $producer ) {
			foreach ( $producer->getTasks() as $task ) {
				$this->tasks[] = $task;
			}
		}

		// Quit early if there are no tasks to be published
		if ( empty( $this->tasks ) ) {
			return;
		}

		try {
			$channel = $this->rabbitConnectionManager->getChannel( '/' );

			while ( $task = array_pop( $this->tasks ) ) {
				$queue = $task->getQueue()->name();
				$payload = $task->serialize();

				$jsonObject = json_encode( $payload );

				if ( $jsonObject ) {
					$message = new AMQPMessage( $jsonObject, [
						'content_type' => 'application/json',
						'content-encoding' => 'UTF-8',
						'immediate' => false,
						'delivery_mode' => 2, // persistent
						'app_id' => 'mediawiki',
						'correlation_id' => WikiaTracer::instance()->getTraceId(),
					] );

					$channel->batch_basic_publish( $message, '', $queue );

					$this->logPublish( $queue, $payload );
				} else {
					$this->handleJsonError( $payload );
				}
			}

			$channel->publish_batch();
			$channel->wait_for_pending_acks( AsyncTaskList::ACK_WAIT_TIMEOUT_SECONDS );
		} catch ( AMQPExceptionInterface $e ) {
			$this->logError( $e );
		} catch ( \ErrorException $e ) {
			$this->logError( $e );
		}
	}

	private function logError( \Exception $e ) {
		$this->error( 'Failed to publish background task', [
			'exception' => $e,
		] );

		return null;
	}

	private function logPublish( string $queue, array $payload ) {
		$argsJson = json_encode( $payload['args'] );

		$this->info( 'Publishing task of type: ' . $payload['task'], [
			'exception' => new \Exception(),
			'spawn_task_id' => $payload['id'],
			'spawn_task_type' => $payload['task'],
			'spawn_task_work_id' => $payload['kwargs']['work_id'],
			'spawn_task_args' => substr( $argsJson, 0, 3000 ) . ( strlen( $argsJson ) > 3000 ? '...' : '' ),
			'spawn_task_queue' => $queue,
		] );
	}

	private function handleJsonError( array $payload ) {
		if ( json_last_error() !== JSON_ERROR_NONE ) {
			$message = __CLASS__ . ' - ' . json_last_error_msg();
		} else {
			$message = __CLASS__ . ' - No JSON error but empty message found';
		}

		$context = [ 'exception' => new \Exception() ];

		// Extract the task class name from message array
		// Theoretically an AsyncTaskList instance might contain multiple task calls of different classes
		// however this is never the case in practice.
		foreach ( $payload['args'] as $arguments ) {
			foreach ( $arguments['task_list'] as $task ) {
				$context['task'] = $task['class'];
				break;
			}
		}

		$this->error( $message, $context );
	}
}
