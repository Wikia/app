<?php
/**
 * TaskRunner
 *
 * Executes BaseTask methods and determines which jobs run in legacy mode
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 */

class TaskRunner {
	private $taskId;
	private $taskList = [];
	private $results = [];
	private $callOrder;

	private $exception;

	function __construct($taskId, $taskList, $callOrder, $createdBy) {
		$this->taskId = $taskId;
		$this->callOrder = json_decode($callOrder, true);

		$taskList = json_decode($taskList, true);
		foreach ($taskList as $taskData) {
			/** @var \Wikia\Tasks\Tasks\BaseTask $task */
			$task = new $taskData['class']();
			$task->createdBy($createdBy);
			$task->unserialize($taskData['context'], $taskData['calls']);

			try {
				$task->init();
			} catch (Exception $e) {
				$this->exception = $e;
				break;
			}

			$this->taskList []= $task;
		}
	}

	function run() {
		if ($this->exception) {
			$this->results []= $this->exception;
			return;
		}

		foreach ($this->callOrder as $callData) {
			list($classIndex, $callIndex) = $callData;

			/** @var \Wikia\Tasks\Tasks\BaseTask $task */
			$task = $this->taskList[$classIndex];
			list($method, $args) = $task->getCall($callIndex);
			foreach ($args as $i => $arg) {
				if (is_array($arg) || is_object($arg)) {
					continue;
				}

				if (preg_match('/^#([0-9]+)$/', trim($arg), $match)) {
					if (!isset($this->results[$match[1]])) {
						throw new InvalidArgumentException;
					}

					$args[$i] = $this->results[$match[1]];
				}
			}

			$result = $task->execute($method, $args);
			$this->results []= $result;

			if ($result instanceof Exception) {
				break;
			}
		}
	}

	public function format() {
		$json = (object) [
			'status' => 'success',
		];

		$result = $this->results[count($this->results) - 1];
		if ($result instanceof Exception) {
			$json->status = 'failure';
			$json->reason = $result->getMessage();
		} else {
			$json->retval = $result;
		}

		return $json;
	}

	// TODO: remove once we are completely off old job/task systems
	static function isLegacy($taskName) {
		return !self::isModern($taskName);
	}

	static function isModern($taskName) {
		return in_array($taskName, [
			'BloglistDeferredPurgeJob',
			'BlogTask',
			'CreatePdfThumbnailsJob',
//		'CreateWikiLocalJob',
			'ParsoidCacheUpdateJob',
			'UserRollback',
			'UserRename',
		]);
	}
}