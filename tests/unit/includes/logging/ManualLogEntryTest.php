<?php

use PHPUnit\Framework\TestCase;

class ManualLogEntryTest extends TestCase {
	const LOG_TYPE = 'test_type';
	const LOG_SUBTYPE = 'test_subtype';

	/** @var User|PHPUnit_Framework_MockObject_MockObject $userMock */
	private $userMock;

	/** @var ManualLogEntry $manualLogEntry */
	private $manualLogEntry;

	protected function setUp() {
		parent::setUp();

		$this->userMock = $this->createMock( User::class );
		$this->manualLogEntry = new ManualLogEntry( static::LOG_TYPE, static::LOG_SUBTYPE );
	}

	public function testLogTypeSubtype() {
		$this->assertEquals( static::LOG_TYPE, $this->manualLogEntry->getType() );
		$this->assertEquals( static::LOG_SUBTYPE, $this->manualLogEntry->getSubtype() );
	}

	public function testLogEntryCannotBeSavedWithAnonUserAsAuthor() {
		$this->expectException( MWException::class );
		$this->expectExceptionMessage( 'Log entries must be attributed to registered users' );

		$this->userMock->expects( $this->any() )
			->method( 'isAnon' )
			->willReturn( true );

		$this->manualLogEntry->setPerformer( $this->userMock );
		$this->manualLogEntry->insert();
	}
}
