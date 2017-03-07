<?php


class ARecoveryModuleTest extends WikiaBaseTest {
	const BOOTSTRAP_CODE = 'BOOTSTRAP_CODE';

	public function getUser( $isLoggedIn ) {
		$stubs = $this->getMockBuilder( User::class )->getMock();
		$stubs->method( 'isLoggedIn' )
			->willReturn( $isLoggedIn );
		return $stubs;
	}

	public function getData() {
		// User is logged in, SPRecoveryEnabled, SPMMSEnabled, isDisabled (expected value)
		return [
			// User is not logged in
			[false, false, false, true],
			[false, false, true, false],
			[false, true, false, false],
			[false, true, true, false],
			[false, null, null, false],
			[false, false, null, false],

			// User is logged in
			[true, true, false, true],
			[true, false, false, true],
		];
	}

	/**
	 * @dataProvider getData
	 *
	 * @param $isLoggedIn boolean
	 * @param $wgAdDriverEnableSourcePointRecovery
	 * @param $wgAdDriverEnableSourcePointMMS
	 * @param $expected boolean - is SourcePoint recovery disabled
	 */
	public function testSourcePointRecoveryDisabled( $isLoggedIn, $wgAdDriverEnableSourcePointRecovery, $wgAdDriverEnableSourcePointMMS, $expected ) {
		$this->mockGlobalVariable( 'wgUser', $this->getUser( $isLoggedIn ) );
		$this->mockGlobalVariable( 'wgAdDriverEnableSourcePointRecovery', $wgAdDriverEnableSourcePointRecovery );
		$this->mockGlobalVariable( 'wgAdDriverEnableSourcePointMMS', $wgAdDriverEnableSourcePointMMS );

		$this->assertEquals( $expected, (new ARecoveryModule())->isSourcePointRecoveryDisabled() );
	}
}
