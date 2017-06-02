<?php

use PHPUnit\Framework\TestCase;

class RailControllerTest extends TestCase {
	/** @var OutputPage $out */
	private $out;

	/** @var RailController $railController */
	private $railController;

	protected function setUp() {
		require_once __DIR__ . '/../RailController.class.php';

		$wikiaRequest = new WikiaRequest( [] );
		$wikiaResponse = new WikiaResponse( WikiaResponse::FORMAT_HTML, $wikiaRequest );

		$context = new RequestContext();
		$this->out = $context->getOutput();

		$this->railController = new RailController();
		$this->railController->setRequest( $wikiaRequest );
		$this->railController->setResponse( $wikiaResponse );
		$this->railController->setContext( $context );
	}

	/**
	 * Test that the Rail JS module is added to output when the non-lazy rail segment is rendered.
	 */
	public function testRailModuleIsAddedToOutput() {
		$this->railController->index();

		$this->assertContains( 'ext.wikia.rail', $this->out->getModules() );
	}
}
