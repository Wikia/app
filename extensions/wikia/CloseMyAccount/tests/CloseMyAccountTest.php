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
		$userMock = $this->getMock( 'User', [ 'getOption' ] );

		$userMock->expects( $this->once() )
			->method( 'getOption' )
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
	public function testReactivateAccountReturnValues( $expected, $getOptionMap ) {
		$userMock = $this->getMock( 'User', [ 'getOption' ] );

		$userMock->expects( $this->any() )
			->method( 'getOption' )
			->will( $this->returnValueMap( $getOptionMap ) );

		$closeAccountHelper = new CloseMyAccountHelper();

		$result = $closeAccountHelper->reactivateAccount( $userMock );

		$this->assertEquals( $expected, $result );

	}

	public function reactivateAccountProvider() {
		return [
			[ false, [
				[ 'requested-closure', false, false, 1 ],
				[ 'requested-closure-date', false, false, wfTimestamp( TS_DB ) ],
				[ 'disabled', false, false, 1 ],
			] ],
			[ false, [
				[ 'requested-closure', false, false, 0 ],
				[ 'requested-closure-date', false, false, false ],
				[ 'disabled', false, false, 0 ],
			] ],
			[ false, [
				[ 'requested-closure', false, false, 0 ],
				[ 'requested-closure-date', false, false, false ],
				[ 'disabled', false, false, 1 ],
			] ],
			[ true, [
				[ 'requested-closure', false, false, 1 ],
				[ 'requested-closure-date', false, false, wfTimestamp( TS_DB ) ],
				[ 'disabled', false, false, 0 ],
			] ],
		];
	}

	/**
	 * @dataProvider isScheduledProvider
	 */
	public function testIsScheduledForClosure( $expected, $getOptionMap ) {
		$userMock = $this->getMock( 'User', [ 'getOption' ] );

		$userMock->expects( $this->any() )
			->method( 'getOption' )
			->will( $this->returnValueMap( $getOptionMap ) );

		$closeAccountHelper = new CloseMyAccountHelper();

		$result = $closeAccountHelper->isScheduledForClosure( $userMock );

		$this->assertEquals( $expected, $result );
	}

	public function isScheduledProvider() {
		return [
			[ true, [
				[ 'requested-closure', false, false, 1 ],
				[ 'requested-closure-date', false, false, wfTimestamp( TS_DB ) ],
			] ],
			[ false, [
				[ 'requested-closure', false, false, 0 ],
				[ 'requested-closure-date', false, false, wfTimestamp( TS_DB ) ],
			] ],
			[ false, [
				[ 'requested-closure', false, false, 1 ],
				[ 'requested-closure-date', false, false, false ],
			] ],
		];
	}

	public function testIsClosed() {
		$userMock = $this->getMock( 'User', [ 'getOption' ] );

		$userMock->expects( $this->exactly( 2 ) )
			->method( 'getOption' )
			->with( $this->equalTo( 'disabled' ) )
			->will( $this->onConsecutiveCalls( 1, 0 ) );

		$closeAccountHelper = new CloseMyAccountHelper();
		$resultOne = $closeAccountHelper->isClosed( $userMock );

		$this->assertTrue( $resultOne );

		$resultTwo = $closeAccountHelper->isClosed( $userMock );

		$this->assertFalse( $resultTwo );
	}

}
