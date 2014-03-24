<?php
/**
 * AsyncTask
 *
 * <insert description here>
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 */

namespace Wikia\Tasks;

use PhpAmqpLib\Connection\AMQPConnection;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Exception\AMQPRuntimeException;
use PhpAmqpLib\Exception\AMQPTimeoutException;
use Wikia\Logger\WikiaLogger;
use Wikia\Tasks\Tasks\BaseTask;

class AsyncTask {
	/** @var AMQPConnection connection to message broker */
	protected $connection;

	/** @var  Queue */
	protected $queue;

	/** @var  BaseTask */
	protected $task;

	protected $taskType = 'mediawiki.task';

	protected $delay = 0;

	protected $wikiId = 177;

	public function __construct(BaseTask $task=null) {
		$this->task = $task;
	}

	public function prioritize() {
		$this->queue = new PriorityQueue();

		return $this;
	}

	public function task($task) {
		$this->task = $task;

		return $this;
	}

	public function wikiId($wikiId) {
		$this->wikiId = $wikiId;

		return $this;
	}

	public function delay($time) {
		$this->delay = $time;

		return $this;
	}

	public function run() {
		$serialized = $this->task->serialize();
		$idArgs = array_merge($serialized, [
			'@task' => get_class($this->task).".{$this->task->getMethod()}",
			'@wikiId' => $this->wikiId,
		]);

		ksort($idArgs);

		$id = uniqid('mw-');
		$payload = [
			'id' => $id,
			'task' => $this->taskType,
			'args' => [
				$this->wikiId,
				get_class($this->task),
				(object) $serialized
			],
			'kwargs' => (object) [
				'created' => time(),
				'work_id' => md5(json_encode($idArgs))
			]
		];

		if ($this->delay) {
			$scheduledTime = strtotime($this->delay);
			if ($scheduledTime !== false && $scheduledTime > time()) {
				$payload['eta'] = gmdate('c', $scheduledTime);
			}
		}

		$exception = null;
		$connection = $this->connection();
		$channel = $connection->channel();
		$message = new AMQPMessage(json_encode($payload), [
			'content_type' => 'application/json',
			'content-encoding' => 'UTF-8',
			'immediate' => false,
		]);


		try {
			$channel->basic_publish($message, '', $this->getQueue()->name());
		} catch (AMQPRuntimeException $e) {
			$exception = $e;
		} catch (AMQPTimeoutException $e) {
			$exception = $e;
		}

		$channel->close();
		$connection->close();

		if ($exception !== null) {
			WikiaLogger::instance()->error("Failed to queue task {$this->task}: {$exception->getMessage()}", $this->args);
			throw $exception;
		}

		return $id;
	}

	protected function connection() {
		if ($this->connection == null) { // TODO: read from config
			$this->connection = new AMQPConnection('localhost', 5672, 'guest', 'guest');
		}

		return $this->connection;
	}

	protected function getQueue() {
		return $this->queue == null ? new Queue() : $this->queue;
	}
}