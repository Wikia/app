<?php

class ObjectTracer extends ObjectMocker {

	protected $methods = array();
	protected $mockClassProperties = array();
	protected $tracer = null;

	/**
	 * Create new object tracer
	 *
	 * @param object $object Object to be traced
	 * @param array $methods List of method names to be traced
	 */
	public function __construct( $object, $methods ) {
		parent::__construct($object);
		$this->methods = $methods;
		$this->tracer = new ObjectCallTrace();
	}

	/**
	 * (non-PHPdoc)
	 * @see extensions/wikia/EditPageLayout/mocks/ObjectMocker::createMockClass()
	 */
	protected function createMockClass() {
		// Define the mocking class
		// ... start with the constructor and destructor
		$this->mockClassName = $this->className . "_ObjectTracerMock_" . self::$nextMockId;
		$code = <<<EOF
class {$this->mockClassName} extends {$this->className} {
	public function __construct( \$object, \$mocker, \$tracer, \$properties ) {
		\$this->_mock_object = \$object;
		\$this->_mock_mocker = \$mocker;
		\$this->_mock_tracer = \$tracer;
		\$this->_mock_properties = \$properties;

		// Pull object state
		foreach (\$this->_mock_properties as \$property)
			\$this->\$property = \$this->_mock_object->\$property;
	}

	public function __destruct() {
		// Push object state
		foreach (\$this->_mock_properties as \$property)
			\$this->_mock_object->\$property = \$this->\$property;
	}
EOF;

		// ... then create all required method overrides
		foreach ($this->methods as $method => $signature) {
			$code .= <<<EOF
	public function $method($signature) {
		\$args = func_get_args();
		\$traceId = \$this->_mock_tracer->begin('$method',\$args);
		\$retval = call_user_func_array(array('parent','$method'),\$args);
		\$this->_mock_tracer->end(\$traceId);
		return \$retval;
	}
EOF;
		}

		// ... and finally end the class definition
		$code .= <<<EOF
}
EOF;

		// Eval the mock class code
		eval($code);

		// Create the property list
		$this->mockClassProperties = array();
		$classReflection = new ReflectionClass($this->mockClassName);
		$properties = $classReflection->getProperties(ReflectionProperty::IS_PUBLIC | ReflectionProperty::IS_PROTECTED);
		foreach ($properties as $property) {
			$this->mockClassProperties[] = $property->getName();
		}
	}

	/**
	 * (non-PHPdoc)
	 * @see extensions/wikia/EditPageLayout/mocks/ObjectMocker::createMockObject()
	 */
	protected function createMockObject() {
		$mockClassName = $this->mockClassName;
		$this->mock = new $mockClassName($this->object,$this,$this->tracer,$this->mockClassProperties);
	}

	/**
	 * (non-PHPdoc)
	 * @see extensions/wikia/EditPageLayout/mocks/ObjectMocker::destroyMockObject()
	 */
	protected function destroyMockObject() {
		$this->mock->__destruct();
		$this->mock = null;
	}

	/**
	 * Returns the call tree tracing object
	 *
	 * @return ObjectCallTree
	 */
	public function getTracer() {
		return $this->tracer;
	}

}
