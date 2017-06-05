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
		// isAnon, SPRecoveryEnabled, isEnabled (expected value)
		return [
			// User is not logged in
			[true, false, false],
			[true, true, true],

			// User is logged in
			[false, true, false],
			[false, false, false]
		];
	}

	/**
	 * @dataProvider getDataSP
	 *
	 * @param $isAnon boolean
	 * @param $wgAdDriverEnableSourcePointRecovery
	 * @param $expected boolean - is SourcePoint recovery enabled
	 */
	public function testSourcePointRecoveryDisabled( $isAnon, $wgAdDriverEnableSourcePointRecovery, $expected ) {
		$this->mockGlobalVariable( 'wgUser', $this->getUser( $isAnon ) );
		$this->mockGlobalVariable( 'wgAdDriverEnableSourcePointRecovery', $wgAdDriverEnableSourcePointRecovery );
		$this->mockStaticMethod( 'WikiaApp', 'checkSkin', true );

		$this->assertEquals( $expected, ARecoveryModule::isSourcePointRecoveryEnabled() );
	}

	/**
	 * @dataProvider getDataSP
	 *
	 * @param $isAnon boolean
	 * @param $wgAdDriverEnableSourcePointMMS
	 * @param $expected boolean - is SourcePoint messaging enabled
	 */
	public function testSourcePointMessagingDisabled( $isAnon, $wgAdDriverEnableSourcePointMMS, $expected ) {
		$this->mockGlobalVariable( 'wgAdDriverEnableSourcePointRecovery', false );
		$this->mockGlobalVariable( 'wgUser', $this->getUser( $isAnon ) );
		$this->mockGlobalVariable( 'wgAdDriverEnableSourcePointMMS', $wgAdDriverEnableSourcePointMMS );
		$this->mockStaticMethod( 'WikiaApp', 'checkSkin', true );

		$this->assertEquals( $expected, ARecoveryModule::isSourcePointMessagingEnabled() );
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

		$this->assertEquals( $expected, ARecoveryModule::isPageFairRecoveryEnabled() );
	}
}
