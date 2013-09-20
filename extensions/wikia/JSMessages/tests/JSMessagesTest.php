<?php

class JSMessagesTest extends WikiaBaseTest {
	const PACKAGE = 'JSMessagesTest';

	/* @var JSMessages */
	protected $instance;

	public function setUp() {
		$this->setupFile = dirname(__FILE__) . '/../JSMessages_setup.php';
		$this->instance = (new JSMessages);
		parent::setUp();
	}

	public function testPrintPackage(){
		$this->instance->registerPackage( '', array( 'sunday' ) );
		$tag = $this->instance->printPackages( array( self::PACKAGE ) );

		$expectedOutput = '<script>' . $this->app->getView( 'JSMessages', 'getMessages', array( 'messages' => $this->instance->getPackages( array( self::PACKAGE ) ) ) )->render() . '</script>';

		$this->assertEquals( $expectedOutput, $tag );
	}
}
