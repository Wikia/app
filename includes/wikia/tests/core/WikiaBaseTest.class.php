<?php
/**
 * WikiaBaseTest class - part of Wikia UnitTest Framework - W(U)TF
 * @author ADi
 * @author Owen
 * Usage:
 *		$this->mockGlobalVariable( 'wgCityId', '12345' );
 *		$this->mockGlobalFunction( 'getDB', $dbMock );
 *      // If you do not call this helper, $app is a real App object
 *		$this->mockApp();
 *      // Now $this->app in a test case is the mock App object
 *
 * Complications: Most extensions have a setup file.  If this setup file is NOT globally included, you will have to
 * include it yourself in the constructor for your unit test.  PHPUnit interacts weirdly with autoloader.
 *
 * function setUp() {
 *    $this->setupFile = __DIR__ . '/../MyExtension_setup.php';
 *    parent::setUp();
 * }
 */
class WikiaBaseTest extends PHPUnit_Framework_TestCase {

	protected static $alternativeConstructors = [
		'Article' => [ 'newFromID', 'newFromTitle', 'newFromWikiPage' ],
		'Title' => [ 'newFromDBkey', 'newFromText', 'newFromURL', 'newFromID', 'newFromRow' ],
		'User' => [ 'newFromName', 'newFromId', 'newFromSession', 'newFromRow' ],
	];


	/** @var string */
	protected $setupFile = null;
	/** @var WikiaApp */
	protected $app = null;

	/** @var array */
	private $mockedGlobalVariables = array();
	/** @var array */
	private $mockedMessages = array();
	/** @var WikiaMockProxy */
	private $mockProxy = null;
	private $mockMessages = null;

	private static $testRunTime = 0;

	/**
	 * Print out currently run test
	 */
	public static function setUpBeforeClass() {
		error_reporting(E_ALL);
		$testClass = get_called_class();
		echo "\nRunning '{$testClass}'...";

		self::$testRunTime = microtime(true);
	}

	/**
	 * Print out time it took to run all tests from current test class
	 */
	public static function tearDownAfterClass() {
		$time = round( (microtime(true) - self::$testRunTime) * 1000 );
		echo "done in {$time} ms";
	}

	protected function setUp() {
		$this->app = F::app();

		if ($this->setupFile != null) {
			global $IP; 					// used by setup file
			global $app; 					// used by setup file
			global $wgAutoloadClasses; 		// used by setup file
			global $wgDevelEnvironment;  	// used by setup file
			require_once($this->setupFile);
		}

		if ( $this->mockProxy !== null ) {
			throw new Exception("Previous test did not execute tearDown()");
		}
		$this->mockProxy = new WikiaMockProxy();
		$this->mockProxy->enable();
	}

	protected function tearDown() {
		$this->unsetGlobals();
		$this->unsetMessages();
		if ( $this->mockProxy === null ) {
			throw new Exception("Current test did not execute setUp()");
		}
		$this->mockProxy->disable();
		$this->mockProxy = null;
	}

	/**
	 * @return WikiaMockProxy
	 */
	private function getMockProxy() {
		if ( empty( $this->mockProxy ) ) {
			throw new Exception("WikiaMockProxy is not initialized yet. Are you trying to mock anything in data provider?");
		}
		return $this->mockProxy;
	}

	/**
	 * This helper function will let you override new ClassName or ClassName::newFromID
	 * See the description in WikiaMockProxy.class.php for more details
	 * Example call:
	 * 	$this->mockClass('Article', $mockArticle);
	 *  $this->mockClass('Title', $mockTitle, 'newFromText');
	 * TODO: make param for functionName an array so you can override both newFromText and newFromID (for example)
	 * @param $className String
	 * @param $mock Object instance of Mock
	 * @param $functionName String name of static constructor
	 * @return void
	 */
	protected function mockClass($className, $mock, $functionName = null) {
		$functionNames = is_array( $functionName ) ? $functionName : array( $functionName );
		foreach ($functionNames as $functionName) {
			if ( empty( $mock ) && empty($functionName) ) { // constructor cannot return null
				return;
			}
			if ( empty($functionName) ) {
				$action = $this->getMockProxy()->getClassConstructor($className);
			} else {
				$action = $this->getMockProxy()->getStaticMethod($className,$functionName);
			}
			$action->willReturn($mock);
		}
	}

	protected function mockClassEx( $className, $mock ) {
		$alternativeConstructors = isset( self::$alternativeConstructors[$className] )
			? self::$alternativeConstructors[$className] : array();
		$alternativeConstructors[] = null;
		$this->mockClass($className,$mock,$alternativeConstructors);
	}

	/**
	 * Create mocked object of a given class with list of methods and values they return provided
	 *
	 * @param string $className name of the class to be mocked
	 * @param array $methods list of methods and values they should return
	 * @param string $staticConstructor name of the "static" class constructor (e.g. Title::newFromText) that will return mocked object
	 * @return object mocked object
	 */
	protected function getMockWithMethods($className, Array $methods = array()) {
		$mock = $this->getMock($className, array_keys($methods));

		foreach($methods as $methodName => $retVal) {
			$mock->expects( $this->any() )
				->method( $methodName )
				->will( $this->returnValue( ( is_null( $retVal ) ) ? $mock : $retVal) );
		}

		return $mock;
	}

	protected function mockClassWithMethods($className, Array $methods = array(), $staticConstructor = '') {
		$mock = $this->getMockWithMethods($className,$methods);

		$this->mockClass($className, $mock, ($staticConstructor !== '') ? $staticConstructor : null);

		return $mock;
	}

	/**
	 * Mock a static method using single return value
	 *
	 * Example:
	 *
	 * $this->mockStaticMethod('Http', 'post', json_encode(['foo' => 'bar']));
	 *
	 * @param $className string class name
	 * @param $methodName string method name
	 * @param $retVal mixed result to be returned by mocked method
	 */
	protected function mockStaticMethod($className, $methodName, $retVal) {
		$this->getMockProxy()->getStaticMethod($className,$methodName)
			->willReturn($retVal);
	}

	/**
	 * Mock global ($wg...) variable.
	 *
	 * Should be followed by the call to $this->mockApp()
	 *
	 * @param $globalName string name of global variable (e.g. wgCity - WITH wg prefix)
	 * @param $returnValue mixed value variable should be set to
	 */
	protected function mockGlobalVariable( $globalName, $returnValue ) {
		if ( !empty($this->mockedGlobalVariables[$globalName] ) ) {
			$this->mockedGlobalVariables[$globalName]->disable();
		}

		$mock = new WikiaGlobalVariableMock($globalName,$returnValue);
		$mock->enable();

		$this->mockedGlobalVariables[$globalName] = $mock;
	}

	/**
	 * Mock global (wf...) function.
	 *
	 * Should be followed by the call to $this->mockApp()
	 *
	 * @param $functionName string name of global function (e.g. findFile - WITHOUT wf prefix)
	 * @param $returnValue
	 * @param int $callsNum
	 * @param array $inputParams
	 */
	protected function mockGlobalFunction( $functionName, $returnValue, $callsNum = null, $inputParams = null ) {
		if ( function_exists( 'wf'.ucfirst($functionName) ) ) {
			$functionName = 'wf' . ucfirst($functionName);
		}

		$mock = $this->getGlobalFunctionMock( $functionName );
		$expect = $mock->expects( $callsNum !== null ? $this->exactly( $callsNum ) : $this->any() )
			->method( $functionName );
		if ( $inputParams !== null ) {
			$expect = call_user_func_array( array( $expect, 'with' ), $inputParams );
		}
		$expect->will( $this->returnValue( $returnValue ) );

		$this->getMockProxy()->getGlobalFunction($functionName)
			->willCall(array($mock,$functionName));
	}

	/**
	 * Mock given message
	 *
	 * @param $messageName string
	 * @param $messageContent string
	 */
	protected function mockMessage($messageName, $messageContent) {
		if ( empty( $this->mockMessages ) ) {
			$mock = $this->mockMessages = $this->getMethodMock( 'MessageCache', 'get' );

			$mock->expects( $this->any() )
				->method( 'get' )
				->will( $this->returnCallback( array( $this, 'getMessageMock' ) ) );
		}
		$this->mockedMessages[$messageName] = $messageContent;
	}

	protected function getGlobalFunctionMock( $functionName ) {
		$mock = $this->getMockBuilder( 'stdClass' )
			->disableOriginalConstructor()
			->setMethods( array( $functionName ) )
			->getMock();
		$this->getMockProxy()->getGlobalFunction($functionName)
			->willCall(array($mock,$functionName));
		return $mock;
	}

	protected function getStaticMethodMock( $className, $methodName ) {
		is_callable( "{$className}::{$methodName}" ); // autoload
		$mock = $this->getMockBuilder( 'stdClass' )
			->disableOriginalConstructor()
			->setMethods( array( $methodName ) )
			->getMock();
		$this->getMockProxy()->getStaticMethod($className,$methodName)
			->willCall(array($mock,$methodName));
		return $mock;
	}

	protected function getMethodMock( $className, $methodName ) {
		is_callable( "{$className}::{$methodName}" ); // autoload
		$mock = $this->getMockBuilder( 'stdClass' )
			->disableOriginalConstructor()
			->setMethods( array( $methodName ) )
			->getMock();
		$this->getMockProxy()->getMethod($className,$methodName)
			->willCall(array($mock,$methodName));
		return $mock;
	}

	protected function callOriginalGlobalFunction( $functionName, $args ) {
		return $this->getMockProxy()->callOriginalGlobalFunction( $functionName, $args );
	}

	protected function callOriginalMethod( $object, $functionName, $args ) {
		return $this->getMockProxy()->callOriginalMethod( $object, $functionName, $args );
	}

	// After calling this, any reference to $this->app in a test now uses the mocked object
	/**
	 * @deprecated
	 */
	protected function mockApp() {
		// noop
	}

	private function unsetGlobals() {
		foreach ($this->mockedGlobalVariables as $globalName => $mock) {
			$mock->disable();
		}
		$this->mockedGlobals = array();
	}

	private function unsetMessages() {
		$this->mockedMessages = array();
	}

	public function getMessageMock( $key ) {
		if ( array_key_exists( $key, $this->mockedMessages ) ) {
			return $this->mockedMessages[$key];
		}

		return $this->callOriginalMethod( MessageCache::singleton(), 'get', func_get_args() );
	}

	public static function markTestSkipped($message = '') {
		$backtrace = wfDebugBacktrace(3);
		$entry = $backtrace[1];

		Wikia::log(wfFormatStackFrame($entry), false, "marked as skipped - $message");
        parent::markTestSkipped($message);
    }

	public static function markTestIncomplete($message = '') {
		Wikia::log(__METHOD__, '', $message);
		parent::markTestIncomplete($message);
	}
}
