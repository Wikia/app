<?php

use PHPUnit\Framework\TestCase;

class WallBaseControllerTest extends TestCase {
	protected function setUp() {
		parent::setUp();
		require_once __DIR__ . '/../WallBaseController.class.php';
	}

	/**
	 * Test that Wall JS module is added to output
	 */
	public function testJsModuleIsAdded() {
		$request = new WikiaRequest( [] );
		$response = new WikiaResponse( $request );
		$context = new RequestContext();

		$wallBaseController = new WallBaseController();
		$wallBaseController->setRequest( $request );
		$wallBaseController->setResponse( $response );
		$wallBaseController->setContext( $context );

		$wallBaseController->addAsset();

		$this->assertContains( 'ext.wikia.wall', $context->getOutput()->getModules() );
	}
}
