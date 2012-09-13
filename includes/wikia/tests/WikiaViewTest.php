<?php
/**
 * @ingroup mwabstract
 */
class WikiaViewTest extends PHPUnit_Framework_TestCase {

	/**
	 * WikiaView object
	 * @var WikiaView
	 */
	protected $object;
	protected $app = null;

	protected function setUp() {
		$this->app = F::build( 'App' );
		$this->object = F::build( 'WikiaView' );
	}

	protected function tearDown() {
		F::setInstance( 'App', $this->app );
	}

	public function creatingNewFromControllerAndMethodDataProvider() {
		return array(
			array( 'Test', 'Foo', array(), 'html' ),
			array( 'Test', 'Bar', array( 'foo1' => 1, 'foo2' => 2 ), 'json' ),
			array( 'Test', 'Foo', array( 'bar' => 'zzz' ), 'raw' ),
		);
	}

	/**
	 * @dataProvider creatingNewFromControllerAndMethodDataProvider
	 */
	public function testCreatingNewFromControllerAndMethod( $controllerName, $methodName, $data, $format ) {
		$view = WikiaView::newFromControllerAndMethodName( $controllerName, $methodName, $data, $format );

		$this->assertInstanceOf( 'WikiaView', $view );

		$this->assertEquals( $controllerName, $view->getResponse()->getControllerName() );
		$this->assertEquals( $methodName, $view->getResponse()->getMethodName() );
		$this->assertEquals( $data, $view->getResponse()->getData() );
		$this->assertEquals( $format, $view->getResponse()->getFormat() );
	}

	public function setTemplateDataProvider() {
		return array(
		 array( true, 'Test' ),
		 array( true, 'Oasis' ), // tmp, while modules still exists
		 array( false, 'NonExistent' )
		);
	}

	/**
	 * @dataProvider setTemplateDataProvider
	 */
	public function testSetTemplate( $classExists, $controllerName ) {
		$appMock = $this->getMock( 'WikiaApp', array('ajax') ); /* @var $appMock WikiaApp */
		$registryMock = $this->getMock( 'WikiaGlobalRegistry', array('get') );
		$registryMock->expects( $this->any() )
		        ->method( 'get' )
		        ->with( $this->equalTo( 'wgAutoloadClasses' ) )
		        ->will( $classExists ? $this->returnValue( array( $controllerName . 'Controller' => dirname( __FILE__  ) . '/_fixtures/TestController.php' ) ) : $this->returnValue( array() ) );
		$appMock->setGlobalRegistry($registryMock);

		F::setInstance( 'App', $appMock );

		if( !$classExists ) {
			$this->setExpectedException( 'WikiaException' );
		}
		$this->object->setTemplate( $controllerName, 'hello' );

		if( $classExists ) {
			$this->assertEquals( (dirname( __FILE__ ) . '/_fixtures/templates/' . $controllerName . '_hello.php'), $this->object->getTemplatePath() );
		}
	}

	/**
	 * @expectedException WikiaException
	 */
	public function testSetNonExistentTemplate() {
		$appMock = $this->getMock( 'WikiaApp', array( 'ajax' ) ); /* @var $appMock WikiaApp */
		$registryMock = $this->getMock( 'WikiaGlobalRegistry', array('get') );
		$registryMock->expects( $this->any() )
		        ->method( 'get' )
		        ->with( $this->equalTo( 'wgAutoloadClasses' ) )
		        ->will( $this->returnValue( array( 'TestController' => dirname( __FILE__  ) . '/_fixtures/TestController.php' ) ) );
		$appMock->setGlobalRegistry($registryMock);

		F::setInstance( 'App', $appMock );

		$this->object->setTemplate( 'Test', 'nonExistentMethod' );
	}

	/**
	 * @expectedException WikiaException
	 */
	public function testRenderingForUnknownResponse() {
		$this->object->render();
	}

	public function testRenderingForUnknownFormat() {
		$response = F::build( 'WikiaResponse', array( 'unknownFormat' ) );
		$expectedResult = json_encode(array ('exception' => array ('message' => 'Invalid Format, defaulting to JSON', 'code' => 501 )));
		$this->object->setResponse( $response );
		$result = $this->object->render();
		$this->assertEquals($result, $expectedResult);
	}

	public function testRenderingFormatsDataProvider() {
		$responseValueName = 'result';
		$responseValueData = array( 1, 2, 3 );

		return array(
			array( WikiaResponse::FORMAT_RAW, $responseValueName, $responseValueData, '<pre>' . var_export( array( $responseValueName => $responseValueData ), true ) .'</pre>' ),
			array( WikiaResponse::FORMAT_JSON, $responseValueName, $responseValueData, json_encode( array( $responseValueName => $responseValueData ) ) ),
			array( WikiaResponse::FORMAT_HTML, $responseValueName, $responseValueData, implode( '-', $responseValueData ) ),
		);
	}

	/**
	 * @dataProvider testRenderingFormatsDataProvider
	 */
	public function testRenderingFormats($format, $responseValueName, $responseValueData,$expectedResult) {
		$response = F::build( 'WikiaResponse', array( $format ) );
		$response->setVal( $responseValueName, $responseValueData );
		$this->object->setResponse( $response );

		if ( $format == WikiaResponse::FORMAT_HTML ) {
			$appMock = $this->getMock( 'WikiaApp', array('ajax') ); /* @var $appMock WikiaApp */
			$registryMock = $this->getMock( 'WikiaGlobalRegistry', array('get') );
			$registryMock->expects( $this->any() )
				->method( 'get' )
				->with( $this->equalTo( 'wgAutoloadClasses' ) )
				->will( $this->returnValue( array( 'Test' . 'Controller' => dirname( __FILE__  ) . '/_fixtures/TestController.php' ) ) );
			$appMock->setGlobalRegistry($registryMock);

			F::setInstance( 'App', $appMock );
			$this->object->setTemplate( 'Test', 'formatHTML' );
		}

		$this->assertEquals( $expectedResult, $this->object->render() );
	}
}
