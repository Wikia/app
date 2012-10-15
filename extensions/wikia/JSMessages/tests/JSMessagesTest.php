<?php

class JSMessagesTest extends WikiaBaseTest {
	const PACKAGE = 'JSMessagesTest';

	protected $instance;

	public function setUp() {
		$this->setupFile = dirname(__FILE__) . '/../JSMessages_setup.php';
		$this->instance = F::build( 'JSMessages' );
		parent::setUp();
	}

	public function testPrintPackage(){
		$this->instance->registerPackage( '', array( 'sunday' ) );
		$tag = $this->instance->printPackages( array( self::PACKAGE ) );

		$expectedOutput = '<script>' . $this->app->getView( 'JSMessages', 'getMessages', array( 'messages' => $this->instance->getPackages( array( self::PACKAGE ) ) ) )->render() . '</script>';

		$this->assertEquals( $expectedOutput, $tag );
	}
}