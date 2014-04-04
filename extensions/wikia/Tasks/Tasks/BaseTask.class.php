<?php
/**
 * BaseTask
 *
 * <insert description here>
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 */

namespace Wikia\Tasks\Tasks;


abstract class BaseTask {
	protected $calls = [];

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