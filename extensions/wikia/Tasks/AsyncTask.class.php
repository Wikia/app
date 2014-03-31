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

	/** @var  array list of BaseTask calls */
	protected $classes = [];

	/** @var array list of calls to make */
	protected $calls = [];

	protected $taskType = 'workers.mediawiki.task';

	protected $delay = 0;

	protected $wikiId = 177;

	protected $dedupCheck = true;

	public function __construct() {
	}

	public function prioritize() {
		$this->queue = new PriorityQueue();

		return $this;
	}

	public function add($taskCall) {
		list($task, $callIndex) = $taskCall;
		$classIndex = array_search($task, $this->classes, true);

		if ($classIndex === false) {
			$this->classes []= $task;
			$classIndex = count($this->classes) - 1;
		}

		$this->calls []= [$classIndex, $callIndex];

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

	public function force() {
		$this->dedupCheck = false;

		return $this;
	}

	public function queue() {
		global $wgDevelEnvironment;

		$taskList = [];
		$workId = ['tasks' => [], 'wikiId' => $this->wikiId];

		foreach ($this->classes as $task) {
			/** @var BaseTask $task */
			$serialized = $task->serialize();
			$taskList []= $serialized;
			$workId['tasks'] []= $serialized;
		}

		$id = uniqid('mw-');
		$payload = (object) [
			'id' => $id,
			'task' => $this->taskType,
			'args' => [
				$this->wikiId,
				$this->calls,
				$taskList,
			],
			'kwargs' => (object) [
				'created' => time(),
				'work_id' => sha1(json_encode($workId)),
				'force' => !$this->dedupCheck
			]
		];

		if ($this->delay) {
			$scheduledTime = strtotime($this->delay);
			if ($scheduledTime !== false && $scheduledTime > time()) {
				$payload->eta = gmdate('c', $scheduledTime);
			}
		}

		if (!empty($wgDevelEnvironment) && isset($_SERVER['SERVER_NAME'])) {
			$callbackUrl = preg_replace('/(.*?)\.(.*)/', 'tasks.$2', $_SERVER['SERVER_NAME']);
			$payload->kwargs->runner_url = "http://$callbackUrl";
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

	protected function taskExists($task) {
		return array_search($task, $this->classes);
	}
}