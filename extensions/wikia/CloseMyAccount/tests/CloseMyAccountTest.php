<?php

/**
 * Some basic tests for CloseMyAccountHelper
 */
class CloseMyAccountTest extends WikiaBaseTest {

	public function setUp() {
		$this->setupFile = __DIR__ . '/../CloseMyAccount.setup.php';
		parent::setUp();
	}

	/**
	 * @covers CloseMyAccountHelper::getDaysUntilClosure()
	 * @dataProvider getDaysUntilClosureProvider
	 *
	 * @param $expected
	 * @param $getOptionValue
	 */
	public function testGetDaysUntilClosure( $expected, $getOptionValue ) {
		/** @var User|PHPUnit_Framework_MockObject_MockObject $userMock */
		$userMock = $this->getMockBuilder( User::class )
			->setMethods( [ 'getGlobalPreference' ] )
			->getMock();

		$userMock->expects( $this->once() )
			->method( 'getGlobalPreference' )
			->with( $this->equalTo( CloseMyAccountHelper::REQUEST_CLOSURE_PREF  ) )
			->will( $this->returnValue( $getOptionValue ) );

		$closeAccountHelper = new CloseMyAccountHelper();

		$result = $closeAccountHelper->getDaysUntilClosure( $userMock );

		$this->assertEquals( $expected, $result );
	}

	public function getDaysUntilClosureProvider() {
		return [
			[ 30, wfTimestamp( TS_DB ) ],
			[ 16, wfTimestamp( TS_DB, strtotime( '-2 weeks' ) ) ],
			[ 1, wfTimestamp( TS_DB, strtotime( '-29 days' ) ) ],
			[ 0, wfTimestamp( TS_DB, strtotime( '-30 days' ) ) ],
			[ 0, wfTimestamp( TS_DB, strtotime( '-34 days' ) ) ],
			[ false, null ],
		];
	}

	/**
	 * @covers CloseMyAccountHelper::reactivateAccount()
	 * @dataProvider reactivateAccountProvider
	 *
	 * @param $expected
	 * @param $isScheduledForClosure
	 * @param $isClosed
	 */
	public function testReactivateAccountReturnValues( $expected, $isScheduledForClosure, $isClosed ) {
		/** @var User|PHPUnit_Framework_MockObject_MockObject $userMock */
		$userMock = $this->getMockBuilder( User::class )
			->setMethods( [ 'setOption', 'saveSettings' ] )
			->getMock();

		/** @var CloseMyAccountHelper|PHPUnit_Framework_MockObject_MockObject $helperMock */
		$helperMock = $this->getMockBuilder( CloseMyAccountHelper::class )
			->setMethods( [ 'isClosed', 'isScheduledForClosure', 'track' ] )
			->getMock();

		$helperMock->expects( $this->any() )
			->method( 'isClosed' )
			->will( $this->returnValue( $isClosed ) );

		$helperMock->expects( $this->any() )
			->method( 'isScheduledForClosure' )
			->will( $this->returnValue( $isScheduledForClosure ) );

		$helperMock->expects( $this->any() )
			->method( 'track' );

		$result = $helperMock->reactivateAccount( $userMock );

		$this->assertEquals( $expected, $result );
	}

	public function reactivateAccountProvider() {
		return [
			[ false, true, true ],
			[ false, false, false ],
			[ false, false, true ],
			[ true, true, false ],
		];
	}

	/**
	 * @covers CloseMyAccountHelper::requestReactivation()
	 * @dataProvider requestReactivationProvider
	 *
	 * @param $expected
	 * @param $isScheduledForClosure
	 * @param $isEmailConfirmed
	 * @param $sendConfirmationMailStatus
	 */
	public function testRequestReactivation( $expected, $isScheduledForClosure, $isEmailConfirmed, $sendConfirmationMailStatus ) {
		/** @var User|PHPUnit_Framework_MockObject_MockObject $userMock */
		$userMock = $this->getMockBuilder( User::class )
			->setMethods( [ 'isEmailConfirmed', 'sendConfirmationMail'	] )
			->getMock();

		$statusMock = $this->getMockBuilder( Status::class )
			->setMethods( [ 'isGood' ] )
			->getMock();

		$statusMock->expects( $this->any() )
			->method( 'isGood' )
			->will( $this->returnValue( $sendConfirmationMailStatus ) );

		$userMock->expects( $this->any() )
			->method( 'isEmailConfirmed' )
			->will( $this->returnValue( $isEmailConfirmed ) );

		$userMock->expects( $this->any() )
			->method( 'sendConfirmationMail' )
			->will( $this->returnValue( $statusMock ) );

		/** @var CloseMyAccountHelper|PHPUnit_Framework_MockObject_MockObject $helperMock */
		$helperMock = $this->getMockBuilder( CloseMyAccountHelper::class )
			->setMethods( [ 'isScheduledForClosure', 'track' ] )
			->getMock();

		$helperMock->expects( $this->once() )
			->method( 'isScheduledForClosure' )
			->will( $this->returnValue( $isScheduledForClosure ) );

		$helperMock->expects( $this->any() )
			->method( 'track' );

		$result = $helperMock->requestReactivation( $userMock );

		$this->assertEquals( $expected, $result );
	}

	public function requestReactivationProvider() {
		return [
			'not scheduled for closure and emailconfirmed' => [ false, false, true, null ],
			'scheduled for closure and not emailconfirmed' => [ false, true, false, null ],
			'not scheduled for closure and not emailconfirmed' => [ false, false, false, null ],
			'scheduled for closure, emailconfirmed, and email not sent' => [ false, true, true, false ],
			'scheduled for closure, emailconfirmed, and email sent' => [ true, true, true, true ],
		];
	}

	/**
	 * @covers CloseMyAccountHelper::isScheduledForClosure()
	 * @dataProvider isScheduledProvider
	 *
	 * @param $expected
	 * @param $requestedClosureDateMap
	 */
	public function testIsScheduledForClosure( $expected, $requestedClosureDateMap ) {
		/** @var User|PHPUnit_Framework_MockObject_MockObject $userMock */
		$userMock = $this->getMockBuilder( User::class )
			->setMethods( [ 'getGlobalPreference' ] )
			->getMock();

		$userMock->expects( $this->any() )
			->method( 'getGlobalPreference')
			->with( CloseMyAccountHelper::REQUEST_CLOSURE_PREF, false )
			->willReturn( $requestedClosureDateMap );

		$closeAccountHelper = new CloseMyAccountHelper();

		$result = $closeAccountHelper->isScheduledForClosure( $userMock );

		$this->assertEquals( $expected, $result );
	}

	public function isScheduledProvider() {
		return [
			[ true, wfTimestamp( TS_DB ) ],
			[ false, false ],
		];
	}

	/**
	 * @covers CloseMyAccountHelper::isClosed()
	 */
	public function testIsClosed() {
		/** @var User|PHPUnit_Framework_MockObject_MockObject $userMock */
		$userMock = $this->getMockBuilder( User::class )
			->setMethods( [ 'getGlobalFlag' ] )
			->getMock();

		$userMock->expects( $this->exactly( 2 ) )
			->method( 'getGlobalFlag' )
			->with( $this->equalTo( 'disabled' ) )
			->will( $this->onConsecutiveCalls( 1, 0 ) );

		$closeAccountHelper = new CloseMyAccountHelper();
		$resultOne = $closeAccountHelper->isClosed( $userMock );

		$this->assertTrue( $resultOne );

		$resultTwo = $closeAccountHelper->isClosed( $userMock );

		$this->assertFalse( $resultTwo );
	}
}
