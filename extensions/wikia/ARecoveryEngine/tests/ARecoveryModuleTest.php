<?php


class ARecoveryModuleTest extends WikiaBaseTest {
	const BOOTSTRAP_CODE = 'BOOTSTRAP_CODE';

	public function getUser( $isAnon ) {
		$stubs = $this->getMockBuilder( User::class )->getMock();
		$stubs->method( 'isAnon' )
			->willReturn( $isAnon );
		return $stubs;
	}

	public function getDataSP() {
		// isAnon, SPRecoveryEnabled, SPMMSEnabled, isEnabled (expected value)
		return [
			// User is not logged in
			[true, false, false, false],
			[true, false, true, true],
			[true, false, null, false],
			[true, true, false, true],
			[true, true, true, true],
			[true, null, null, false],

			// User is logged in
			[false, true, false, false],
			[false, false, false, false]
		];
	}

	/**
	 * @dataProvider getDataSP
	 *
	 * @param $isAnon boolean
	 * @param $wgAdDriverEnableSourcePointRecovery
	 * @param $wgAdDriverEnableSourcePointMMS
	 * @param $expected boolean - is SourcePoint recovery enabled
	 */
	public function testSourcePointRecoveryDisabled( $isAnon, $wgAdDriverEnableSourcePointRecovery, $wgAdDriverEnableSourcePointMMS, $expected ) {
		$this->mockGlobalVariable( 'wgUser', $this->getUser( $isAnon ) );
		$this->mockGlobalVariable( 'wgAdDriverEnableSourcePointRecovery', $wgAdDriverEnableSourcePointRecovery );
		$this->mockGlobalVariable( 'wgAdDriverEnableSourcePointMMS', $wgAdDriverEnableSourcePointMMS );

		$this->assertEquals( $expected, (new ARecoveryModule())->isSourcePointRecoveryEnabled() );
	}

	public function getDataPF() {
		// isAnon, $wgAdDriverEnablePageFairRecovery, isOasis, isEnabled (expected value)
		return [
			// User is not logged in
			[true, false, true, false],
			[true, true, true, true],
			[true, null, true, false],
			[true, true, false, false],

			// User is logged in
			[false, true, true, false],
			[false, false, true, false],
		];
	}

	/**
	 * @dataProvider getDataPF
	 *
	 * @param $isAnon boolean
	 * @param $wgAdDriverEnablePageFairRecovery
	 * @param $isOasis
	 * @param $expected boolean - is PageFair recovery enabled
	 */
	public function testPageFairRecoveryDisabled( $isAnon, $wgAdDriverEnablePageFairRecovery, $isOasis, $expected ) {
		$this->mockGlobalVariable( 'wgUser', $this->getUser( $isAnon ) );
		$this->mockGlobalVariable( 'wgAdDriverEnablePageFairRecovery', $wgAdDriverEnablePageFairRecovery );
		$this->mockStaticMethod( 'WikiaApp', 'checkSkin', $isOasis );

		$this->assertEquals( $expected, (new ARecoveryModule())->isPageFairRecoveryEnabled() );
	}
}
