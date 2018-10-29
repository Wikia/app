<?php
namespace Wikia\Tasks;

/**
 * TaskRunner
 *
 * Executes BaseTask methods and determines which jobs run in legacy mode
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 */

use Wikia\Logger\WikiaLogger;
use Wikia\Metrics\Collector;

class TaskRunner {
	// number of seconds required before we notify flower of our job status
	// keep in sync with HTTP request timeout in celery-workers
	const TASK_NOTIFY_TIMEOUT = 120;

	private $taskId;
	private $taskList = [];
	private $results = [];
	private $callOrder;

	private $exception;
	private $startTime;
	private $endTime;
	private $createdAt;

	/**
	 * @param \WebRequest $request
	 * @return self
	 */
	static function newFromRequest( \WebRequest $request ) {
		return new self(
			$request->getInt('wiki_id'),
			$request->getVal('task_id'),
			$request->getVal('task_list'),
			$request->getVal('call_order'),
			$request->getVal('created_by'),
			$request->getVal('created_at')
		);
	}

	private function __construct( int $wikiId, $taskId, $taskList, $callOrder, $createdBy, float $createdAt ) {
		$this->taskId = $taskId;
		$this->callOrder = json_decode( $callOrder, true );
		$taskList = json_decode( $taskList, true );
		$createdBy = json_decode( $createdBy, true );
		$this->createdAt = $createdAt;

		WikiaLogger::instance()->pushContext( [
			'task_id' => $this->taskId
		] );

		// make sure tasks use a dedicated database user
		// port of PLATFORM-2025 change from Maintenance.php
		global $wgLBFactoryConf, $wgDBtasksuser, $wgDBtaskspass;

		if ( isset( $wgLBFactoryConf['serverTemplate'] ) ) {
			$wgLBFactoryConf['serverTemplate']['user'] = $wgDBtasksuser;
			$wgLBFactoryConf['serverTemplate']['password'] = $wgDBtaskspass;

			\LBFactory::destroyInstance();
		}

		foreach ( $taskList as $taskData ) {
			/** @var \Wikia\Tasks\Tasks\BaseTask $task */
			$task = new $taskData['class']();
			$task
				->taskId( $taskId )
				->wikiId( $wikiId )
				->createdBy( $createdBy['id'] );
			$task->unserialize( $taskData['context'], $taskData['calls'] );

			try {
				$task->init();
			} catch ( \Exception $e ) {
				$this->exception = $e;
				break;
			}

			$this->taskList [] = $task;
		}
	}

	function run() {
		global $wgWikiaEnvironment;

		$this->startTime = $this->endTime = microtime( true );
		if ( $this->exception ) {
			$this->results [] = $this->exception;
			return;
		}

		foreach ( $this->callOrder as $callData ) {
			list( $classIndex, $callIndex ) = $callData;

			/** @var \Wikia\Tasks\Tasks\BaseTask $task */
			$task = $this->taskList[$classIndex];
			list( $method, $args ) = $task->getCall( $callIndex );
			foreach ( $args as $i => $arg ) {
				if ( is_array( $arg ) || is_object( $arg ) ) {
					continue;
				}

				if ( preg_match( '/^#([0-9]+)$/', trim( $arg ), $match ) ) {
					if ( !isset( $this->results[$match[1]] ) ) {
						throw new \InvalidArgumentException;
					}

					$args[$i] = $this->results[$match[1]];
				}
			}

			$task_call = sprintf('%s::%s', get_class( $task ) , $method );
			$task_delay = microtime( true ) - $this->createdAt;
			$task_duration = microtime( true );

			WikiaLogger::instance()->pushContext( [ 'task_call' => $task_call ] );

			$result = $task->execute( $method, $args );
			if ( $result instanceof \Exception ) {
				WikiaLogger::instance()->error( 'Exception: ' . $result->getMessage(), [
					'exception' => $result,
				] );
			}
			WikiaLogger::instance()->popContext();

			// push metrics
			$task_duration = microtime( true ) - $task_duration;

			$metrics_labels = [
				'task_call' => $task_call,
				'task_status' => ( $result instanceof \Exception ) ? 'failed' : 'completed',
				'env' => $wgWikiaEnvironment
			];

			// SUS-5855
			Collector::getInstance()
				->addCounter('celery_tasks_total', $metrics_labels, 'Number of Celery tasks executed')
				->addGauge('celery_tasks_duration_seconds', $task_duration, $metrics_labels, 'Time it took to execute the task')
				->addGauge('celery_tasks_delay_seconds', $task_delay, $metrics_labels, 'How long task has waited in the queue before being executed');

			$this->results [] = $result;

			if ( $result instanceof \Exception ) {
				break;
			}
		}

		$this->endTime = microtime( true );

		WikiaLogger::instance()->info( __METHOD__ . '::completed', [
			'took' => $this->runTime(),
			'delay' => microtime( true ) - $this->createdAt,
			'state' => $this->format()->status,
		] );

		// notify Flower about tasks that take longer to execute then
		// HTTP timeout set in celery-workers
		// Flower will first report a failure (due to HTTP timeout), let's update him
		global $wgFlowerUrl;

		if ($this->runTime() > self::TASK_NOTIFY_TIMEOUT) {
			$result = $this->format();

			\Http::post( "{$wgFlowerUrl}/api/task/status/{$this->getTaskId()}", [
				'noProxy' => true,
				'postData' => json_encode( [
					'kwargs' => [
						'completed' => time(),
						'state' => $result->status,
						'result' => ( $result->status == 'success' ? $result->retval : $result->reason ),
					],
				] ),
			] );
		}
	}

	public function runTime() : float {
		return $this->endTime - $this->startTime;
	}

	public function format() {
		$json = (object) [
			'status' => 'success',
		];

		$result = $this->results[count( $this->results ) - 1];
		if ( $result instanceof \Exception ) {
			$json->status = 'failure';
			$json->reason = $result->getMessage();
		} else {
			$json->retval = $result;
		}

		return $json;
	}

	public function getTaskId() : string {
		return $this->taskId;
	}
}
