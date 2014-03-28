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

	public function execute($method, $args) {
		if (!method_exists($this, $method)) {
			throw new \InvalidArgumentException;
		}


		try {
			$result = call_user_func_array([$this, $method], $args);
		} catch (\Exception $e) {
			$result = $e;
		}

		return $this->format($result);
	}

	public function getMethod() {
		return $this->method;
	}

	public function serialize() {
		$mirror = new \ReflectionClass($this);
		$result = [
			'@method' => $this->getMethod(),
			'@args' => $this->args,
			'@context' => []
		];

		foreach ($mirror->getProperties(\ReflectionProperty::IS_PUBLIC) as $property) {
			$result['@context'][$property->getName()] = $property->getValue($this);
		}

		return $result;
	}

	public function unserialize($properties) {
		foreach ($properties as $name => $value) {
			$this->$name = $value;
		}
	}

	protected function format($result) {
		$json = (object) [
			'status' => 'success',
		];

		if ($result instanceof \Exception) {
			$json->status = 'failure';
			$json->reason = $result->getMessage();
		} else {
			$json->retval = $result;
		}

		return $json;
	}
}