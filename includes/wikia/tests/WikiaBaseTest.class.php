<?php
/**
 * WikiaBaseTest class - part of Wikia UnitTest Fraework - W(U)TF
 * @author ADi
 *
 */
class WikiaBaseTest extends PHPUnit_Framework_TestCase {

	protected $app = null;
	protected $appMock = null;
	protected $mockedClasses = array();
	private $setUp = false;
	private $tearDown = false;

	protected function setUp() {
		$this->app = F::app();
		$this->appMock = new WikiaAppMock( $this );
		$this->setUp = true;
	}

	protected function tearDown() {
		F::setInstance('App', $this->app);
		$this->unsetClassInstances();
		$this->tearDown = true;
	}

	public function __destruct() {
		if(!$this->setUp || !$this->tearDown) {
			echo "WikiaBaseTest Error - add parent::setUp() and/or parent::tearDown() to your own setUp/tearDown methods\n";
			exit;
		}
	}

	protected function mockClass($className, $mock) {
		F::setInstance( $className, $mock );
		$this->mockedClasses[] = $className;
	}

	protected function mockGlobalVariable( $globalName, $returnValue, $callsNum = 1 ) {
		if($this->appMock == null) {
			$this->markTestSkipped('WikiaBaseTest Error - add parent::setUp() and/or parent::tearDown() to your own setUp/tearDown methods');
		}
		$this->appMock->mockGlobalVariable( $globalName, $returnValue, $callsNum );
	}

	protected function mockGlobalFunction( $functionName, $returnValue, $callsNum = 1 ) {
		if($this->appMock == null) {
			$this->markTestSkipped('WikiaBaseTest Error - add parent::setUp() and/or parent::tearDown() to your own setUp/tearDown methods');
		}
		$this->appMock->mockGlobalFunction( $functionName, $returnValue, $callsNum );
	}

	protected function mockApp() {
		$this->appMock->init();
	}

	private function unsetClassInstances() {
		foreach( $this->mockedClasses as $className ) {
			F::unsetInstance( $className );
		}
		$this->mockedClasses = array();
	}
}

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

		if( in_array( 'getGlobal', $this->methods )) {
			$globalRegistryMock = $this->testCase->getMock( 'WikiaGlobalRegistry', array( 'get', 'set' ) );
			$globalRegistryMock->expects( $this->testCase->exactly( count( $this->mockedGlobals ) ) )
			    ->method( 'get' )
			    ->will( $this->testCase->returnCallback(array( $this, 'getGlobalCallback')) );

			$wikiaAppArgs[] = $globalRegistryMock;
			$wikiaAppArgs[] = null; // WikiaLocalRegistry
			$wikiaAppArgs[] = null; // WikiaHookDispatcher
		}
		if( in_array( 'runFunction', $this->methods ) ) {
			$functionWrapperMock = $this->testCase->getMock( 'WikiaFunctionWrapper' );
			foreach( $this->mockedFunctions as $functionName => $functionData ) {
				$functionWrapperMock->expects( $this->testCase->exactly( $functionData['calls'] ) )
				    ->method( $functionName )
				    ->will( $this->testCase->returnValue( $functionData['value'] ) );
			}
			$wikiaAppArgs[] = $functionWrapperMock;
		}

		$this->mock = $this->testCase->getMock( 'WikiaApp', array( 'ajax' /* we just have to have something to prevent mocking everything */), $wikiaAppArgs, '' );
		F::setInstance('App', $this->mock);
	}

	public function mockGlobalVariable($globalName, $returnValue, $callsNum = 1) {
		if(!in_array( 'getGlobal', $this->methods )) {
			$this->methods[] = 'getGlobal';
		}
		if(!in_array($globalName, $this->mockedGlobals)) {
			$this->mockedGlobals[$globalName] = array( 'value' => $returnValue, 'calls' => $callsNum );
		}
		else {
			$this->markTestSkipped( "Global variable $globalName already mocked, multiple mocks of the same variable not supported." );
		}
	}

	/**
	 * @brief mock global function
	 * @param string $functionName
	 * @param mixed $returnValue
	 * @param array $inputParams
	 *
	 * @todo support params
	 */
	public function mockGlobalFunction($functionName, $returnValue, $callsNum = 1, $inputParams = array() ) {
		if(!in_array( 'runFunction', $this->methods )) {
			$this->methods[] = 'runFunction';
		}
		if(!in_array($functionName, $this->mockedFunctions)) {
			$this->mockedFunctions[$functionName] = array( 'value' => $returnValue, 'calls' => $callsNum );
		}
		else {
			$this->markTestSkipped( "Function $functionName already mocked, multiple mocks of the same function not supported." );
		}
	}

	public function getGlobalCallback( $globalName ) {
		return ( isset($this->mockedGlobals[$globalName]['value']) ? $this->mockedGlobals[$globalName]['value'] : null );
	}

}

/*
class WrappedFunctionMock {
	public $name;
	public $returnValue;
	public $params = array();

	public function __construct( $name, $returnValue, $params = array() ) {
		$this->name = $name;
		$this->returnValue = $returnValue;
		$this->params = $params;
	}
}
*/
