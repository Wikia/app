<?php
set_time_limit(0);
$options = ['help'];
$optionsWithArgs = [
	'call_order',
	'task_list',
	'created_by',
];
require_once(__DIR__."/../commandLine.inc");

$runner = new TaskRunner($options['task_list'], $options['call_order'], $options['created_by']);
echo json_encode($runner->run()->format());

class TaskRunner {
	private $taskList = [];
	private $results = [];
	private $callOrder;

	function __construct($taskList, $callOrder, $createdBy) {
		$taskList = json_decode($taskList, true);
		$this->callOrder = json_decode($callOrder, true);

		foreach ($taskList as $taskData) {
			/** @var \Wikia\Tasks\Tasks\BaseTask $task */
			$task = new $taskData['class']();
			$task->createdBy($createdBy);
			$task->unserialize($taskData['context'], $taskData['calls']);
			$this->taskList []= $task;
		}
	}

	function run() {
		foreach ($this->callOrder as $callData) {
			list($classIndex, $callIndex) = $callData;

			/** @var \Wikia\Tasks\Tasks\BaseTask $task */
			$task = $this->taskList[$classIndex];
			list($method, $args) = $task->getCall($callIndex);
			foreach ($args as $i => $arg) {
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

		return $this;
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
}