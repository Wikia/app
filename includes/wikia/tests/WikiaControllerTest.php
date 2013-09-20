<?php

require_once dirname(__FILE__) . '/_fixtures/TestController.php';

/**
 * @ingroup mwabstract
 */
class WikiaControllerTest extends PHPUnit_Framework_TestCase {

	public function generatingHelpDataProvider() {
		return array(
			array( 'json', '{' ),
			array( 'html', '<' )
		);
	}

	/**
	 * @dataProvider generatingHelpDataProvider
	 */
	public function testGeneratingHelp( $format, $prefix ) {
		$response = F::app()->sendRequest( 'Test', 'help', array( 'format' => $format ), false );
		//$response->setTemplatePath('non');
		$this->assertInstanceOf( 'WikiaResponse', $response );
		$this->assertNull( $response->getException() );
		$this->assertStringStartsWith( $prefix, $response->toString() );
	}

	public function redirectingDataProvider() {
		return array(
			array( true ),
			array( false )
		);
	}

	/*
	 * Test that the Controller response object is working properly for get/set/unset of a controller property
	 */
	public function testResponse() {
		$controller = new TestController();
		$response = new WikiaResponse('html');

		// setResponse and getResponse
		$controller->setResponse($response);
		$this->assertEquals ($response, $controller->getResponse());

		// setVal and getVal
		$controller->foo = 'foo';
		$this->assertFalse (empty($controller->foo));
		$this->assertEquals ($controller->foo, 'foo');

		// unset
		unset($controller->foo);
		$this->assertTrue (empty($controller->foo));
	}

	/**
	 * @dataProvider redirectingDataProvider
	 */
	public function testRedirecting( $resetResponse ) {
		$response = F::app()->sendRequest( 'Test', 'forwardTest', array( 'resetResponse' => $resetResponse ), false );
		$data = $response->getData();

		$this->assertEquals( 'AnotherTestController', $data['controller'] );
		$this->assertTrue( $data['foo'] );
		if( $resetResponse ) {
			$this->assertFalse( isset($data['content']) );
		}
	}

	public function testOverrideTemplate(){
		$controllerName = 'Test';
		$templateName = 'overridden';
		$comparisonStone = 'ABC';

		$response = F::app()->sendRequest(
			$controllerName,
			'overrideTemplateTest',
			array(
				'input' => $comparisonStone,
				'template' => $templateName,
				'format' => 'html'
			)
		);

		$this->assertContains( "{$controllerName}_{$templateName}.php", $response->getView()->getTemplatePath() );
		$this->assertEquals( "<p>{$comparisonStone}</p>", $response->toString() );
	}
}
