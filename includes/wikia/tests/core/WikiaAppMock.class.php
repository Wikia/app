<?php

/**
 * WikiaAppMock
 *
 * @deprecated
 */
class WikiaAppMock {

	/**
	 * Test case object
	 * @var PHPUnit_Framework_TestCase
	 */
	private $testCase = null;
	private $mock = null;
	private $methods = array();
	private $mockedGlobals = array();
	private $mockedFunctions = array();

	public function __construct( PHPUnit_Framework_TestCase $testCase ) {
		$this->testCase = $testCase;
	}

	public function init($mockedMethods = array()) {
		$wikiaAppArgs = array();

		$globalRegistryMock = null;
		$functionWrapperMock = null;

		$globalRegistryMock = $this->testCase->getMock( 'WikiaGlobalRegistry', array( 'get', 'set' ) );
		$globalRegistryMock->expects( $this->testCase->any() )
			->method( 'get' )
			->will( $this->testCase->returnCallback(array( $this, 'getGlobalCallback')) );

		if( in_array( 'runFunction', $this->methods ) ) {
			$functionWrapperMock = $this->testCase->getMock( 'WikiaFunctionWrapper', array_keys($this->mockedFunctions) );
			foreach( $this->mockedFunctions as $functionName => $functionData ) {
				$mock = $functionWrapperMock->expects( $this->testCase->exactly( $functionData['calls'] ) )
					->method( $functionName )
					->will( $this->testCase->returnValue( $functionData['value'] ) );

				if (!empty($functionData['params'])) {
					call_user_func_array(array($mock, 'with'), $functionData['params']);
				}
			}
		}
		$wikiaAppArgs[] = $globalRegistryMock;
		$wikiaAppArgs[] = null; // WikiaLocalRegistry
		$wikiaAppArgs[] = null; // WikiaHookDispatcher
		$wikiaAppArgs[] = $functionWrapperMock;

		$mockedMethods[] = 'ajax'; /* we just have to have something to prevent mocking everything */
		$this->mock = $this->testCase->getMock( 'WikiaApp', $mockedMethods, $wikiaAppArgs, '' );
		F::setInstance('App', $this->mock);
	}

	public function mockGlobalVariable($globalName, $returnValue) {
		if(!in_array( 'getGlobal', $this->methods )) {
			$this->methods[] = 'getGlobal';
		}
		$this->mockedGlobals[$globalName] = array( 'value' => $returnValue );
	}

	// If the global variable is not being overridden, return the actual global variable
	public function getGlobalCallback( $globalName ) {
		return ( isset($this->mockedGlobals[$globalName]['value']) ? $this->mockedGlobals[$globalName]['value'] : $GLOBALS[$globalName] );
	}

}
