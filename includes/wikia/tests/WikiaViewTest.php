<?php

require_once dirname(__FILE__) . '/_fixtures/TestController.php';
require_once dirname(__FILE__) . '/_fixtures/TestATestController.php';
require_once dirname(__FILE__) . '/_fixtures/TestATestBTestController.php';

use PHPUnit\Framework\TestCase;

/**
 * @ingroup mwabstract
 */
class WikiaViewTest extends TestCase {

	/**
	 * WikiaView object
	 * @var WikiaView
	 */
	protected $object;

	protected function setUp() {
		$this->object = ( new WikiaView );
	}

	public function creatingNewFromControllerAndMethodDataProvider() {
		return [
			[ 'Test', 'Foo', [], 'html' ],
			[ 'TestA\Test', 'Foo', [], 'html' ],
			[ 'TestA\TestB\Test', 'Foo', [], 'html' ],
			[ 'Test', 'Bar', [ 'foo1' => 1, 'foo2' => 2 ], 'json' ],
			[ 'TestA\Test', 'Bar', [ 'foo1' => 1, 'foo2' => 2 ], 'json' ],
			[ 'TestA\TestB\Test', 'Bar', [ 'foo1' => 1, 'foo2' => 2 ], 'json' ],
		];
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
		return [
			[ true, 'Test' ],
			[ true, 'TestA\Test' ],
			[ true, 'TestA\TestB\Test' ],
			[ false, 'NonExistent' ],
		];
	}

	/**
	 * @dataProvider setTemplateDataProvider
	 */
	public function testSetTemplate( $classExists, $controllerName ) {
		if ( $classExists ) {
			$this->mockAutoloadedController( $controllerName );
		} else {
			$this->expectException( WikiaException::class );
		}

		$this->object->setTemplate( $controllerName, 'hello' );

		$controllerNameExploded = explode('\\', $controllerName);
		$controllerNameWithoutNamespace = end( $controllerNameExploded );

		if ( $classExists ) {
			$this->assertEquals( ( dirname( __FILE__ ) . '/_fixtures/templates/' . $controllerNameWithoutNamespace . '_hello.php' ), $this->object->getTemplatePath() );
		}
		$this->unmockAutoloadedController( $controllerName );
	}

	/**
	 * @expectedException WikiaException
	 */
	public function testSetNonExistentTemplate() {
		$this->mockAutoloadedController( 'Test' );

		$this->object->setTemplate( 'Test', 'nonExistentMethod' );

		$this->unmockAutoloadedController( 'Test' );
	}

	/**
	 * @expectedException WikiaException
	 */
	public function testRenderingForUnknownResponse() {
		$this->object->render();
	}

	public function testRenderingForUnknownFormat() {
		$response = new WikiaResponse( 'unknownFormat' );
		$response->setVal( 'secret', 'data' );
		$this->object->setResponse( $response );
		$expectedResult = json_encode( [ 'exception' => [ 'message' => 'Invalid Response Format', 'code' => 400 ] ] );
		$this->object->setResponse( $response );
		$result = $this->object->render();
		$this->assertEquals( $result, $expectedResult );
	}

	public function renderingFormatsDataProvider() {
		$responseValueName = 'result';
		$responseValueData = [ 1, 2, 3 ];

		return [
			[ WikiaResponse::FORMAT_JSON, $responseValueName, $responseValueData, json_encode( [ $responseValueName => $responseValueData ] ) ],
			[ WikiaResponse::FORMAT_HTML, $responseValueName, $responseValueData, implode( '-', $responseValueData ) ],
		];
	}

	/**
	 * @dataProvider renderingFormatsDataProvider
	 */
	public function testRenderingFormats( $format, $responseValueName, $responseValueData, $expectedResult ) {
		$response = new WikiaResponse( $format );
		$response->setVal( $responseValueName, $responseValueData );
		$this->object->setResponse( $response );

		if ( $format == WikiaResponse::FORMAT_HTML ) {
			$this->mockAutoloadedController( 'Test' );

			$this->object->setTemplate( 'Test', 'formatHTML' );
		}

		$this->assertEquals( $expectedResult, $this->object->render() );

		$this->unmockAutoloadedController( 'Test' );
	}

	protected function mockAutoloadedController( $controllerName ) {
		global $wgAutoloadClasses;
		if ( array_key_exists( $controllerName . 'Controller', $wgAutoloadClasses ) ) {
			$this->mockedAutoloadedController = $wgAutoloadClasses[$controllerName . 'Controller'];
		}
		$wgAutoloadClasses[$controllerName . 'Controller'] = dirname( __FILE__ ) . '/_fixtures/' . $controllerName . 'Controller.php';
	}

	protected function unmockAutoloadedController( $controllerName ) {
		global $wgAutoloadClasses;
		if ( isset( $this->mockedAutoloadedController ) ) {
			$wgAutoloadClasses[$controllerName . 'Controller'] = $this->mockedAutoloadedController;
		} else {
			unset( $wgAutoloadClasses[$controllerName . 'Controller'] );
		}
	}
}
