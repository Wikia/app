<?php

require_once dirname(__FILE__) . '/_fixtures/TestController.php';

/**
 * @group mwabstract
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
		$response = F::build( 'App' )->dispatch( array( 'controller' => 'Test', 'method' => 'help', 'format' => $format ));
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
		$response = F::build( 'App' )->dispatch( array( 'controller' => 'Test', 'method' => 'redirectTest', 'resetResponse' => $resetResponse ));
		$data = $response->getData();

		$this->assertEquals( 'AnotherTestController', $data['controller'] );
		$this->assertTrue( $data['foo'] );
		if( $resetResponse ) {
			$this->assertFalse( isset($data['content']) );
		}
	}
}
