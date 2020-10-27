<?php
/**
 * AsyncTask
 *
 * <insert description here>
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 */

namespace Wikia\Tasks;

use Wikia\Factory\ServiceFactory;
use Wikia\Rabbit\TaskPublisher;
use Wikia\Tasks\Queues\DeferredInsertsQueue;
use Wikia\Tasks\Queues\DumpsOnDemandQueue;
use Wikia\Tasks\Queues\PriorityQueue;
use Wikia\Tasks\Queues\PurgeQueue;
use Wikia\Tasks\Queues\Queue;
use Wikia\Tasks\Queues\ScheduledMaintenanceQueue;
use Wikia\Tasks\Queues\SMWQueue;
use Wikia\Tasks\Tasks\BaseTask;
use Wikia\Tasks\Queues\CategoryCountsQueue;

class AsyncTaskList {
	/** @const int default wiki city to run tasks in (community) */
	const DEFAULT_WIKI_ID = 177;

	/** which config to grab when figuring out the executor (on the job queue side) */
	const EXECUTOR_APP_NAME = 'mediawiki';

	/** how long we're willing to wait for publishing to finish */
	const ACK_WAIT_TIMEOUT_SECONDS = 0.3;

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

	/** @var int the wiki id to execute the task in */
	protected $wikiId = 0;

	/** @var bool whether or not to perform task deduplication */
	protected $dupCheck = false;

	/** @var array allows us to store information about this specific task */
	protected $workId;

	/** @var string unique ID identifying this task */
	protected $id;

	public function __construct() {
		$this->wikiId = self::DEFAULT_WIKI_ID;
		$this->id = $this->generateId();
	}

	/**
	 * Get the unique ID of this task.
	 * @return string
	 */
	public function getId(): string {
		return $this->id;
	}

	/**
	 * put this task into the priority queue
	 *
	 * @return $this
	 */
	public function prioritize() {
		return $this->setQueue( PriorityQueue::NAME );
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
			case SMWQueue::NAME:
				$queue = new SMWQueue();
				break;
			case PurgeQueue::NAME:
				$queue = new PurgeQueue();
				break;
			case ScheduledMaintenanceQueue::NAME:
				$queue = new ScheduledMaintenanceQueue();
				break;
			case DeferredInsertsQueue::NAME:
				$queue = new DeferredInsertsQueue();
				break;
			case CategoryCountsQueue::NAME:
				$queue = new CategoryCountsQueue();
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
		global $wgWikiaEnvironment, $wgDevDomain;
		$executor = [
			'app' => self::EXECUTOR_APP_NAME,
		];

		if ( $wgWikiaEnvironment != WIKIA_ENV_PROD ) {
			$host = wfGetEffectiveHostname();

			if ( $wgWikiaEnvironment == WIKIA_ENV_DEV && preg_match( '/^dev-(.*?)$/', $host ) ) {
				$executor['runner'] = ["http://tasks.{$wgDevDomain}/proxy.php"];
			} elseif ($wgWikiaEnvironment == WIKIA_ENV_SANDBOX) {
				$executor['runner'] = ["http://appcommunitycentral.{$host}.fandom.com/extensions/wikia/Tasks/proxy/proxy.php"];
			} elseif (in_array($wgWikiaEnvironment, [WIKIA_ENV_PREVIEW, WIKIA_ENV_VERIFY])) {
				$executor['runner'] = ["http://appcommunitycentral.{$wgWikiaEnvironment}.fandom.com/extensions/wikia/Tasks/proxy/proxy.php"];
			}
		}

		return $executor;
	}

	/**
	 * Return a serialized form of this task that can be sent to Celery via RabbitMQ.
	 * @return array
	 */
	public function serialize(): array {
		global $wgUser;

		$this->initializeWorkId();

		if ( $this->createdBy == null ) {
			$this->createdBy( $wgUser );
		}

		$workIdHash = sha1( json_encode( $this->workId ) );

		return [
			'id' => $this->id,
			'task' => $this->taskType,
			'args' => $this->payloadArgs(),
			'kwargs' => [
				'created_ts' => time(),
				'work_id' => $workIdHash,
				'force' => !$this->dupCheck,
				'executor' => $this->getExecutor()
			]
		];
	}

	/**
	 * Schedule this task to be queued at the end of the request.
	 *
	 * @see TaskPublisher
	 * @deprecated just use TaskPublisher directly
	 * @return string the task list's id
	 */
	public function queue() {
		return ServiceFactory::instance()->rabbitFactory()->taskPublisher()->pushTask( $this );
	}

	/**
	 * @return Queue queue this task list will go into
	 */
	public function getQueue(): Queue {
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
	 * Queue a group of AsyncTaskList objects to be sent to the broker
	 *
	 * @param AsyncTaskList[] $taskLists AsyncTaskList objects to insert into the queue
	 * @return string[] list of task ids
	 */
	public static function batch( $taskLists ) {
		$ids = [];

		$publisher = ServiceFactory::instance()->rabbitFactory()->taskPublisher();

		foreach ( $taskLists as $task ) {
			$ids[] = $publisher->pushTask( $task );
		}

		return $ids;
	}
}
