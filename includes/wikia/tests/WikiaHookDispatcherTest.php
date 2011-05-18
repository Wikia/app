<?php
require_once dirname(__FILE__) . '/_fixtures/TestHookHandler.php';

/**
 * @ingroup mwabstract
 */
class WikiaHookDispatcherTest extends PHPUnit_Framework_TestCase {
	private $dispatcher;
	
	public function setUp() {
		$this->dispatcher = new WikiaHookDispatcher();
		TestHookHandler::$instancesCounter = 0;
	}

	public function testCallingNonExistentHookThrowsException() {
		$this->setExpectedException('WikiaException');
		$method = 'nonExistentHook'.rand();
		$this->dispatcher->$method(1, 2, 3);
	}
	

	public function testRegisteringHookHandlerReturnsCallbackToHookDispatcher() {
		$callback = $this->dispatcher->registerHook('class', 'method');
		$this->assertInternalType('array', $callback);
		$this->assertArrayHasKey(0, $callback);
		$this->assertArrayHasKey(1, $callback);
		$this->assertSame($this->dispatcher, $callback[0]);
		$this->assertEquals('HOOK__class__method__0', $callback[1]);
		$callback = $this->dispatcher->registerHook('otherClass', 'otherMethod');
		$this->assertEquals('HOOK__otherClass__otherMethod__1', $callback[1]);
	}

	public function testCallingHookHandlerBuildsHookHandlerObjectOnlyOnce() {
		$callback = $this->dispatcher->registerHook('TestHookHandler', 'onEvent');
		$method = $callback[1];
		$this->assertEquals(0, TestHookHandler::$instancesCounter);
		$this->dispatcher->$method();
		$this->dispatcher->$method();
		$this->assertEquals(1, TestHookHandler::$instancesCounter);
	}

	public function testConfiguringHookHandlerToRebuildAlwaysCreatesNotHookHandlerInstance() {
		$callback = $this->dispatcher->registerHook('TestHookHandler', 'onEvent', array(), true);
		$method = $callback[1];
		$this->assertEquals(0, TestHookHandler::$instancesCounter);
		$this->dispatcher->$method();
		$this->dispatcher->$method();
		$this->assertEquals(2, TestHookHandler::$instancesCounter);
	}
}
