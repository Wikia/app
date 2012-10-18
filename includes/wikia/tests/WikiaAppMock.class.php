<?php

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

	public function init() {
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
				$functionWrapperMock->expects( $this->testCase->exactly( $functionData['calls'] ) )
					->method( $functionName )
					->will( $this->testCase->returnValue( $functionData['value'] ) );
			}
		}
		$wikiaAppArgs[] = $globalRegistryMock;
		$wikiaAppArgs[] = null; // WikiaLocalRegistry
		$wikiaAppArgs[] = null; // WikiaHookDispatcher
		$wikiaAppArgs[] = $functionWrapperMock;

		$this->mock = $this->testCase->getMock( 'WikiaApp', array( 'ajax' /* we just have to have something to prevent mocking everything */), $wikiaAppArgs, '' );
		F::setInstance('App', $this->mock);
	}

	public function mockGlobalVariable($globalName, $returnValue) {
		if(!in_array( 'getGlobal', $this->methods )) {
			$this->methods[] = 'getGlobal';
		}
		$this->mockedGlobals[$globalName] = array( 'value' => $returnValue );
	}

	/**
	 * @brief mock global function
	 * @param string $functionName
	 * @param mixed $returnValue
	 * @param int $callsNum
	 * @param array $inputParams  // FIXME: not used
	 *
	 * @todo support params
	 */
	public function mockGlobalFunction($functionName, $returnValue, $callsNum = 1, $inputParams = array() ) {
		if(!in_array( 'runFunction', $this->methods )) {
			$this->methods[] = 'runFunction';
		}
		if(!array_key_exists($functionName, $this->mockedFunctions)) {
			$this->mockedFunctions[$functionName] = array( 'value' => $returnValue, 'calls' => $callsNum, 'params' => $inputParams );
		}
		else {
			$this->markTestSkipped( "Function $functionName already mocked, multiple mocks of the same function not supported." );
		}
	}

	// If the global variable is not being overridden, return the actual global variable
	public function getGlobalCallback( $globalName ) {
		return ( isset($this->mockedGlobals[$globalName]['value']) ? $this->mockedGlobals[$globalName]['value'] : $GLOBALS[$globalName] );
	}

}
