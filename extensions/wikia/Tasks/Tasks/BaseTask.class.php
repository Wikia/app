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
	protected $method;

	protected $args = [];

	public function call(/** args. index0=method, indexN=arg */) {
		$this->args = func_get_args();
		$this->method = array_shift($this->args);

		if (!method_exists($this, $this->method)) {
			throw new \InvalidArgumentException;
		}

		return $this;
	}

	public function execute() {
		// has a body so that not every subclass need override, since this is just a default
	}

	public function getMethod() {
		return $this->method;
	}

	public function serialize() {
		$mirror = new \ReflectionClass($this);
		$result = [
			'@method' => $this->getMethod(),
			'@args' => $this->args,
		];

		foreach ($mirror->getProperties(\ReflectionProperty::IS_PUBLIC) as $property) {
			$result[$property->getName()] = $property->getValue($this);
		}

		return $result;
	}

	public function unserialize($properties) {
		foreach ($properties as $name => $value) {
			$this->$name = $value;
		}
	}
}