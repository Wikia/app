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

class AsyncTaskList {
	/** @var AMQPConnection connection to message broker */
	protected $connection;

	/** @var  Queue */
	protected $queue;

	/** @var  array list of BaseTask calls */
	protected $classes = [];

	/** @var array list of calls to make */
	protected $calls = [];

	protected $taskType = 'workers.mediawiki.task';

	protected $createdBy = null;

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

	/**
	 * set this task as being created by a specific user
	 *
	 * @param int|string|\User $createdBy the id, name, or user object
	 * @return $this
	 */
	public function createdBy($createdBy) {
		if (is_int($createdBy)) {
			$user = \User::newFromId($createdBy);
			$user->load();
		} elseif (!($createdBy instanceof \User)) {
			$user = \User::newFromName($createdBy);
			$user->load();
		} else {
			$user = $createdBy;
		}

		$this->createdBy = (object) [
			'name' => $user->getName(),
			'id' => $user->getId(),
		];

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
		global $wgDevelEnvironment, $wgUser, $IP;

		if ($this->createdBy == null) {
			$this->createdBy($wgUser);
		}

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
				'created_ts' => time(),
				'created_by' => $this->createdBy,
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

		if (!empty($wgDevelEnvironment)) {
			if (isset($_SERVER['SERVER_NAME'])) {
				$executionMethod = 'http';
				$executionRunner = preg_replace('/(.*?)\.(.*)/', 'http://tasks.$2/proxy.php', $_SERVER['SERVER_NAME']);
			} else {
				$executionMethod = 'remote_shell';
				$executionRunner = [
					gethostbyname(gethostname()),
					realpath( $IP . '/maintenance/wikia/task_runner.php'),
				];
			}

			$payload->kwargs->executor = [
				'method' => $executionMethod,
				'runner' => is_array($executionRunner) ? $executionRunner : [$executionRunner],
			];
		}

		$exception = null;
		$connection = $this->connection();
		$channel = $connection->channel();
		$message = new AMQPMessage(json_encode($payload), [
			'content_type' => 'application/json',
			'content-encoding' => 'UTF-8',
			'immediate' => false,
			'delivery_mode' => 2, // persistent
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
			WikiaLogger::instance()->error("Failed to queue task: {$exception->getMessage()}", $payload->args);
			throw $exception;
		}

		return $id;
	}

	protected function connection() {
		global $wgTaskBroker;

		if ($this->connection == null) {
			$this->connection = new AMQPConnection($wgTaskBroker['host'], $wgTaskBroker['port'], $wgTaskBroker['user'], $wgTaskBroker['pass']);
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
