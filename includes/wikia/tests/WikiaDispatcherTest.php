<?php

require_once dirname(__FILE__) . '/_fixtures/TestController.php';

/**
 * @ingroup mwabstract
 */
class WikiaDispatcherTest extends WikiaBaseTest {

	/**
	 * @var WikiaDispatcher
	 */
	protected $object = null;

	protected function setUp() {
		$this->object = new WikiaDispatcher();
		parent::setUp();
	}

	/**
	 * @expectedException ControllerNotFoundException
	 */
	public function testDispatchUnknownOrEmptyController() {
		$app = $this->getMock( 'WikiaApp', array( 'runFunction' ) );
		$app->expects( $this->any() )
		    ->method( 'runFunction' )
		    ->will( $this->returnValue( true ) );

		$response = $this->object->dispatch( $app, new WikiaRequest($_POST + $_GET) );

		$this->assertTrue($response->hasException());
		$this->assertInstanceOf( 'WikiaException', $response->getException());
		$this->assertEquals(WikiaResponse::RESPONSE_CODE_ERROR, $response->getCode());

		$request = new WikiaRequest( array( 'controller' => 'nonExistentController' ) );
		$response = $this->object->dispatch( $app, $request );
		$this->assertTrue($response->hasException());
		$this->assertInstanceOf( 'ControllerNotFoundException', $response->getException());
		$this->assertEquals(WikiaResponse::RESPONSE_CODE_NOT_FOUND, $response->getCode());
		
		$request->setInternal(true);
		$response = $this->object->dispatch( $app, $request );
	}

	public function testDispatchUnknownMethod() {
		$app = $this->getMock( 'WikiaApp', array( 'runFunction' ) );
		$app->expects( $this->any() )
		    ->method( 'runFunction' )
		    ->will( $this->returnValue( true ) );

		$response = $this->object->dispatch( $app, new WikiaRequest( array( 'controller' => 'Test', 'method' => 'nonExistentMethod' ) ) );	
		$this->assertTrue($response->hasException());
		$this->assertInstanceOf( 'MethodNotFoundException', $response->getException());
		$this->assertEquals(WikiaResponse::RESPONSE_CODE_NOT_FOUND, $response->getCode());
	}

	public function testForwarding() {

		$response = $this->object->dispatch( F::app(), new WikiaRequest( array( 'controller' => 'Test', 'method' => 'forwardTest' ) ) );

		// This is set by the controller which is forwarded to by TestController::forwardTest
		$this->assertEquals("hello", $response->getVal('wasCalled'));
	}

	public function testRouting() {
		$response = $this->object->dispatch( F::app(), new WikiaRequest( array( 'controller' => 'Test', 'method' => 'index' ) ) );

		// default routing
		$this->assertEquals("index", $response->getVal("wasCalled"));

		$app = $this->getMock( 'WikiaApp', array ('checkSkin'));
		$app->expects( $this->any() )
			->method( 'checkSkin' )
			->will ( $this->returnValue( true) );

		// skinRouting override controller
		$this->object->addRouting("TestController", array("*" => array("controller" => "AnotherTestController", "skin" => "Test")));
		$response = $this->object->dispatch( $app, new WikiaRequest ( array( 'controller' => 'Test', 'method' => 'index' ) ) );
		$this->assertEquals("controllerRouting", $response->getVal('wasCalled'));

		// skinRouting override method
		$this->object->addRouting("TestController", array("index" => array( "method" => "skinRoutingTest", "skin" => "Test" )));
		$response = $this->object->dispatch( $app, new WikiaRequest( array( 'controller' => 'Test', 'method' => 'index' ) ) );
		$this->assertEquals("skinRouting", $response->getVal("wasCalled"));

		// skinRouting override template only
		$this->object->addRouting("TestController", array("index" => array( "template" => "hello", "skin" => "Test" )));
		$response = $this->object->dispatch( $app, new WikiaRequest( array( 'controller' => 'Test', 'method' => 'index' ) ) );
		$this->assertContains("Test_hello.php", $response->getView()->getTemplatePath());

		// test "after" routing
		$this->object->addRouting("TestController", array("index" => array( "after" => "AnotherTestController::hello::false", "skin" => "Test" )));
		$response = $this->object->dispatch( $app, new WikiaRequest( array( 'controller' => 'Test', 'method' => 'index' ) ) );
		$this->assertEquals("hello", $response->getVal("wasCalled"));

		// skinRouting override controller
		$this->object->addRouting("TestController", array("*" => array("controller" => "AnotherTestController", "notSkin" => "Test")));
		$response = $this->object->dispatch( $app, new WikiaRequest ( array( 'controller' => 'Test', 'method' => 'index' ) ) );
		$this->assertEquals("index", $response->getVal('wasCalled'));

		$app = $this->getMock( 'WikiaApp', array ('checkSkin'));
		$app->expects( $this->any() )
			->method( 'checkSkin' )
			->will ( $this->returnValue( false ) );

		// skinRouting override controller
		$this->object->addRouting("TestController", array("*" => array("controller" => "AnotherTestController", "notSkin" => "Test")));
		$response = $this->object->dispatch( $app, new WikiaRequest ( array( 'controller' => 'Test', 'method' => 'index' ) ) );
		$this->assertEquals("controllerRouting", $response->getVal('wasCalled'));

	}

	public function testControllerNotFound() {
		$response = $this->object->dispatch( F::app(), new WikiaRequest( array( 'controller' => 'FakeNonexistingController', 'method' => 'index' ) ) );

		$this->assertNotNull( $response->getException() );
		$this->assertInstanceOf( "ControllerNotFoundException", $response->getException() );
		$this->assertEquals( "Controller not found: FakeNonexisting", $response->getException()->getDetails() );
	}

	public function testPermissionsException() {
		$this->mockGlobalVariable("wgNirvanaAccessRules", [
			[
				"class" => "TestController",
				"method" => "index",
				"requiredPermissions" => ["write"],
			],
		]);
		$userMock = $this->getMockBuilder("User")->disableOriginalConstructor()->getMock();

		$userMock->expects($this->once())
			->method("isAllowed")
			->with("write")
			->will($this->returnValue(false));
		$this->mockGlobalVariable("wgUser", $userMock);

		$response = $this->object->dispatch( F::app(), new WikiaRequest( array( 'controller' => 'Test', 'method' => 'index' ) ) );

		$this->assertNotNull( $response->getException() );
		$this->assertInstanceOf( "PermissionsException", $response->getException() );
		$this->assertEquals( "Current User don't have required permissions: write", $response->getException()->getDetails() );
	}
}
