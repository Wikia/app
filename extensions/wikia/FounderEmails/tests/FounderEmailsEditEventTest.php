<?php

class FounderEmailsEditEventTest extends WikiaBaseTest {
	private $backupUser;
	const MOCKED_USER_ID = 1;

	protected function setUp() {
		parent::setUp();
		global $wgUser;
		$this->backupUser = $wgUser;
		$mockFounderEmails = $this->getMock( 'FounderEmails', [ 'getLastEventType' ], [ ], '', false );
		$mockFounderEmails->expects( $this->any() )->method( 'getLastEventType' )->will( $this->returnValue( 'edit' ) );
		$this->mockClass( 'FounderEmails', $mockFounderEmails );
	}

	public function tearDown() {
		parent::tearDown();
		global $wgUser;
		$wgUser = $this->backupUser;
	}

	/**
	 * @group Slow
	 * @group Broken
	 * @slowExecutionTime 0.04295 ms
	 * first edit
	 * both $isRegisteredUser and $isRegisteredUserFirstEdit should be set to true
	 * setFirstEmailSentFlag should be called
	 */
	public function testRegisterForFirstEdit() {
		// Test setup
		global $wgUser;
		$mockUser = $this->getMockUser();
		$wgUser = $mockUser;

		$mockFounderEmailsEditEvent = $this->getMock( 'FounderEmailsEditEvent', [
			'__construct',
			'getUserEditsStatus',
			'setFirstEmailSentFlag',
			'getFirstEmailSentFlag',
			'process',
			'getEventData',
		] );
		$mockFounderEmailsEditEvent::staticExpects( $this->any() )
			->method( 'getUserEditsStatus' )
			->will( $this->returnValue( FounderEmailsEditEvent::FIRST_EDIT ) );
		$mockFounderEmailsEditEvent::staticExpects( $this->once() )
			->method( 'getEventData' )
			->with( $this->anything(), $this->anything(), true, true );
		$mockFounderEmailsEditEvent::staticExpects( $this->any() )
			->method( 'getFirstEmailSentFlag' )
			->will( $this->returnValue( false ) );
		$mockFounderEmailsEditEvent::staticExpects( $this->once() )
			->method( 'setFirstEmailSentFlag' );
		$mockFounderEmailsEditEvent->expects( $this->any() )->method( 'process' )
			->will( $this->returnValue( null ) );
		$this->mockClass( 'FounderEmailsEditEvent', $mockFounderEmailsEditEvent );

		$mockRecentChange = $this->getMockRecentChange();

		// Test execution
		$mockFounderEmailsEditEvent::register( $mockRecentChange );
	}

	/**
	 * @group Slow
	 * @group Broken
	 * @slowExecutionTime 0.02432 ms
	 * edit after first, no throttle placed:
	 * $isRegisteredUser should be set to true,
	 * $isRegisteredUserFirstEdit should be set to false,
	 * setFirstEmailSentFlag should be called
	 */
	public function testRegisterForMultipleEdits() {
		// Test setup
		global $wgUser;
		$mockUser = $this->getMockUser();
		$wgUser = $mockUser;

		$mockFounderEmailsEditEvent = $this->getMock( 'FounderEmailsEditEvent', [
			'__construct',
			'getUserEditsStatus',
			'setFirstEmailSentFlag',
			'getFirstEmailSentFlag',
			'process',
			'getEventData',
		] );
		$mockFounderEmailsEditEvent::staticExpects( $this->any() )
			->method( 'getUserEditsStatus' )
			->will( $this->returnValue( FounderEmailsEditEvent::MULTIPLE_EDITS ) );
		$mockFounderEmailsEditEvent::staticExpects($this->once())
			->method( 'getEventData' )
			->with( $this->anything(), $this->anything(), true, false );
		$mockFounderEmailsEditEvent::staticExpects( $this->any() )
			->method( 'getFirstEmailSentFlag' )
			->will( $this->returnValue( false ) );
		$mockFounderEmailsEditEvent::staticExpects( $this->once() )
			->method('setFirstEmailSentFlag');
		$mockFounderEmailsEditEvent->expects( $this->any() )->method( 'process' )
			->will( $this->returnValue( null ) );
		$this->mockClass('FounderEmailsEditEvent', $mockFounderEmailsEditEvent);

		$mockRecentChange = $this->getMockRecentChange();

		// Test execution
		$mockFounderEmailsEditEvent::register( $mockRecentChange );
	}

	/**
	 * @group Broken
	 * No edits outside of profile page;
	 * founder email event should not be created;
	 * setFirstEmailSentFlag should NOT be called
	 */
	public function testRegisterForNoEdits() {
		// Test setup
		global $wgUser;
		$mockUser = $this->getMockUser();
		$wgUser = $mockUser;

		$mockFounderEmailsEditEvent = $this->getMock('FounderEmailsEditEvent', [
			'__construct',
			'getUserEditsStatus',
			'setFirstEmailSentFlag',
			'getFirstEmailSentFlag',
			'process',
			'getEventData',
		] );
		$mockFounderEmailsEditEvent::staticExpects( $this->any() )
			->method( 'getUserEditsStatus' )
			->will( $this->returnValue( FounderEmailsEditEvent::NO_EDITS ) );
		$mockFounderEmailsEditEvent->expects( $this->any() )->method( 'process' )
			->will( $this->returnValue( null ) );
		$mockFounderEmailsEditEvent::staticExpects( $this->never() )
			->method( 'getEventData' );
		$mockFounderEmailsEditEvent::staticExpects( $this->any() )
			->method( 'getFirstEmailSentFlag' )
			->will( $this->returnValue( false ) );
		$mockFounderEmailsEditEvent::staticExpects( $this->never() )
			->method( 'setFirstEmailSentFlag' );
		$this->mockClass( 'FounderEmailsEditEvent', $mockFounderEmailsEditEvent );

		$mockRecentChange = $this->getMockRecentChange();

		// Test execution
		$mockFounderEmailsEditEvent::register( $mockRecentChange );
	}

	/**
	 * @group Slow
	 * @group Broken
	 * @slowExecutionTime 0.02371 ms
	 * getFirstEmailSentFlag will return true
	 * $isRegisteredUser should be set to true,
	 * $isRegisteredUserFirstEdit should be set to false,
	 */
	public function testRegisterForUserWithFlag() {
		// Test setup
		global $wgUser;
		$mockUser = $this->getMockUser();
		$wgUser = $mockUser;

		$mockFounderEmailsEditEvent = $this->getMock('FounderEmailsEditEvent', [
			'__construct',
			'getUserEditsStatus',
			'setFirstEmailSentFlag',
			'getFirstEmailSentFlag',
			'process',
			'getEventData',
		] );

		$mockFounderEmailsEditEvent::staticExpects( $this->any() )
			->method( 'getUserEditsStatus' )
			->will( $this->returnValue( FounderEmailsEditEvent::NO_EDITS ) );
		$mockFounderEmailsEditEvent->expects( $this->any() )->method( 'process' )
			->will( $this->returnValue( null ) );
		$mockFounderEmailsEditEvent::staticExpects( $this->once() )
			->method( 'getEventData' )
			->with( $this->anything(), $this->anything(), true, false );
		$mockFounderEmailsEditEvent::staticExpects( $this->any() )
			->method( 'getFirstEmailSentFlag' )
			->will( $this->returnValue( '1' ) );
		$mockFounderEmailsEditEvent::staticExpects( $this->never() )
			->method( 'setFirstEmailSentFlag' );
		$this->mockClass( 'FounderEmailsEditEvent', $mockFounderEmailsEditEvent );

		$mockRecentChange = $this->getMockRecentChange();

		// Test execution
		$mockFounderEmailsEditEvent::register( $mockRecentChange );
	}

	public function getAttributeCallback( $param ) {
		if ( $param == 'rc_user' ) {
			return self::MOCKED_USER_ID;
		}
	}

	private function getMockUser() {
		$mockUser = $this->getMock( 'User', [ 'newFromId', 'getId', 'getOption', 'setOption' ] );
		$mockUser->expects( $this->any() )->method( 'newFromId' )->will( $this->returnSelf() );
		$mockUser->expects( $this->any() )->method( 'getId' )->will( $this->returnValue( self::MOCKED_USER_ID ) );

		return $mockUser;
	}

	private function getMockRecentChange() {
		$mockRecentChange = $this->getMock( 'RecentChange', [ 'getAttribute' ] );
		$mockRecentChange->expects( $this->any() )->method( 'getAttribute' )
			->will( $this->returnCallback( [ $this, 'getAttributeCallback' ] )
			);
		return $mockRecentChange;
	}
}
