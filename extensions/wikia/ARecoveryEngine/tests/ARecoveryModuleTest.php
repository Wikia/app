<?php


class ARecoveryModuleTest extends WikiaBaseTest {
	const BOOTSTRAP_CODE = 'BOOTSTRAP_CODE';

	public function getUser( $isLoggedIn ) {
		$stubs = $this->getMockBuilder( User::class )->getMock();
		$stubs->method( 'isLoggedIn' )
			->willReturn( $isLoggedIn );
		return $stubs;
	}

	public function getDataSP() {
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
			[true, false, false, true]
		];
	}

	/**
	 * @dataProvider getDataSP
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

	public function getDataPF() {
		// User is logged in, $wgAdDriverEnablePageFairRecovery, isOasis, isDisabled (expected value)
		return [
			// User is not logged in
			[false, false, true, true],
			[false, true, true, false],
			[false, null, true, false],
			[false, false, false, true],

			// User is logged in
			[true, true, true, true],
			[true, false, true, true],
		];
	}

	/**
	 * @dataProvider getDataPF
	 *
	 * @param $isLoggedIn boolean
	 * @param $wgAdDriverEnablePageFairRecovery
	 * @param $isOasis
	 * @param $expected boolean - is PageFair recovery disabled
	 */
	public function testPageFairRecoveryDisabled( $isLoggedIn, $wgAdDriverEnablePageFairRecovery, $isOasis, $expected ) {
		$this->mockGlobalVariable( 'wgUser', $this->getUser( $isLoggedIn ) );
		$this->mockGlobalVariable( 'wgAdDriverEnablePageFairRecovery', $wgAdDriverEnablePageFairRecovery );
		$this->mockStaticMethod( 'WikiaApp', 'checkSkin', $isOasis );

		$this->assertEquals( $expected, (new ARecoveryModule())->isPageFairRecoveryDisabled() );
	}
}
