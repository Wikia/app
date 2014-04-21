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

abstract class BaseTask {
	/** @var array calls this task will make */
	protected $calls = [];

	/** @var int when running, the user id of the user who is running this task. */
	protected $createdBy;

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
		return [];
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
	 * @param int|null $wikiId wiki to execute the task on
	 * @param bool $priority whether or not this should go into the priority queue
	 * @param bool $dupCheck whether or not to perform job de-duplication checks
	 * @return string the task's id
	 */
	public function queue($wikiId=null, $priority=false, $dupCheck=true) {
		$taskList = new AsyncTaskList();

		foreach ($this->calls as $i => $call) {
			$taskList->add([$this, $i]);
		}

		if ($wikiId) {
			$taskList->wikiId($wikiId);
		}

		if ($priority) {
			$taskList->prioritize();
		}

		if ($dupCheck) {
			$taskList->force();
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
			$result['context'][$property->name] = $property->getValue($this);
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
				$property = $mirror->getProperty($name);
				$property->setAccessible(true);
				$property->setValue($this, $value);
			}
		}
	}
}