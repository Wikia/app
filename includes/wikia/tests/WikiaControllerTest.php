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

	/**
	 * @dataProvider redirectingDataProvider
	 */
	public function testRedirecting( $resetResponse ) {
		$response = F::app()->sendRequest( 'Test', 'redirectTest', array( 'resetResponse' => $resetResponse ), false );
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
