<?php

require_once dirname(__FILE__) . '/_fixtures/TestController.php';

/**
 * @group mwabstract
 */
class WikiaControllerTest extends PHPUnit_Framework_TestCase {

	public function testGeneratingHelpDataProvider() {
		return array(
			array( 'json', '{' ),
			array( 'html', '<' )
		);
	}

	/**
	 * @dataProvider testGeneratingHelpDataProvider
	 */
	public function testGeneratingHelp( $format, $prefix ) {
		$response = F::build( 'App' )->dispatch( array( 'controller' => 'Test', 'method' => 'help', 'format' => $format ));
		//$response->setTemplatePath('non');
		$this->assertInstanceOf( 'WikiaResponse', $response );
		$this->assertNull( $response->getException() );
		$this->assertStringStartsWith( $prefix, $response->toString() );
	}

	public function testRedirectingDataProvider() {
		return array(
			array( true ),
			array( false )
		);
	}

	/**
	 * @dataProvider testRedirectingDataProvider
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
