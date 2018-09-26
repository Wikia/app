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
use PhpAmqpLib\Connection\AbstractConnection;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Exception\AMQPTimeoutException;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Exception\AMQPRuntimeException;
use PhpAmqpLib\Exception\AMQPExceptionInterface;
use Wikia\Logger\WikiaLogger;
use Wikia\Tasks\Queues\DumpsOnDemandQueue;
use Wikia\Tasks\Queues\ParsoidPurgePriorityQueue;
use Wikia\Tasks\Queues\ParsoidPurgeQueue;
use Wikia\Tasks\Queues\PriorityQueue;
use Wikia\Tasks\Queues\PurgeQueue;
use Wikia\Tasks\Queues\Queue;
use Wikia\Tasks\Queues\SMWQueue;
use Wikia\Tasks\Queues\ScheduledMaintenanceQueue;
use Wikia\Tasks\Tasks\BaseTask;
use Wikia\Tracer\WikiaTracer;

class AsyncTaskList {
	/** @const int default wiki city to run tasks in (community) */
	const DEFAULT_WIKI_ID = 177;

	/** which config to grab when figuring out the executor (on the job queue side) */
	const EXECUTOR_APP_NAME = 'mediawiki';

	/** how long we're willing to wait for publishing to finish */
	const ACK_WAIT_TIMEOUT_SECONDS = 3;

	/** @var AbstractConnection connection to message broker */
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
	 * @deprecated
	 * @param $queue
	 * @return AsyncTaskList
	 */
	public function setPriority( $queue ) {
		return $this->setQueue( $queue );
	}

	/**
	 * tell this task list to use a specific queue
	 *
	 * @param string $queue which queue to add this task list to
	 * @return $this
	 */
	public function setQueue( $queue ) {
		switch ( $queue ) {
			case DumpsOnDemandQueue::NAME:
				$queue = new DumpsOnDemandQueue();
				break;
			case PriorityQueue::NAME:
				$queue = new PriorityQueue();
				break;
			case ParsoidPurgeQueue::NAME:
				$queue = new ParsoidPurgeQueue();
				break;
			case ParsoidPurgePriorityQueue::NAME:
				$queue = new ParsoidPurgePriorityQueue();
				break;
			case SMWQueue::NAME:
				$queue = new SMWQueue();
				break;
			case PurgeQueue::NAME:
				$queue = new PurgeQueue();
				break;
			case ScheduledMaintenanceQueue::NAME:
				$queue = new ScheduledMaintenanceQueue();
				break;
			default:
				$queue = new Queue( $queue );
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
	 * @param int|int[] $wikiId
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
	 *
	 * If method and runner fields are not set here,
	 * celeryd will use the defaults from /etc/celeryd/celeryd.conf ([mediawiki] section)
	 *
	 * @return array
	 */
	protected function getExecutor() {
		global $wgWikiaEnvironment, $wgDevDomain, $wgProcessTasksOnKubernetes;
		$executor = [
			'app' => self::EXECUTOR_APP_NAME,
		];

		// we want to use k8s on a percentage of all communities, so we need a global value for that percentage
		$percentOfTasksOnKubernetes = \WikiFactory::getVarValueByName("wgPercentOfTasksOnKubernetes", static::DEFAULT_WIKI_ID );
		
		$shouldGoToKubernetes = $wgProcessTasksOnKubernetes
			|| ( $percentOfTasksOnKubernetes && $this->wikiId % 100 < $percentOfTasksOnKubernetes );

		if ( $wgWikiaEnvironment != WIKIA_ENV_PROD ) {
			$host = wfGetEffectiveHostname();

			if ( $wgWikiaEnvironment == WIKIA_ENV_DEV && preg_match( '/^dev-(.*?)$/', $host ) ) {
				$executor['runner'] = ["http://tasks.{$wgDevDomain}/proxy.php"];
			} elseif ($wgWikiaEnvironment == WIKIA_ENV_SANDBOX) {
				$executor['runner'] = ["http://community.{$host}.wikia.com/extensions/wikia/Tasks/proxy/proxy.php"];
			} elseif (in_array($wgWikiaEnvironment, [WIKIA_ENV_PREVIEW, WIKIA_ENV_VERIFY])) {
				$executor['runner'] = ["http://community.{$wgWikiaEnvironment}.wikia.com/extensions/wikia/Tasks/proxy/proxy.php"];
			}
		} elseif ( $shouldGoToKubernetes ) {
			# SUS-5562 use k8s to process task
			$executor['runner'] = ["http://mediawiki-tasks/proxy.php"];
		}

		return $executor;
	}

	/**
	 * put this task list into the queue
	 *
	 * IMPORTANT: The provided channel must be in publish confirm mode
	 *
	 * @param AMQPChannel $channel channel to publish messages to, if part of a batch
	 * @param string $priority which queue to add this task list to
	 * @return string the task list's id
	 * @throws AMQPExceptionInterface
	 */
	public function queue( AMQPChannel $channel = null, $priority = null ) {
		global $wgUser;

		$this->initializeWorkId();

		if ( $this->createdBy == null ) {
			$this->createdBy( $wgUser );
		}

		if ( is_string( $priority ) ) {
			$this->setPriority( $priority );
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
				/*
				 * Allow basic_publish to fail in case the connection is blocked by rabbit, due to insufficient resources.
				 * https://www.rabbitmq.com/alarms.html
				 */
				$channel->confirm_select();
				$channel->basic_publish( $message, '', $this->getQueue()->name() );
				$channel->wait_for_pending_acks(self::ACK_WAIT_TIMEOUT_SECONDS);

				$channel->close();
				$connection->close();
			} catch ( AMQPExceptionInterface $e ) {
				$exception = $e;
			} catch ( \ErrorException $e ) {
				$exception = $e;
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
	 * @return AbstractConnection connection to message broker
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
	 * @return AbstractConnection connection to message broker
	 * @throws AMQPRuntimeException
	 * @throws AMQPTimeoutException
	 */
	protected static function getConnection() {
		global $wgTaskBroker;

		if ( empty( $wgTaskBroker ) ) {
			throw new AMQPRuntimeException( 'Task broker is disabled' );
		}

		return new AMQPStreamConnection( $wgTaskBroker['host'], $wgTaskBroker['port'], $wgTaskBroker['user'], $wgTaskBroker['pass'] );
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
			mt_rand( 0, 65535 ), mt_rand( 0, 65535 ), mt_rand( 0, 65535 ), mt_rand( 16384, 20479 ), mt_rand( 32768, 49151 ),
			mt_rand( 0, 65535 ), mt_rand( 0, 65535 ), mt_rand( 0, 65535 )
		);
	}

	/**
	 * send a group of AsyncTaskList objects to the broker
	 *
	 * @param array $taskLists AsyncTaskList objects to insert into the queue
	 * @param string $priority which queue to add this task list to
	 * @return array list of task ids
	 * @throws \PhpAmqpLib\Exception\AMQPRuntimeException
	 * @throws \PhpAmqpLib\Exception\AMQPTimeoutException
	 */
	public static function batch( $taskLists, $priority = null ) {
		$logError = function( \Exception $e ) {
			WikiaLogger::instance()->error( 'AsyncTaskList::batch', [
				'exception' => $e,
				'caller' => wfGetCallerClassMethod( [ __CLASS__, 'Wikia\\Tasks\\Tasks\\BaseTask' ] ),
			] );

			return null;
		};

		try {
			$connection = self::getConnection();
			$channel = $connection->channel();

			// Allow basic_publish to fail in case the connection is blocked by rabbit, due to insufficient resources.
			// https://www.rabbitmq.com/alarms.html
			$channel->confirm_select();
		} catch ( AMQPExceptionInterface $e ) {
			return $logError( $e );
		} catch ( \ErrorException $e ) {
			return $logError( $e );
		}

		$ids = [];

		foreach ( $taskLists as $task ) {
			/** @var AsyncTaskList $task */
			$ids [] = $task->queue( $channel, $priority );
		}

		try {
			$channel->publish_batch();
			$channel->wait_for_pending_acks(self::ACK_WAIT_TIMEOUT_SECONDS);
		} catch ( AMQPExceptionInterface $e ) {
			return $logError( $e );
		} catch ( \ErrorException $e ) {
			return $logError( $e );
		}

		return $ids;
	}
}
