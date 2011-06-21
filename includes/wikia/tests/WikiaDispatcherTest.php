<?php

require_once dirname(__FILE__) . '/_fixtures/TestController.php';

/**
 * @ingroup mwabstract
 */
class WikiaDispatcherTest extends PHPUnit_Framework_TestCase {

	/**
	 * @var WikiaDispatcher
	 */
	protected $object = null;

	protected function setUp() {
		$this->object = new WikiaDispatcher();
	}

	public function testDispatchUnknownOrEmptyController() {
		$app = $this->getMock( 'WikiaApp', array( 'runFunction' ) );
		$app->expects( $this->any() )
		    ->method( 'runFunction' )
		    ->will( $this->returnValue( true ) );

		$response = $this->object->dispatch( $app, F::build('WikiaRequest', array($_POST + $_GET)) );

		$this->assertTrue($response->hasException());
		$this->assertInstanceOf( 'WikiaException', $response->getException());
		$this->assertEquals(WikiaResponse::RESPONSE_CODE_ERROR, $response->getCode());

		$response = $this->object->dispatch( $app, new WikiaRequest( array( 'controller' => 'nonExistentController' ) ) );
		$this->assertTrue($response->hasException());
		$this->assertInstanceOf( 'WikiaException', $response->getException());
		$this->assertEquals(WikiaResponse::RESPONSE_CODE_ERROR, $response->getCode());
	}

	public function testDispatchUnknownMethod() {
		$app = $this->getMock( 'WikiaApp', array( 'runFunction' ) );
		$app->expects( $this->any() )
		    ->method( 'runFunction' )
		    ->will( $this->returnValue( true ) );

		$response = $this->object->dispatch( $app, new WikiaRequest( array( 'controller' => 'Test', 'method' => 'nonExistentMethod' ) ) );
		$this->assertTrue($response->hasException());
		$this->assertInstanceOf( 'WikiaException', $response->getException());
		$this->assertEquals(WikiaResponse::RESPONSE_CODE_ERROR, $response->getCode());
	}

	public function testDispatchInternal() {
		//$app = $this->getMock( 'WikiaApp' );

		$response = $this->object->dispatch( F::build('App'), new WikiaRequest( array( 'controller' => 'Test', 'method' => 'sendTest' ) ) );

		$this->assertTrue($response->hasException());
		$this->assertInstanceOf( 'WikiaException', $response->getException());
		$this->assertEquals(WikiaResponse::RESPONSE_CODE_ERROR, $response->getCode());
	}
}
