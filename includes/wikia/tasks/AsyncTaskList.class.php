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
use PhpAmqpLib\Exception\AMQPExceptionInterface;
use Wikia\Logger\WikiaLogger;
use Wikia\Tasks\Queues\ParsoidPurgePriorityQueue;
use Wikia\Tasks\Queues\ParsoidPurgeQueue;
use Wikia\Tasks\Queues\PriorityQueue;
use Wikia\Tasks\Queues\NlpPipelineQueue;
use Wikia\Tasks\Queues\PurgeQueue;
use Wikia\Tasks\Queues\Queue;
use Wikia\Tasks\Queues\SMWQueue;
use Wikia\Tasks\Tasks\BaseTask;
use Wikia\Tracer\WikiaTracer;

class AsyncTaskList {
	/** @const int default wiki city to run tasks in (community) */
	const DEFAULT_WIKI_ID = 177;

	/** which config to grab when figuring out the executor (on the job queue side) */
	const EXECUTOR_APP_NAME = 'mediawiki';

	/** @var AMQPConnection connection to message broker */
	protected $connection;

	/** @var Queue the queue this task list will go into */
	protected $queue;

	/** @var array list of BaseTask classes needed to execute the task list */
	protected $classes = [];

	/** @var array list of calls to make */
	protected $calls = [];

	/** @var string celery task type */
	protected $taskType = 'celery_workers.external.execute';

	/** @var mixed user id and name of the user executing the task */
	protected $createdBy = null;

	/** @var int how long to delay execution (from now, in seconds) */
	protected $delay = 0;

	/** @var int the wiki id to execute the task in */
	protected $wikiId = 0;

	/** @var bool whether or not to perform task deduplication */
	protected $dupCheck = false;

	/** @var array allows us to store information about this specific task */
	protected $workId;

	public function __construct() {
		$this->wikiId = self::DEFAULT_WIKI_ID;
	}

	/**
	 * put this task into the priority queue
	 *
	 * @return $this
	 */
	public function prioritize() {
		return $this->setPriority( PriorityQueue::NAME );
	}

	/**
	 * tell this task list to use a specific queue
	 *
	 * @param string $queue which queue to add this task list to
	 * @return $this
	 */
	public function setPriority( $queue ) {
		switch ( $queue ) {
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
				break;
			case SMWQueue::NAME:
				$queue = new SMWQueue();
				break;
			case PurgeQueue::NAME:
				$queue = new PurgeQueue();
				break;
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
	public function add( $taskCall ) {
		list( $task, $callIndex ) = $taskCall;
		$classIndex = array_search( $task, $this->classes, true );

		if ( $classIndex === false ) {
			$this->classes [] = $task;
			$classIndex = count( $this->classes ) - 1;
		}

		$this->calls [] = [$classIndex, $callIndex];

		return $this;
	}

	/**
	 * set this task list to run in a wiki's context
	 *
	 * @param int $wikiId
	 * @return $this
	 */
	public function wikiId( $wikiId ) {
		$this->wikiId = $wikiId;

		return $this;
	}

	/**
	 * set this task as being created by a specific user
	 *
	 * @param int|string|\User $createdBy the id, name, or user object
	 * @return $this
	 */
	public function createdBy( $createdBy ) {
		if ( is_int( $createdBy ) ) {
			$user = \User::newFromId( $createdBy );
			$user->load();
		} elseif ( !( $createdBy instanceof \User ) ) {
			$user = \User::newFromName( $createdBy );
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
	public function delay( $time ) {
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
	 * @param string $type
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
		$taskList = [];
		foreach ( $this->classes as $task ) {
			/** @var BaseTask $task */
			$serialized = $task->serialize();
			$taskList [] = $serialized;
			$this->workId['tasks'] [] = $serialized;
		}
		return [[
			'wiki_id' => $this->wikiId,
			'call_order' => $this->calls,
			'task_list' => $taskList,
			'created_by' => $this->createdBy,
			'created_at' => microtime( true ),
			'trace_env' => \Wikia\Tracer\WikiaTracer::instance()->getEnvVariables(),
		]];
	}


	/**
	 * Allows us to determine execution method and runner for a given environment
	 * @return array
	 */
	protected function getExecutor() {
		global $IP, $wgWikiaEnvironment;
		$executor = [
			'app' => self::EXECUTOR_APP_NAME,
		];

		if ( $wgWikiaEnvironment != WIKIA_ENV_PROD ) {
			$host = gethostname();
			$executionMethod = 'http';

			if ( $wgWikiaEnvironment == WIKIA_ENV_DEV && preg_match( '/^dev-(.*?)$/', $host, $matches ) ) {
				$executionRunner = ["http://tasks.{$matches[1]}.wikia-dev.com/proxy.php"];
			} elseif ($wgWikiaEnvironment == WIKIA_ENV_SANDBOX) {
				$executionRunner = ["http://{$host}.community.wikia.com/extensions/wikia/Tasks/proxy/proxy.php"];
			} elseif (in_array($wgWikiaEnvironment, [WIKIA_ENV_PREVIEW, WIKIA_ENV_VERIFY])) {
				$executionRunner = ["http://{$wgWikiaEnvironment}.community.wikia.com/extensions/wikia/Tasks/proxy/proxy.php"];
			} else { // in other environments or when apache isn't available, ssh into this exact node to execute
				$executionMethod = 'remote_shell';
				$executionRunner = [
					$host,
					'php',
					realpath( $IP . '/maintenance/wikia/task_runner.php' ),
				];
			}

			$executor['method'] = $executionMethod;
			$executor['runner'] = $executionRunner;
		}

		return $executor;
	}

	/**
	 * put this task list into the queue
	 *
	 * @param AMQPChannel $channel channel to publish messages to, if part of a batch
	 * @return string the task list's id
	 * @throws AMQPExceptionInterface
	 */
	public function queue( AMQPChannel $channel = null ) {
		global $wgUser;

		$this->initializeWorkId();

		if ( $this->createdBy == null ) {
			$this->createdBy( $wgUser );
		}

		$id = $this->generateId();
		$workIdHash = sha1( json_encode( $this->workId ) );
		$payload = (object) [
			'id' => $id,
			'task' => $this->taskType,
			'args' => $this->payloadArgs(),
			'kwargs' => (object) [
				'created_ts' => time(),
				'work_id' => $workIdHash,
				'force' => !$this->dupCheck,
				'executor' => $this->getExecutor()
			]
		];

		if ( $this->delay ) {
			$scheduledTime = strtotime( $this->delay );
			if ( $scheduledTime !== false && $scheduledTime > time() ) {
				$payload->eta = gmdate( 'c', $scheduledTime );
			}
		}

		$message = new AMQPMessage( json_encode( $payload ), [
			'content_type' => 'application/json',
			'content-encoding' => 'UTF-8',
			'immediate' => false,
			'delivery_mode' => 2, // persistent
			'app_id' => 'mediawiki',
			'correlation_id' => WikiaTracer::instance()->getTraceId(),
		] );

		if ( $channel === null ) {
			$exception = $connection = null;
			try {
				$connection = $this->connection();
				$channel = $connection->channel();
				$channel->basic_publish( $message, '', $this->getQueue()->name() );
			} catch ( AMQPExceptionInterface $e ) {
				$exception = $e;
			}

			if ( $channel !== null ) {
				$channel->close();
			}

			if ( $connection !== null ) {
				$connection->close();
			}

			if ( $exception !== null ) {
				WikiaLogger::instance()->error( 'AsyncTaskList::queue', [
					'exception' => $exception
				] );
				return null;
			}
		} else {
			$channel->batch_basic_publish( $message, '', $this->getQueue()->name() );
		}

		$argsJson = json_encode($this->payloadArgs());
		WikiaLogger::instance()->info( 'AsyncTaskList::queue ' . $id, [
			'exception' => new \Exception(),
			'spawn_task_id' => $id,
			'spawn_task_type' => $this->taskType,
			'spawn_task_work_id' => $workIdHash,
			'spawn_task_args' => substr($argsJson,0,3000) . (strlen($argsJson)>3000 ? '...' : ''),
			'spawn_task_queue' => $this->getQueue()->name(),
		]);

		return $id;
	}

	/**
	 * @return AMQPConnection connection to message broker
	 * @throws AMQPExceptionInterface
	 */
	protected function connection() {
		if ( $this->connection == null ) {
			$this->connection = self::getConnection();
		}

		return $this->connection;
	}

	/**
	 * A helper for getting an AMQP connection
	 *
	 * Throws AMQPRuntimeException when task broker is disabled in a cureent environment (PLATFORM-1740)
	 *
	 * @return AMQPConnection connection to message broker
	 * @throws AMQPRuntimeException
	 * @throws AMQPTimeoutException
	 */
	protected static function getConnection() {
		global $wgTaskBroker;

		if ( empty( $wgTaskBroker ) ) {
			throw new AMQPRuntimeException( 'Task broker is disabled' );
		}

		return new AMQPConnection( $wgTaskBroker['host'], $wgTaskBroker['port'], $wgTaskBroker['user'], $wgTaskBroker['pass'] );
	}

	/**
	 * @return Queue queue this task list will go into
	 */
	protected function getQueue() {
		if ( $this->queue == null ) {
			global $wgEnableSemanticMediaWikiExt;

			if ( $wgEnableSemanticMediaWikiExt ) {
				$queue = new SMWQueue();
			} else {
				$queue = new Queue();
			}
		} else {
			$queue = $this->queue;
		}

		return $queue;
	}

	private function generateId() {
		return sprintf(
			'mw-%04X%04X-%04X-%04X-%04X-%04X%04X%04X',
			mt_rand( 0, 65535 ), mt_rand( 0, 65535 ), mt_rand( 0, 65535 ), mt_rand( 16384, 20479 ), mt_rand( 32768, 49151 ),
			mt_rand( 0, 65535 ), mt_rand( 0, 65535 ), mt_rand( 0, 65535 )
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
	public static function batch( $taskLists ) {
		$logError = function( \Exception $e ) {
			WikiaLogger::instance()->error( 'AsyncTaskList::batch', [
				'exception' => $e,
				'caller' => wfGetCallerClassMethod( [ __CLASS__, 'Wikia\\Tasks\\Tasks\\BaseTask' ] ),
			] );

			return null;
		};

		try {
			$connection = self::getConnection();
		} catch ( AMQPExceptionInterface $e ) {
			return $logError( $e );
		}

		$channel = $connection->channel();
		$exception = null;
		$ids = [];

		foreach ( $taskLists as $task ) {
			/** @var AsyncTaskList $task */
			$ids [] = $task->queue( $channel );
		}

		try {
			$channel->publish_batch();
		} catch ( AMQPExceptionInterface $e ) {
			$exception = $e;
		}

		if ( $exception !== null ) {
			return $logError( $exception );
		}

		return $ids;
	}
}
