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
		$this->appMock = new WikiaAppMock;
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

	protected function mockGlobal( $globalName, $returnValue ) {
		if($this->appMock == null) {
			$this->markTestSkipped('WikiaBaseTest Error - add parent::setUp() and/or parent::tearDown() to your own setUp/tearDown methods');
		}
		$this->appMock->mockGlobal( $globalName, $returnValue );
	}

	protected function mockFunction( $functionName, $returnValue ) {
		if($this->appMock == null) {
			$this->markTestSkipped('WikiaBaseTest Error - add parent::setUp() and/or parent::tearDown() to your own setUp/tearDown methods');
		}
		$this->appMock->mockFunction( $functionName, $returnValue );
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

class WikiaAppMock extends PHPUnit_Framework_TestCase {

	private $mock = null;
	private $methods = array();
	private $mockedGlobals = array();
	private $mockedFunctions = array();

	public function init() {
		$this->mock = $this->getMock( 'WikiaApp', $this->methods, array(), '', false );
		if( in_array( 'getGlobal', $this->methods )) {
			$this->mock->expects( $this->exactly( count( $this->mockedGlobals ) ) )
			              ->method( 'getGlobal' )
			              ->will( $this->returnCallback(array( $this, 'getGlobalCallback')));
		}
		if( in_array( 'runFunction', $this->methods ) ) {
			$this->mock->expects( $this->exactly( count( $this->mockedFunctions ) ) )
			              ->method( 'runFunction' )
			              // @todo support params
			              ->will( $this->returnCallback(array( $this, 'runFunctionCallback')));
		}
		F::setInstance('App', $this->mock);
	}

	public function mockGlobal($globalName, $returnValue) {
		if(!in_array( 'getGlobal', $this->methods )) {
			$this->methods[] = 'getGlobal';
		}
		if(!in_array($globalName, $this->mockedGlobals)) {
			$this->mockedGlobals[$globalName] = $returnValue;
		}
		else {
			$this->markTestSkipped( "Global variable $globalName already mocked, multiple mocks of the same variable are evil!" );
		}
	}

	protected function mockFunction($functionName, $returnValue, $inputParams	 ) {
		if(!in_array( 'runFunction', $this->methods )) {
			$this->methods[] = 'runFunction';
		}
		//$this->mockedFunctions[] = $functionName, $returnValue;
	}

	public function getGlobalCallback( $globalName ) {
		return ( isset($this->mockedGlobals[$globalName]) ? $this->mockedGlobals[$globalName] : null );
	}

	public function runFunctionCallback( $functionName ) {
		return ( isset($this->mockedFunctions[$functionName]) ? $this->mockedFunctions[$functionName] : null );
	}

}

class WikiaAppFunctionMock {
	public $name;
	public $returnValue;
	public $params = array();

	public function __construct( $name, $returnValue, $params = array() ) {
		$this->name = $name;
		$this->returnValue = $returnValue;
		$this->params = $params;
	}

}