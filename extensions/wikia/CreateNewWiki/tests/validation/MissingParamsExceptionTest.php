<?php

use Wikia\CreateNewWiki\MissingParamsException;
use Wikia\CreateNewWiki\ValidationException;

class MissingParamsExceptionTest extends WikiaBaseTest {
	protected function setUp() {
		$this->setupFile = __DIR__ . '/../../CreateNewWiki_setup.php';
		parent::setUp();
	}

	public function testUsesCorrectMessagesAndStatusCode() {
		$missingParamsException = new MissingParamsException();

		$this->assertInstanceOf( ValidationException::class, $missingParamsException );

		$this->assertEquals(
			400,
			$missingParamsException->getHttpStatusCode()
		);

		$this->assertEquals(
			'cnw-error-general',
			$missingParamsException->getErrorMessageKey()
		);

		$this->assertEquals(
			'cnw-error-general-heading',
			$missingParamsException->getHeaderMessageKey()
		);
	}
}
