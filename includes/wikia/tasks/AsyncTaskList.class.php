<?php
/**
 * AsyncTask
 *
 * <insert description here>
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 */

namespace Wikia\Tasks;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPConnection;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Exception\AMQPRuntimeException;
use PhpAmqpLib\Exception\AMQPTimeoutException;
use Wikia\Logger\WikiaLogger;
use Wikia\Tasks\Queues\ParsoidPurgePriorityQueue;
use Wikia\Tasks\Queues\ParsoidPurgeQueue;
use Wikia\Tasks\Queues\PriorityQueue;
use Wikia\Tasks\Queues\NlpPipelineQueue;
use Wikia\Tasks\Queues\Queue;
use Wikia\Tasks\Tasks\BaseTask;

class AsyncTaskList {
	/** @var AMQPConnection connection to message broker */
	protected $connection;

	/** @var Queue the queue this task list will go into */
	protected $queue;

	/** @var array list of BaseTask classes needed to execute the task list */
	protected $classes = [];

	/** @var array list of calls to make */
	protected $calls = [];

	/** @var string celery task type */
	protected $taskType = 'celery_workers.mediawiki.task';

	/** @var mixed user id and name of the user executing the task */
	protected $createdBy = null;

	/** @var int how long to delay execution (from now, in seconds) */
	protected $delay = 0;

	/** @var int the wiki id to execute the task in */
	protected $wikiId = 177;

	/** @var bool whether or not to perform task deduplication */
	protected $dupCheck = false;

	/** @var array allows us to store information about this specific task */
	protected $workId;

	/**
	 * put this task into the priority queue
	 *
	 * @return $this
	 */
	public function prioritize() {
		return $this->setPriority(PriorityQueue::NAME);
	}

	/**
	 * tell this task list to use a specific queue
	 *
	 * @param string $queue which queue to add this task list to
	 * @return $this
	 */
	public function setPriority($queue) {
		switch ($queue) {
			case PriorityQueue::NAME:
				$queue = new PriorityQueue();
				break;
			case ParsoidPurgeQueue::NAME:
				$queue = new ParsoidPurgeQueue();
				break;
			case ParsoidPurgePriorityQueue::NAME:
				$queue = new ParsoidPurgePriorityQueue();
				break;
			case NlpPipelineQueue::NAME:
				$queue = new NlpPipelineQueue();
			default:
				$queue = new Queue();
				break;
		}

		$this->queue = $queue;
		return $this;
	}

	/**
	 * add a task call to the task list
	 *
	 * @param array $taskCall result from calling BaseTask->call()
	 * @return $this
	 */
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

	/**
	 * set this task list to run in a wiki's context
	 *
	 * @param int $wikiId
	 * @return $this
	 */
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

	/**
	 * set this task to execute sometime in the future instead of ASAP
	 *
	 * @param string $time any format supported by strtotime()
	 * @return $this
	 * @link http://php.net/strtotime
	 */
	public function delay($time) {
		$this->delay = $time;

		return $this;
	}

	/**
	 * enable task de-duplication check
	 *
	 * @return $this
	 */
	public function dupCheck() {
		$this->dupCheck = true;

		return $this;
	}

	/**
	 * Lets us set the task type so that we can use other tasks in celery-workers lib
	 * @param str $type
	 * @return $this
	 */
	public function taskType( $type ) {
		$this->taskType = $type;
		return $this;
	}

	/**
	 * Initializes the data we're using to identify a set of tasks so we can reuse the runner without leaky state
	 * @return $this
	 */
	protected function initializeWorkId() {
		$this->workId = ['tasks' => [], 'wikiId' => $this->wikiId];
		return $this;
	}

	/**
	 * Returns the "args" value of the payload. Required in base class to valuate work id
	 * @return array
	 */
	protected function payloadArgs() {
		foreach ($this->classes as $task) {
			/** @var BaseTask $task */
			$serialized = $task->serialize();
			$taskList []= $serialized;
			$this->workId['tasks'] []= $serialized;
		}
		return [
				$this->wikiId,
				$this->calls,
				$taskList,
			];
	}


	/**
	 * Allows us to determine execution method and runner for a given environment
	 * @return array
	 */
	protected function getExecutor() {
		global $wgDevelEnvironment, $IP, $wgPreviewHostname, $wgVerifyHostname;
		$executor = [];
		$hostname = gethostname();
		if (!empty($wgDevelEnvironment)) {
			if (isset($_SERVER['SERVER_NAME'])) {
				$executionMethod = 'http';
				$executionRunner = preg_replace('/(.*?)\.(.*)/', 'http://tasks.$2/proxy.php', $_SERVER['SERVER_NAME']);
			} else {
				$executionMethod = 'remote_shell';
				$executionRunner = [
					$hostname,
					realpath( $IP . '/maintenance/wikia/task_runner.php'),
				];
			}

			$executor = [
				'method' => $executionMethod,
				'runner' => is_array($executionRunner) ? $executionRunner : [$executionRunner],
			];
		} elseif (in_array($hostname, [$wgPreviewHostname, $wgVerifyHostname])) { // force preview/verify to run on preview/verify server
			$executor = [
				'method' => 'remote_shell',
				'runner' => [
					$hostname,
					realpath( $IP . '/maintenance/wikia/task_runner.php'),
				],
			];
		}
		return $executor;
	}

	/**
	 * put this task list into the queue
	 *
	 * @param AMQPChannel $channel channel to publish messages to, if part of a batch
	 * @return string the task list's id
	 * @throws \PhpAmqpLib\Exception\AMQPRuntimeException
	 * @throws \PhpAmqpLib\Exception\AMQPTimeoutException
	 */
	public function queue(AMQPChannel $channel=null) {
		global $wgUser;

		if ($this->createdBy == null) {
			$this->createdBy($wgUser);
		}

		$taskList = [];

		$id = $this->generateId();
		$payload = (object) [
			'id' => $id,
			'task' => $this->taskType,
			'args' => $this->payloadArgs(),
			'kwargs' => (object) [
				'created_ts' => time(),
				'created_by' => $this->createdBy,
				'work_id' => sha1(json_encode($workId)),
				'force' => !$this->dupCheck,
				'executor' => $this->getExecutor()
			]
		];

		if ($this->delay) {
			$scheduledTime = strtotime($this->delay);
			if ($scheduledTime !== false && $scheduledTime > time()) {
				$payload->eta = gmdate('c', $scheduledTime);
			}
		}		

		$message = new AMQPMessage(json_encode($payload), [
			'content_type' => 'application/json',
			'content-encoding' => 'UTF-8',
			'immediate' => false,
			'delivery_mode' => 2, // persistent
		]);

		if ($channel === null) {
			$exception = null;
			$connection = $this->connection();
			$channel = $connection->channel();
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
		} else {
			$channel->batch_basic_publish($message, '', $this->getQueue()->name());
		}

		return $id;
	}

	/**
	 * @return AMQPConnection connection to message broker
	 */
	protected function connection() {
		global $wgTaskBroker;

		if ($this->connection == null) {
			$this->connection = new AMQPConnection($wgTaskBroker['host'], $wgTaskBroker['port'], $wgTaskBroker['user'], $wgTaskBroker['pass']);
		}

		return $this->connection;
	}

	/**
	 * @return Queue queue this task list will go into
	 */
	protected function getQueue() {
		return $this->queue == null ? new Queue() : $this->queue;
	}

	private function generateId() {
		return sprintf(
			'mw-%04X%04X-%04X-%04X-%04X-%04X%04X%04X',
			mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151),
			mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535)
		);
	}

	/**
	 * send a group of AsyncTaskList objects to the broker
	 *
	 * @param array $taskLists AsyncTaskList objects to insert into the queue
	 * @return array list of task ids
	 * @throws \PhpAmqpLib\Exception\AMQPRuntimeException
	 * @throws \PhpAmqpLib\Exception\AMQPTimeoutException
	 */
	public static function batch($taskLists) {
		global $wgTaskBroker;

		$connection = new AMQPConnection($wgTaskBroker['host'], $wgTaskBroker['port'], $wgTaskBroker['user'], $wgTaskBroker['pass']);
		$channel = $connection->channel();
		$exception = null;
		$ids = [];

		foreach ($taskLists as $task) {
			/** @var AsyncTaskList $task */
			$ids []= $task->queue($channel);
		}

		try {
			$channel->publish_batch();
		} catch (AMQPRuntimeException $e) {
			$exception = $e;
		} catch (AMQPTimeoutException $e) {
			$exception = $e;
		}

		if ($exception !== null) {
			WikiaLogger::instance()->error("Failed to queue task group");
			throw $exception;
		}

		return $ids;
	}
}
