<?php
/**
 * WikiaBaseTest class - part of Wikia UnitTest Framework - W(U)TF
 * @author ADi
 * @author Owen
 * @author Władysław Bodzek <wladek@wikia-inc.com>
 * Usage:
 *		$this->mockGlobalVariable( 'wgCityId', '12345' );
 *		$this->mockGlobalFunction( 'getDB', $dbMock );
 *
 * Complications: Most extensions have a setup file.  If this setup file is NOT globally included, you will have to
 * include it yourself in the constructor for your unit test.  PHPUnit interacts weirdly with autoloader.
 *
 * function setUp() {
 *    $this->setupFile = __DIR__ . '/../MyExtension_setup.php';
 *    parent::setUp();
 * }
 */
abstract class WikiaBaseTest extends PHPUnit_Framework_TestCase {

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
	private $mockMessageCacheGet = null;

	private static $testRunTime = 0;

	private static $slowTests = [];
	private static $fastTests = [];
	private static $lineOffset = [];

	const SLOW_TEST_THRESHOLD = 0.002; // ms

	/**
	 * Print out currently run test
	 */
	public static function setUpBeforeClass() {
		error_reporting(E_ALL);
		$testClass = get_called_class();
		echo "\nRunning '{$testClass}'...";

		self::$slowTests = [];
		self::$fastTests = [];
		self::$lineOffset = 0;
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
		$this->startTime = microtime(true);
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
		$this->endTime = microtime(true);

		$this->testRunTime = $this->endTime - $this->startTime;
		$this->processTestRunTime();
	}

	protected function processTestRunTime() {
		$annotations = $this->getAnnotations();

		if($this->testRunTime > self::SLOW_TEST_THRESHOLD) {
			echo "\n" . $this->testRunTime . ' ms' . " - SLOW TEST: " . $this->getName() . "\n";
			$this->processSlowTest( $annotations );
		} else {
			echo "\n" . $this->testRunTime . ' ms' . " - GOOD TEST: " . $this->getName() .  "\n";
			$this->processFastTest( $annotations );
		}
	}

	protected function addSlowTestAnnotation() {
		$className = get_class($this);
		$methodName = $this->getName(false);
		$regexSlowGroup = '/@group\s+Slow\s*/';
		$regexSlowExecTime = '/@slowExecutionTime\s+([0-9\.]+\s*(ms?))/';
		$regexDocBlockStart = '/\/\*\*\s*\n/';

		$classReflector = new ReflectionClass($className);
		$methodReflector  = new ReflectionMethod($className, $methodName);
		$docComment = $methodReflector->getDocComment();

		$filePath = $classReflector->getFileName();

		echo "\nAdding slow annotation to " . $className . '::' . $methodName;

		$slowGroupAnnotation = '@group Slow';
		$slowTimeAnnotation = '@slowExecutionTime ' . $this->testRunTime . ' ms';

		if(!$docComment) {
			$testFile = file($filePath);

			$newDocComment = $this->getNewDocblockForSlowTest( $slowGroupAnnotation, $slowTimeAnnotation );
			$startLine = $methodReflector->getStartLine();
			array_splice($testFile, $startLine-1+self::$lineOffset, 0, $newDocComment);
			$updatedTestCode = implode('',$testFile);
		} else {
			$testCode = file_get_contents($filePath);
			$newDocComment = $docComment;

			if(!preg_match($regexSlowExecTime, $docComment)) {
				$newDocComment = preg_replace($regexDocBlockStart,  "/**\n" . $slowTimeAnnotation . "\n", $newDocComment );
			} else {
				$newDocComment = preg_replace($regexSlowExecTime, $slowGroupAnnotation, $newDocComment);
			}

			if(!preg_match($regexSlowGroup, $docComment)) {
				$newDocComment = preg_replace($regexDocBlockStart,  "/**\n" . $slowGroupAnnotation . "\n", $newDocComment );
			} else {
				$newDocComment = preg_replace($regexSlowGroup, $slowGroupAnnotation, $newDocComment);
			}

			self::$lineOffset += (preg_match_all('/\n/',$newDocComment) - preg_match_all('/\n/',$docComment));

			$updatedTestCode = str_replace($docComment, $newDocComment, $testCode);
		}

		file_put_contents($filePath, $updatedTestCode);
		unset($classReflector);
		unset($methodReflector);
	}

	protected function removeSlowTestAnnotation() {
		echo "\nRemoving slow annotation to " . get_class($this) . '::' . $this->getName();

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
	 * Mock a class constructor so it returns the given object as a result.
	 * Handles both regular and static constructors.
	 *
	 * Example call:
	 * 	$this->mockClass('Article', $mockArticle);
	 *  $this->mockClass('Title', $mockTitle, 'newFromText');
	 * @param $className String
	 * @param $mock PHPUnit_Framework_MockObject_MockObject instance of Mock
	 * @param $functionName String name of static constructor
	 * @return void
	 */
	protected function mockClass($className, $mock, $functionName = null) {
		$functionNames = is_array( $functionName ) ? $functionName : array( $functionName );
		foreach ($functionNames as $functionName) {
			if ( empty( $mock ) && empty($functionName) ) {
				// constructor cannot return null
				// todo: maybe we should throw an exception here instead of failing silently
				return;
			}
			if ( empty($functionName) ) { // regular constructor
				$action = $this->getMockProxy()->getClassConstructor($className);
			} else {
				$action = $this->getMockProxy()->getStaticMethod($className,$functionName);
			}
			$action->willReturn($mock);
		}
	}

	/**
	 * Mock a class constructor so it returns the given object as a result.
	 * Designed specifically for Mediawiki classes that have plenty of different static constructors.
	 * In that case this method hijacks calls to all of them and returns the provided object.
	 *
	 * @see WikiaBaseTest::$alternativeConstructors
	 *
	 * @param $className string Class name
	 * @param $mock PHPUnit_Framework_MockObject_MockObject Mocked object
	 */
	protected function mockClassEx( $className, $mock ) {
		$alternativeConstructors = isset( self::$alternativeConstructors[$className] )
			? self::$alternativeConstructors[$className] : array();
		$alternativeConstructors[] = null; // null stands for regular constructor
		$this->mockClass($className,$mock,$alternativeConstructors);
	}

	/**
	 * Create mocked object of a given class with list of methods and values they return provided
	 *
	 * @param string $className name of the class to be mocked
	 * @param array $methods list of methods and values they should return
	 * @param string $staticConstructor name of the "static" class constructor (e.g. Title::newFromText) that will return mocked object
	 * @return PHPUnit_Framework_MockObject_MockObject mocked object
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
	 * @param $globalName string name of global variable (e.g. wgCity - WITH wg prefix)
	 * @param $returnValue mixed value variable should be set to
	 */
	protected function mockGlobalVariable( $globalName, $returnValue ) {
		if ( !empty($this->mockedGlobalVariables[$globalName] ) ) {
			// revert changes done by previous variable mock
			$this->mockedGlobalVariables[$globalName]->disable();
		}

		$mock = new WikiaGlobalVariableMock($globalName,$returnValue);
		$mock->enable();

		$this->mockedGlobalVariables[$globalName] = $mock;
	}

	/**
	 * Mock global (wf...) function.
	 *
	 * @param $functionName string Global function name (including "wf" prefix)
	 * @param $returnValue mixed
	 * @param $callsNum int
	 * @param $inputParams array
	 */
	protected function mockGlobalFunction( $functionName, $returnValue, $callsNum = null, $inputParams = null ) {
		// sanity check to prevent deprecated way of using this function
		if ( !function_exists($functionName) && function_exists('wf'.ucfirst($functionName)) ) {
			throw new Exception("You have to specify full global function name including 'wf' prefix");
		}

		if ( func_num_args() > 2 ) {
			throw new Exception("You are using deprecated version of mockGlobalFunction");
		}

		list( $namespace, $baseName ) = WikiaMockProxy::parseGlobalFunctionName( $functionName );

		$mock = $this->getGlobalFunctionMock( $functionName );
		$expect = $mock->expects( $callsNum !== null ? $this->exactly( $callsNum ) : $this->any() )
			->method( $baseName );
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
	protected function mockMessage($messageKey, $messageContent) {
		$mock = $this->getMessageMock( $messageKey );
		$mock->expects( $this->any() )
			->method( 'get' )
			->will( $this->returnValue( $messageContent ) );
		return $mock;
	}

	/**
	 * Get a PHPUnit mock associated with class constructor
	 *
	 * Note: Use method name "__construct" when setting up expect rules.
	 * Note: You cannot write assert rules on constructor parameters
	 * due to technical limitations.
	 *
	 * @param $className string Class name
	 * @return PHPUnit_Framework_MockObject_MockObject Mock
	 */
	protected function getConstructorMock( $className ) {
		$mock = $this->getMock( 'stdClass', array( '__construct' ) );
		$this->getMockProxy()->getClassConstructor($className)
			->willCall(array($mock,'__construct'));
		return $mock;
	}

	/**
	 * Get a PHPUnit mock associated with global function
	 *
	 * @param $functionName string Global function name
	 * @return PHPUnit_Framework_MockObject_MockObject Mock
	 */
	protected function getGlobalFunctionMock( $functionName ) {
		list($namespace,$baseName) = WikiaMockProxy::parseGlobalFunctionName( $functionName );
		$mock = $this->getMock( 'stdClass', array( $baseName ) );
		$this->getMockProxy()->getGlobalFunction($functionName)
			->willCall(array($mock,$baseName));
		return $mock;
	}

	/**
	 * Get a PHPUnit mock associated with static class method
	 *
	 * @param $className string Class name
	 * @param $methodName string Method name
	 * @return PHPUnit_Framework_MockObject_MockObject Mock
	 */
	protected function getStaticMethodMock( $className, $methodName ) {
		is_callable( "{$className}::{$methodName}" ); // autoload
		$mock = $this->getMock( 'stdClass', array( $methodName ) );
		$this->getMockProxy()->getStaticMethod($className,$methodName)
			->willCall(array($mock,$methodName));
		return $mock;
	}

	/**
	 * Get a PHPUnit mock associated with regular class method
	 *
	 * @param $className string Class name
	 * @param $methodName string Method name
	 * @return PHPUnit_Framework_MockObject_MockObject Mock
	 */
	protected function getMethodMock( $className, $methodName ) {
		is_callable( "{$className}::{$methodName}" ); // autoload
		$mock = $this->getMock( 'stdClass', array( $methodName ) );
		$this->getMockProxy()->getMethod($className,$methodName)
			->willCall(array($mock,$methodName));
		return $mock;
	}

	protected function getMessageMock( $messageKey ) {
		if ( empty( $this->mockMessageCacheGet ) ) {
			$mockMessageCache = $this->mockMessageCacheGet = $this->getMethodMock( 'MessageCache', 'get' );

			$mockMessageCache->expects( $this->any() )
				->method( 'get' )
				->will( $this->returnCallback( array( $this, '__retrieveMessageMock' ) ) );
		}

		$mock = $this->getMock( 'stdClass', array( 'get' ) );
		$this->mockedMessages[$messageKey] = $mock;
		return $mock;
	}

	/**
	 * Call an original global function
	 *
	 * @param $functionName string Global function name
	 * @param $args array Arguments
	 * @return mixed Value returned by global function
	 */
	protected function callOriginalGlobalFunction( $functionName, $args ) {
		return $this->getMockProxy()->callOriginalGlobalFunction( $functionName, $args );
	}

	/**
	 * Call an original regular class method
	 *
	 * @param $object object Object to call method on
	 * @param $functionName string Method name
	 * @param $args array Arguments
	 * @return mixed Value returned by method
	 */
	protected function callOriginalMethod( $object, $functionName, $args ) {
		return $this->getMockProxy()->callOriginalMethod( $object, $functionName, $args );
	}

	/**
	 * Call an original static class method
	 *
	 * @param $className string Class name
	 * @param $functionName string Method name
	 * @param $args array Arguments
	 * @return mixed Value returned by method
	 */
	protected function callOriginalStaticMethod( $className, $functionName, $args ) {
		return $this->getMockProxy()->callOriginalStaticMethod( $className, $functionName, $args );
	}

	/**
	 * @return WikiaMockProxyInvocation
	 */
	protected function getCurrentInvocation() {
		return WikiaMockProxyAction::currentInvocation();
	}

	/**
	 * @deprecated
	 */
	protected function mockApp() {
		// noop
	}

	protected function proxyClass() {
		return call_user_func_array( array( $this, 'mockClass' ), func_get_args() );
	}

	private function unsetGlobals() {
		/** @var $mock WikiaGlobalVariableMock */
		foreach ($this->mockedGlobalVariables as $globalName => $mock) {
			$mock->disable();
		}
		$this->mockedGlobals = array();
	}

	private function unsetMessages() {
		$this->mockedMessages = array();
	}

	/**
	 * (internal use only)
	 * Get a message contents taking into accounts all the configured message mocks
	 *
	 * @param $key string Message key
	 * @return string Message contents
	 */
	public function __retrieveMessageMock( $key ) {
		if ( array_key_exists( $key, $this->mockedMessages ) ) {
			/** @var $mock PHPUnit_Framework_MockObject_MockObject Mock */
			$mock = $this->mockedMessages[$key];
			return $mock->get();
		}

		return $this->callOriginalMethod( MessageCache::singleton(), 'get', func_get_args() );
	}

	/**
	 * Mark this test as skipped. Puts extra information in the logs.
	 *
	 * @param string $message
	 */
	public static function markTestSkipped($message = '') {
		$backtrace = wfDebugBacktrace(3);
		$entry = $backtrace[1];

		Wikia::log(wfFormatStackFrame($entry), false, "marked as skipped - $message");
        parent::markTestSkipped($message);
    }

	/**
	 * Mark this test as incomplete. Puts extra information in the logs.
	 *
	 * @param string $message
	 */
	public static function markTestIncomplete($message = '') {
		Wikia::log(__METHOD__, '', $message);
		parent::markTestIncomplete($message);
	}

	/**
	 * @param $annotations
	 */
	protected function processSlowTest( $annotations ) {
		if ( !isset( self::$slowTests[$this->getName( false )] ) ) {
			$annotatedAsSlow = false;
			if ( !empty( $annotations['method'] ) && !empty( $annotations['method']['group'] ) ) {
				if ( in_array( 'Slow', $annotations['method']['group'] ) ) {
					$annotatedAsSlow = true;
				}
			}
			if ( !$annotatedAsSlow ) {
				$this->addSlowTestAnnotation();
			}
			self::$slowTests[$this->getName( false )] = true;
		}
	}

	/**
	 * @param $annotations
	 */
	protected function processFastTest( $annotations ) {
		if ( !isset( self::$fastTests[$this->getName( false )] ) ) {
			$annotatedAsSlow = false;
			if ( !empty( $annotations['method'] ) && !empty( $annotations['method']['group'] ) ) {
				if ( in_array( 'Slow', $annotations['method']['group'] ) ) {
					$annotatedAsSlow = true;
				}
			}
			if ( $annotatedAsSlow ) {
				$this->removeSlowTestAnnotation();
			}
			self::$fastTests[$this->getName( false )] = true;
		}
	}

	/**
	 * @param $slowGroupAnnotation
	 * @param $slowTimeAnnotation
	 */
	protected function getNewDocblockForSlowTest( $slowGroupAnnotation, $slowTimeAnnotation ) {
		$newDocComment = "/**" . "\n";
		$newDocComment .= " * " . $slowGroupAnnotation . "\n";
		$newDocComment .= " * " . $slowTimeAnnotation . "\n";
		$newDocComment .= " */" . "\n";

		return $newDocComment;
	}

	private function parseGlobalFunctionName( $functionName ) {
		$last = strrpos($functionName,'\\');
		if ( $last === false ) {
			return [ '', $functionName ];
		} else {
			return [ ltrim( substr( $functionName, 0, $last + 1 ), '\\' ), substr( $functionName, $last + 1 ) ];
		}
	}
}
