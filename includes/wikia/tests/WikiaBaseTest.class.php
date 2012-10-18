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
 * function __construct() {
 *    $this->setupFile = dirname(__FILE__) . '/../MyExtension_setup.php';
 * }
 */
class WikiaBaseTest extends PHPUnit_Framework_TestCase {

	protected $setupFile = null;
	protected $app = null;
	protected $appOrig = null;
	/* @var WikiaAppMock */
	private $appMock = null;
	private $mockedClasses = array();

	protected function setUp() {
		$this->app = F::app();
		$this->appOrig = F::app();
		$this->appMock = new WikiaAppMock( $this );

		if ($this->setupFile != null) {
			global $wgAutoloadClasses; // used by setup file
			require_once($this->setupFile);
		}
	}

	protected function tearDown() {
		if (is_object($this->appOrig)) {
			F::setInstance('App', $this->appOrig);
		}
		$this->unsetClassInstances();
	}

	protected function mockClass($className, $mock) {
		F::setInstance( $className, $mock );
		$this->mockedClasses[] = $className;
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
	}

	private function unsetClassInstances() {
		foreach( $this->mockedClasses as $className ) {
			F::unsetInstance( $className );
		}
		$this->mockedClasses = array();
	}

	public static function markTestSkipped($message = '') {
		Wikia::log(__METHOD__, '', $message);
        parent::markTestSkipped($message);
    }

	public static function markTestIncomplete($message = '') {
		Wikia::log(__METHOD__, '', $message);
		parent::markTestIncomplete($message);
	}
}
