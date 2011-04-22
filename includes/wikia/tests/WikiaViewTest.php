<?php
/**
 * @group mwabstract
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

	public function buildingTemplatePathDataProvider() {
		return array(
		 array( true, 'Test' ),
		 array( true, 'Oasis' ), // tmp, while modules still exists
		 array( false, 'NonExistent' )
		);
	}

	/**
	 * @dataProvider buildingTemplatePathDataProvider
	 */
	public function testBuildingTemplatePath( $classExists, $controllerName ) {
		$appMock = $this->getMock( 'WikiaApp', array( 'getGlobal' ) );
		$appMock->expects( $this->once() )
		        ->method( 'getGlobal' )
		        ->with( $this->equalTo( 'wgAutoloadClasses' ) )
		        ->will( $classExists ? $this->returnValue( array( $controllerName . 'Controller' => dirname( __FILE__  ) . '/_fixtures/TestController.php' ) ) : $this->returnValue( array() ) );

		F::setInstance( 'App', $appMock );

		if( !$classExists ) {
			$this->setExpectedException( 'WikiaException' );
		}
		$this->object->buildTemplatePath( $controllerName, 'hello', true );

		if( $classExists ) {
			$this->assertEquals( (dirname( __FILE__ ) . '/_fixtures/templates/' . $controllerName . '_hello.php'), $this->object->getTemplatePath() );
		}
	}

	/**
	 * @expectedException WikiaException
	 */
	public function testBuildingNonExistentTemplate() {
		$appMock = $this->getMock( 'WikiaApp', array( 'getGlobal' ) );
		$appMock->expects( $this->once() )
		        ->method( 'getGlobal' )
		        ->with( $this->equalTo( 'wgAutoloadClasses' ) )
		        ->will( $this->returnValue( array( 'TestController' => dirname( __FILE__  ) . '/_fixtures/TestController.php' ) ) );

		F::setInstance( 'App', $appMock );

		$this->object->buildTemplatePath( 'Test', 'nonExistentMethod', true );
	}

	/**
	 * @expectedException WikiaException
	 */
	public function testRenderingForUnknownResponse() {
		$this->object->render();
	}

	/**
	 * @expectedException WikiaException
	 */
	public function testRenderingForUnknownFormat() {
		$response = F::build( 'WikiaResponse', array( 'unknownFormat' ) );

		$this->object->setResponse( $response );
		$this->object->render();
	}
}