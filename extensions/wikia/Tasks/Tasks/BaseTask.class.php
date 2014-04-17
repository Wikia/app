<?php
/**
 * BaseTask
 *
 * <insert description here>
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 */

namespace Wikia\Tasks\Tasks;

use Wikia\Tasks\AsyncTaskList;

abstract class BaseTask {
	protected $calls = [];

	protected $createdBy;

	/**
	 * @return array [$this, order in which this call should be made]
	 * @throws \InvalidArgumentException
	 */
	public function call(/** args. index0=method, indexN=arg */) {
		$args = func_get_args();
		$method = array_shift($args);

		if (!method_exists($this, $method)) {
			throw new \InvalidArgumentException;
		}

		$this->calls []= [$method, $args];

		return [$this, count($this->calls) - 1];
	}

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

	public function getCall($index) {
		if (!isset($this->calls[$index])) {
			throw new \InvalidArgumentException;
		}

		return $this->calls[$index];
	}

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
	 */
	public function log() {

	}

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

	public function serialize() {
		$mirror = new \ReflectionClass($this);
		$result = [
			'class' => get_class($this),
			'calls' => $this->calls,
			'context' => []
		];

		foreach ($mirror->getProperties(\ReflectionProperty::IS_PUBLIC) as $property) {
			$result['@context'][$property->getName()] = $property->getValue($this);
		}

		return $result;
	}

	public function unserialize($properties, $calls) {
		$this->calls = $calls;

		foreach ($properties as $name => $value) {
			$this->$name = $value;
		}
	}
}