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

	protected $setupFile = null;
	/* @var WikiaApp */
	protected $app = null;
	protected $appOrig = null;
	/* @var WikiaAppMock */
	private $appMock = null;
	private $mockedClasses = array();

	private static $lastTestClass = '';

	protected function setUp() {
		$testClass = get_class($this);

		if (self::$lastTestClass !== $testClass) {
			echo "\nRunning '{$testClass}'...";
			self::$lastTestClass = $testClass;
		}

		$this->app = F::app();
		$this->appOrig = F::app();
		$this->appMock = new WikiaAppMock( $this );

		if ($this->setupFile != null) {
			global $wgAutoloadClasses; // used by setup file
			require_once($this->setupFile);
		}
	}

	protected function tearDown() {
		$this->unsetClassInstances();
		if (is_object($this->appOrig)) {
			F::setInstance('App', $this->appOrig);
		}
		unset_new_overload();
		WikiaMockProxy::cleanup();
	}

	// TODO: remove mockClass after fixing remaining unit tests
	protected function mockClass($className, $mock) {
		// Allow the old tests to run
		F::setInstance( $className, $mock );
		$this->mockedClasses[] = $className;
	}

	/**
	 * This helper function will let you override new ClassName or ClassName::newFromID
	 * See the description in WikiaMockProxy.class.php for more details
	 * Example call:
	 * 	$this->proxyClass('Article', $mockArticle);
	 *  $this->proxyClass('Title', $mockTitle, 'newFromText');
	 * TODO: make param for functionName an array so you can override both newFromText and newFromID (for example)
	 * @param $className String
	 * @param $mock Object instance of Mock
	 * @param $functionName String name of static constructor
	 * @return void
	 */
	protected function proxyClass($className, $mock, $functionName = null) {
		$mockClassName = get_class($mock);
		WikiaMockProxy::proxy($className, $mockClassName, $mock);
		if ($functionName) {
			WikiaMockProxy::redefineStaticConstructor($className, $functionName);
		}
	}

	protected function mockGlobalVariable( $globalName, $returnValue ) {
		if($this->appMock == null) {
			$this->markTestSkipped('WikiaBaseTest Error - add parent::setUp() and/or parent::tearDown() to your own setUp/tearDown methods');
		}
		$this->appMock->mockGlobalVariable( $globalName, $returnValue );
	}

	protected function mockGlobalFunction( $functionName, $returnValue, $callsNum = 1, $inputParams = array() ) {
		if($this->appMock == null) {
			$this->markTestSkipped('WikiaBaseTest Error - add parent::setUp() and/or parent::tearDown() to your own setUp/tearDown methods');
		}
		$this->appMock->mockGlobalFunction( $functionName, $returnValue, $callsNum, $inputParams );
	}

	// After calling this, any reference to $this->app in a test now uses the mocked object
	protected function mockApp() {
		$this->appMock->init();
		$this->app = F::app();

		// php-test-helpers provides this function
		set_new_overload('WikiaMockProxy::overload');
	}

	private function unsetClassInstances() {
		foreach( $this->mockedClasses as $className ) {
			F::unsetInstance( $className );
		}
		$this->mockedClasses = array();
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
