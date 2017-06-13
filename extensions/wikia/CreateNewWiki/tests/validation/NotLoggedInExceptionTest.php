<?php

use Wikia\CreateNewWiki\NotLoggedInException;
use Wikia\CreateNewWiki\ValidationException;

class NotLoggedInExceptionTest extends WikiaBaseTest {
	protected function setUp() {
		$this->setupFile = __DIR__ . '/../../CreateNewWiki_setup.php';
		parent::setUp();
	}

	public function testUsesCorrectMessagesAndStatusCode() {
		$notLoggedInException = new NotLoggedInException();

		$this->assertInstanceOf( ValidationException::class, $notLoggedInException );

		$this->assertEquals(
			401,
			$notLoggedInException->getHttpStatusCode()
		);

		$this->assertEquals(
			'cnw-error-anon-user',
			$notLoggedInException->getErrorMessageKey()
		);

		$this->assertEquals(
			'cnw-error-anon-user-header',
			$notLoggedInException->getHeaderMessageKey()
		);
	}
}
