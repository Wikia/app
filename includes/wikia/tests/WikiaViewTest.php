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

	protected function setUp() {
		$this->object = (new WikiaView);
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
		 array( false, 'NonExistent' )
		);
	}

	/**
	 * @dataProvider setTemplateDataProvider
	 */
	public function testSetTemplate( $classExists, $controllerName ) {
		if ($classExists) {
			$this->mockAutoloadedController($controllerName);
		} else {
			$this->setExpectedException( 'WikiaException' );
		}

		$this->object->setTemplate( $controllerName, 'hello' );

		if( $classExists ) {
			$this->assertEquals( (dirname( __FILE__ ) . '/_fixtures/templates/' . $controllerName . '_hello.php'), $this->object->getTemplatePath() );
		}
		$this->unmockAutoloadedController($controllerName);
	}

	/**
	 * @expectedException WikiaException
	 */
	public function testSetNonExistentTemplate() {
		$this->mockAutoloadedController('Test');

		$this->object->setTemplate( 'Test', 'nonExistentMethod' );

		$this->unmockAutoloadedController('Test');
	}

	/**
	 * @expectedException WikiaException
	 */
	public function testRenderingForUnknownResponse() {
		$this->object->render();
	}

	public function testRenderingForUnknownFormat() {
		$response = new WikiaResponse( 'unknownFormat' );
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
		$response = new WikiaResponse( $format );
		$response->setVal( $responseValueName, $responseValueData );
		$this->object->setResponse( $response );

		if ( $format == WikiaResponse::FORMAT_HTML ) {
			$this->mockAutoloadedController('Test');

			$this->object->setTemplate( 'Test', 'formatHTML' );
		}

		$this->assertEquals( $expectedResult, $this->object->render() );

		$this->unmockAutoloadedController('Test');
	}

	protected function mockAutoloadedController($controllerName) {
		global $wgAutoloadClasses;
		if (array_key_exists($controllerName . 'Controller', $wgAutoloadClasses)) {
			$this->mockedAutoloadedController = $wgAutoloadClasses[$controllerName .  'Controller'];
		}
		$wgAutoloadClasses[$controllerName .  'Controller'] =  dirname( __FILE__  ) . '/_fixtures/' . $controllerName . 'Controller.php';
	}

	protected function unmockAutoloadedController($controllerName) {
		global $wgAutoloadClasses;
		if (isset($this->mockedAutoloadedController)) {
			$wgAutoloadClasses[$controllerName. 'Controller'] = $this->mockedAutoloadedController;
		} else {
			unset($wgAutoloadClasses[$controllerName . 'Controller']);
		}
	}
}
