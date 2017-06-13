<?php

use Wikia\CreateNewWiki\EmailNotConfirmedException;
use Wikia\CreateNewWiki\ValidationException;

class EmailNotConfirmedExceptionTest extends WikiaBaseTest {

	protected function setUp() {
		$this->setupFile = __DIR__ . '/../../CreateNewWiki_setup.php';
		parent::setUp();
	}

	public function testUsesCorrectMessagesAndStatusCode() {
		$emailNotConfirmedException = new EmailNotConfirmedException();

		$this->assertInstanceOf( ValidationException::class, $emailNotConfirmedException );

		$this->assertEquals(
			403,
			$emailNotConfirmedException->getHttpStatusCode()
		);

		$this->assertEquals(
			'cnw-error-unconfirmed-email',
			$emailNotConfirmedException->getErrorMessageKey()
		);

		$this->assertEquals(
			'cnw-error-unconfirmed-email-header',
			$emailNotConfirmedException->getHeaderMessageKey()
		);
	}
}
