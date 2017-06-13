<?php

use Wikia\CreateNewWiki\RateLimitedException;
use Wikia\CreateNewWiki\UserValidator;
use Wikia\CreateNewWiki\ValidationException;

class RateLimitedExceptionTest extends WikiaBaseTest {
	protected function setUp() {
		$this->setupFile = __DIR__ . '/../../CreateNewWiki_setup.php';
		parent::setUp();
	}

	public function testUsesCorrectMessagesAndStatusCode() {
		$rateLimitedException = new RateLimitedException();

		$this->assertInstanceOf( ValidationException::class, $rateLimitedException );

		$this->assertEquals(
			429,
			$rateLimitedException->getHttpStatusCode()
		);

		$this->assertEquals(
			'cnw-error-wiki-limit',
			$rateLimitedException->getErrorMessageKey()
		);

		$this->assertEquals(
			'cnw-error-wiki-limit-header',
			$rateLimitedException->getHeaderMessageKey()
		);

		$this->assertEquals(
			[ UserValidator::MAX_WIKI_CREATIONS_PER_USER_PER_DAY ],
			$rateLimitedException->getErrorMessageParams()
		);
	}
}
