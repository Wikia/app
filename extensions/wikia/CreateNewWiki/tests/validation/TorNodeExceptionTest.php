<?php

use Wikia\CreateNewWiki\TorNodeException;
use Wikia\CreateNewWiki\ValidationException;

class TorNodeExceptionTest extends WikiaBaseTest {
	protected function setUp() {
		$this->setupFile = __DIR__ . '/../../CreateNewWiki_setup.php';
		parent::setUp();
	}

	public function testUsesCorrectMessagesAndStatusCode() {
		$torNodeException = new TorNodeException();

		$this->assertInstanceOf( ValidationException::class, $torNodeException );

		$this->assertEquals(
			403,
			$torNodeException->getHttpStatusCode()
		);

		$this->assertEquals(
			'cnw-error-torblock',
			$torNodeException->getErrorMessageKey()
		);

		$this->assertEquals(
			'cnw-error-blocked-header',
			$torNodeException->getHeaderMessageKey()
		);
	}
}
