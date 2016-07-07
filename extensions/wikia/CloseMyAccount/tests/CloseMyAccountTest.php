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
	 * @dataProvider getDaysUntilClosureProvider
	 */
	public function testGetDaysUntilClosure( $expected, $getOptionValue ) {
		$userMock = $this->getMock( 'User', [ 'getGlobalAttribute' ] );

		$userMock->expects( $this->once() )
			->method( 'getGlobalAttribute' )
			->with( $this->equalTo( 'requested-closure-date'  ) )
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
	 * @dataProvider reactivateAccountProvider
	 */
	public function testReactivateAccountReturnValues( $expected, $isScheduledForClosure, $isClosed ) {
		$userMock = $this->getMock( 'User', [ 'setOption', 'saveSettings' ] );

		$userMock->expects( $this->any() )
			->method( 'setOption' );

		$userMock->expects( $this->any() )
			->method( 'saveSettings' );

		$helperMock = $this->getMock( 'CloseMyAccountHelper', [ 'isClosed', 'isScheduledForClosure', 'track' ] );

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
	 * @dataProvider requestReactivationProvider
	 */
	public function testRequestReactivation( $expected, $isScheduledForClosure, $isEmailConfirmed, $sendConfirmationMailStatus ) {
		$userMock = $this->getMock( 'User', [ 'isEmailConfirmed', 'sendConfirmationMail' ] );
		$statusMock = $this->getMock( 'Status', [ 'isGood' ] );

		$statusMock->expects( $this->any() )
			->method( 'isGood' )
			->will( $this->returnValue( $sendConfirmationMailStatus ) );

		$userMock->expects( $this->any() )
			->method( 'isEmailConfirmed' )
			->will( $this->returnValue( $isEmailConfirmed ) );

		$userMock->expects( $this->any() )
			->method( 'sendConfirmationMail' )
			->will( $this->returnValue( $statusMock ) );

		$helperMock = $this->getMock( 'CloseMyAccountHelper', [ 'isScheduledForClosure', 'track' ] );

		$helperMock->expects( $this->once() )
			->method( 'isScheduledForClosure' )
			->will( $this->returnValue( $isScheduledForClosure ) );

		$helperMock->expects( $this->any() )
			->method( 'track' );

		$appMock = $this->getMock( 'WikiaApp', [ 'renderView' ] );
		$appMock->expects( $this->any() )
			->method( 'renderView' )
			->will( $this->returnValue( '' ) );

		$result = $helperMock->requestReactivation( $userMock, $appMock );

		$this->assertEquals( $expected, $result );
	}

	public function requestReactivationProvider() {
		return [
			[ false, false, true, null ],
			[ false, true, false, null ],
			[ false, false, false, null ],
			[ false, true, true, false ],
			[ true, true, true, true ],
		];
	}

	/**
	 * @dataProvider isScheduledProvider
	 */
	public function testIsScheduledForClosure( $expected, $requestedClosureMap, $requestedClosureDateMap ) {
		$userMock = $this->getMock( 'User', [ 'getGlobalPreference' ] );

		$userMock->expects( $this->any() )
			->method( 'getGlobalPreference')
			->with( 'requested-closure-date', false )
			->willReturn( $requestedClosureDateMap );

		$closeAccountHelper = new CloseMyAccountHelper();

		$result = $closeAccountHelper->isScheduledForClosure( $userMock );

		$this->assertEquals( $expected, $result );
	}

	public function isScheduledProvider() {
		return [
			[ true, 1, wfTimestamp( TS_DB ) ],
			[ false, 0, wfTimestamp( TS_DB ) ],
			[ false, 1, false ],
		];
	}

	public function testIsClosed() {
		$userMock = $this->getMock( 'User', [ 'getGlobalFlag' ] );

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
