<?php
/**
 * BaseTask
 *
 * provides common functionality for tasks
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 */

namespace Wikia\Tasks\Tasks;

use Wikia\Tasks\AsyncTaskList;
use Wikia\Tasks\PriorityQueue;

abstract class BaseTask {
	/** @var array calls this task will make */
	protected $calls = [];

	/** @var int when running, the user id of the user who is running this task. */
	protected $createdBy;

	/** @var string wrapper for AsyncTaskList->queue() */
	private $queueName = null;

	/** @var int wrapper for AsyncTaskList->wikiId() */
	private $wikiId = null;

	/** @var boolean wrapper for AsyncTaskList->dupCheck() */
	private $dupCheck = false;

	/**
	 * Do any additional work required to restore this class to its previous state. Useful when you want to avoid
	 * inserting large, serialized classes into rabbitmq
	 */
	public function init() {}

	/**
	 * set this task to call a method in this class. the first argument to this method should be the method to execute,
	 * and subsequent arguments are arguments passed to that method. Example: call('add', 2, 3) would call the method
	 * add with 2 and 3 as parameters.
	 *
	 * @return array [$this, order in which this call should be made]
	 * @throws \InvalidArgumentException when the first argument doesn't exist as a method in this class
	 */
	public function call(/** method, arg1, arg2, ...argN */) {
		$args = func_get_args();
		$method = array_shift($args);

		if (!method_exists($this, $method)) {
			throw new \InvalidArgumentException;
		}

		$this->calls []= [$method, $args];

		return [$this, count($this->calls) - 1];
	}

	/**
	 * execute a method in this class
	 *
	 * @param string $method the method to execute
	 * @param array $args arguments to pass to $method
	 * @return \Exception|mixed the results of calling the method with the supplied arguments, or the exception
	 * 	thrown when executing that method
	 * @throws \InvalidArgumentException when the method doesn't exist in this class
	 */
	public function execute($method, $args) {
		if (!method_exists($this, $method)) {
			throw new \InvalidArgumentException;
		}


		try {
			$result = call_user_func_array([$this, $method], $args);
		} catch (\Exception $e) {
			$result = $e;
		}

		return $result;
	}

	/**
	 * get a method call from the calls array
	 *
	 * @param int $index
	 * @return array [method, [args to method]]
	 * @throws \InvalidArgumentException when trying to get an undefined index
	 */
	public function getCall($index) {
		if (!isset($this->calls[$index])) {
			throw new \InvalidArgumentException;
		}

		return $this->calls[$index];
	}

	/**
	 * @return array black list of method names to hide on Special:Tasks
	 */
	public function getAdminNonExecuteables() {
		return ['__construct', 'init'];
	}

	public function createdBy($createdBy=null) {
		if ($createdBy !== null) {
			$this->createdBy = $createdBy;
		}

		return $this->createdBy;
	}

	/**
	 * TODO: link this to the task runner that is currently running, and append to it's log. then return that as part
	 * of retval
	 */
	public function log() {

	}

	/**
	 * convenience method wrapping AsyncTaskList
	 *
	 * @return string the task's id
	 */
	public function queue() {
		$taskList = new AsyncTaskList();

		foreach ($this->calls as $i => $call) {
			$taskList->add([$this, $i]);
		}

		if ($this->wikiId) {
			$taskList->wikiId($this->wikiId);
		}

		if ($this->queueName) {
			$taskList->setPriority($this->queueName);
		}

		if ($this->dupCheck) {
			$taskList->dupCheck();
		}

		return $taskList->queue();
	}

	/**
	 * serialize this class so it can be read by celery
	 *
	 * @return array
	 */
	public function serialize() {
		$mirror = new \ReflectionClass($this);
		$result = [
			'class' => get_class($this),
			'calls' => $this->calls,
			'context' => []
		];

		foreach ($mirror->getProperties() as $property) {
			if ($property->class == 'Wikia\\Tasks\\Tasks\\BaseTask') {
				continue;
			}

			$property->setAccessible(true);
			$value = $property->getValue($this);
			$result['context'][$property->name] = is_object($value) ? serialize($value) : $value;
		}

		return $result;
	}

	/**
	 * unserialize this class's context
	 *
	 * @param $properties
	 * @param $calls
	 */
	public function unserialize($properties, $calls) {
		$mirror = new \ReflectionClass($this);

		$this->calls = $calls;

		foreach ($properties as $name => $value) {
			if ($mirror->hasProperty($name)) {
				$deserialized = @unserialize($value);
				$value = $deserialized === false ? $value : $deserialized;

				$property = $mirror->getProperty($name);
				$property->setAccessible(true);
				$property->setValue($this, $value);
			}
		}
	}

	// following are wrappers that will eventually call the same functions in AsyncTaskList
	public function wikiId($wikiId) {
		$this->wikiId = $wikiId;
		return $this;
	}

	public function prioritize() {
		return $this->setPriority(PriorityQueue::NAME);
	}

	public function setPriority($queueName) {
		$this->queueName = $queueName;
		return $this;
	}

	public function dupCheck() {
		$this->dupCheck = true;
	}
}