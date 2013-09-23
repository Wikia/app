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

	public function testRegisterForFirstEdit() {
		// Test setup
		global $wgUser;
		$mockUser = $this->getMockUser();
		$mockUser->expects( $this->any() )->method( 'getOption' )->will( $this->returnValue(0) );
		$wgUser = $mockUser;

		$mockFounderEmailsEditEvent = $this->getMock('FounderEmailsEditEvent', [
			'__construct',
			'getUserEditsStatus',
			'process',
			'getEventData'
		] );
		$mockFounderEmailsEditEvent::staticExpects($this->any())
			->method('getUserEditsStatus')
			->will($this->returnValue(FounderEmailsEditEvent::FIRST_EDIT));
		$mockFounderEmailsEditEvent::staticExpects($this->once())
			->method('getEventData')
			->with($this->anything(), $this->anything(), $this->anything(), true);
		$mockFounderEmailsEditEvent->expects($this->any())->method('process')
			->will($this->returnValue(null));
		$this->mockClass('FounderEmailsEditEvent', $mockFounderEmailsEditEvent);

		$mockRecentChange = $this->getMockRecentChange();

		// Test execution
		$mockFounderEmailsEditEvent::register($mockRecentChange);
	}

	public function testRegisterForMultipleEdits() {
		// Test setup
		global $wgUser;
		$mockUser = $this->getMockUser();
		$mockUser->expects( $this->any() )->method( 'getOption' )->will( $this->returnValue(0) );
		$mockUser->expects( $this->once() )->method( 'setOption' )->with(
			$this->stringStartsWith(FounderEmailsEditEvent::FIRST_EDIT_NOTIFICATION_SENT_PROP_NAME),
			true
		)->will( $this->returnValue( 0 ) );
		$wgUser = $mockUser;

		$mockFounderEmailsEditEvent = $this->getMock('FounderEmailsEditEvent', [
			'__construct',
			'getUserEditsStatus',
			'process',
			'getEventData'
		] );
		$mockFounderEmailsEditEvent::staticExpects($this->any())
			->method('getUserEditsStatus')
			->will($this->returnValue(FounderEmailsEditEvent::MULTIPLE_EDITS));
		$mockFounderEmailsEditEvent::staticExpects($this->once())
			->method('getEventData')
			->with($this->anything(), $this->anything(), $this->anything(), false);
		$mockFounderEmailsEditEvent->expects($this->any())->method('process')
			->will($this->returnValue(null));
		$this->mockClass('FounderEmailsEditEvent', $mockFounderEmailsEditEvent);

		$mockRecentChange = $this->getMockRecentChange();

		// Test execution
		$mockFounderEmailsEditEvent::register($mockRecentChange);
	}

	public function testRegisterForNoEdits() {
		// Test setup
		global $wgUser;
		$mockUser = $this->getMockUser();
		$mockUser->expects( $this->any() )->method( 'getOption' )->will( $this->returnValue(0) );
		$mockUser->expects( $this->never() )->method( 'setOption' );
		$wgUser = $mockUser;

		$mockFounderEmailsEditEvent = $this->getMock('FounderEmailsEditEvent', [
			'__construct',
			'getUserEditsStatus',
			'process',
			'getEventData'
		] );
		$mockFounderEmailsEditEvent::staticExpects($this->any())
			->method('getUserEditsStatus')
			->will($this->returnValue(FounderEmailsEditEvent::NO_EDITS));
		$mockFounderEmailsEditEvent::staticExpects($this->once())
			->method('getEventData')
			->with($this->anything(), $this->anything(), $this->anything(), false);
		$mockFounderEmailsEditEvent->expects($this->any())->method('process')
			->will($this->returnValue(null));
		$this->mockClass('FounderEmailsEditEvent', $mockFounderEmailsEditEvent);

		$mockRecentChange = $this->getMockRecentChange();

		// Test execution
		$mockFounderEmailsEditEvent::register($mockRecentChange);
	}

	public function testRegisterForUserWithFlag() {
		// Test setup
		global $wgUser;
		$mockUser = $this->getMockUser();
		$mockUser->expects( $this->never() )->method( 'setOption' );
		$mockUser->expects( $this->any() )->method( 'getOption' )->will( $this->returnValue(1) );
		$wgUser = $mockUser;

		$mockFounderEmailsEditEvent = $this->getMock('FounderEmailsEditEvent', [
			'__construct',
			'getUserEditsStatus',
			'process',
			'getEventData'
		] );

		$mockFounderEmailsEditEvent::staticExpects($this->never())->method('getUserEditsStatus');
		$mockFounderEmailsEditEvent::staticExpects($this->never())->method('getEventData');
		$mockFounderEmailsEditEvent->expects($this->never())->method('process');
		$this->mockClass('FounderEmailsEditEvent', $mockFounderEmailsEditEvent);

		$mockRecentChange = $this->getMockRecentChange();

		// Test execution
		$mockFounderEmailsEditEvent::register($mockRecentChange);
	}

	public function getAttributeCallback($param) {
		if($param == 'rc_user') {
			return self::MOCKED_USER_ID;
		}
	}

	private function getMockUser() {
		$mockUser = $this->getMock( 'User', [ 'newFromId', 'getId', 'getOption', 'setOption' ] );
		$mockUser->expects( $this->any() )->method( 'newFromId' )->will( $this->returnSelf() );
		$mockUser->expects( $this->any() )->method( 'getId' )->will( $this->returnValue(self::MOCKED_USER_ID) );
		return $mockUser;
	}

	private function getMockRecentChange() {
		$mockRecentChange = $this->getMock('RecentChange', ['getAttribute']);
		$mockRecentChange->expects($this->any())->method('getAttribute')
			->will( $this->returnCallback( [ $this, 'getAttributeCallback' ] )
			);
		return $mockRecentChange;
	}
}
