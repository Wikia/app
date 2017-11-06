<?php

abstract class ObjectMocker {

	protected $object = null;
	protected $className = '';

	protected $mockClassName = '';
	protected $mock = null;

	static protected $nextMockId = 1;

	public function __construct( $object ) {
		$this->object = $object;
		$this->className = get_class($object);

		self::$nextMockId++;
	}

	public function begin() {
		if (empty($mockClassName)) {
			$this->createMockClass();
		}
		if (empty($this->mock)) {
			$this->createMockObject();
		}
		return $this->mock;
	}

	public function end() {
		if ($this->mock) {
			$this->destroyMockObject();
		}
	}

	/**
	 * Create the mocking class definition
	 */
	abstract protected function createMockClass();

	/**
	 * Create new instance of the mock class
	 */
	abstract protected function createMockObject();

	/**
	 * Destroy previously created instance of the mock class
	 */
	abstract protected function destroyMockObject();


}