<?php

use Wikia\CreateNewWiki\UserBlockedException;
use Wikia\CreateNewWiki\ValidationException;

class UserBlockedExceptionTest extends WikiaBaseTest {
	/** @var User|PHPUnit_Framework_MockObject_MockObject $userMock */
	private $userMock;

	/** @var Block|PHPUnit_Framework_MockObject_MockObject $blockMock */
	private $blockMock;

	protected function setUp() {
		$this->setupFile = __DIR__ . '/../../CreateNewWiki_setup.php';
		parent::setUp();

		$this->blockMock = $this->createMock( Block::class );
		$this->userMock = $this->createMock( User::class );

		$this->userMock->expects( $this->any() )
			->method( 'getBlock' )
			->willReturn( $this->blockMock );
	}

	public function testUsesCorrectMessagesAndStatusCode() {
		$rateLimitedException = new UserBlockedException( $this->userMock );

		$this->assertInstanceOf( ValidationException::class, $rateLimitedException );

		$this->assertEquals(
			403,
			$rateLimitedException->getHttpStatusCode()
		);

		$this->assertEquals(
			'cnw-error-blocked',
			$rateLimitedException->getErrorMessageKey()
		);

		$this->assertEquals(
			'cnw-error-blocked-header',
			$rateLimitedException->getHeaderMessageKey()
		);
	}
}
