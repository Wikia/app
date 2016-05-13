<?php
/**
 * TaskRunner
 *
 * Executes BaseTask methods and determines which jobs run in legacy mode
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 */

use Wikia\Logger\WikiaLogger;

class TaskRunner {
	const TASK_NOTIFY_TIMEOUT = 120; // number of seconds required before we notify flower of our job status

	private $taskId;
	private $taskList = [];
	private $results = [];
	private $callOrder;

	private $exception;
	private $startTime;
	private $endTime;

	function __construct( $wikiId, $taskId, $taskList, $callOrder, $createdBy ) {
		$this->taskId = $taskId;
		$this->callOrder = json_decode( $callOrder, true );
		$taskList = json_decode( $taskList, true );
		$createdBy = json_decode( $createdBy, true );

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
			} catch ( Exception $e ) {
				$this->exception = $e;
				break;
			}

			$this->taskList [] = $task;
		}
	}

	function run() {
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
						throw new InvalidArgumentException;
					}

					$args[$i] = $this->results[$match[1]];
				}
			}

			WikiaLogger::instance()->pushContext( [ 'task_call' => get_class($task)."::{$method}"] );
			$result = $task->execute( $method, $args );
			if ( $result instanceof Exception ) {
				WikiaLogger::instance()->error( 'Exception: ' . $result->getMessage(), [
					'exception' => $result,
				] );
			}
			WikiaLogger::instance()->popContext();
			$this->results [] = $result;

			if ( $result instanceof Exception ) {
				break;
			}
		}

		$this->endTime = microtime( true );
	}

	/**
	 * @return float
	 */
	public function runTime() {
		return $this->endTime - $this->startTime;
	}

	public function format() {
		$json = (object) [
			'status' => 'success',
		];

		$result = $this->results[count( $this->results ) - 1];
		if ( $result instanceof Exception ) {
			$json->status = 'failure';
			$json->reason = $result->getMessage();
		} else {
			$json->retval = $result;
		}

		return $json;
	}
}
