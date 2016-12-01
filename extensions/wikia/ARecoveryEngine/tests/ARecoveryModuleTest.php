<?php


class ARecoveryModuleTest extends WikiaBaseTest {
	const BOOTSTRAP_CODE = 'BOOTSTRAP_CODE';

	public function getUser($isLoggedIn ) {
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

			// User is logged in
			[true, true, true, true],
			[true, false, false, true],
		];
	}

	/**
	 * @dataProvider getData
	 *
	 * @param $userLoggedIn boolean - current user is loggedIn
	 * @param $recoveryEnabled boolean - $wgAdDriverEnableSourcePointRecovery
	 * @param $MMSEnabled boolean - $wgAdDriverEnableSourcePointMMS
	 * @param $expected boolean - is recovery disabled
	 */
	public function testRecoveryDisabled($userLoggedIn, $recoveryEnabled, $MMSEnabled, $expected ) {
		$this->mockGlobalVariable( 'wgUser', $this->getUser( $userLoggedIn ) );
		$this->mockGlobalVariable( 'wgAdDriverEnableSourcePointRecovery', $recoveryEnabled );
		$this->mockGlobalVariable( 'wgAdDriverEnableSourcePointMMS', $MMSEnabled );

		$this->assertEquals( $expected, ARecoveryModule::isDisabled() );
	}

	/**
	 * @dataProvider getData
	 *
	 * @param $userLoggedIn
	 * @param $recoveryEnabled
	 * @param $MMSEnabled
	 * @param $isDisabled
	 */
	public function testSourcePointCode($userLoggedIn, $recoveryEnabled, $MMSEnabled, $isDisabled ) {
		$this->mockGlobalVariable( 'wgUser', $this->getUser( $userLoggedIn ) );
		$this->mockGlobalVariable( 'wgAdDriverEnableSourcePointRecovery', $recoveryEnabled );
		$this->mockGlobalVariable( 'wgAdDriverEnableSourcePointMMS', $MMSEnabled );

		$this->mockStaticMethod(WikiaApp::class, 'sendRequest', self::BOOTSTRAP_CODE);

		$expectedValue = $isDisabled ? ARecoveryModule::DISABLED_MESSAGE : self::BOOTSTRAP_CODE;
		$this->assertEquals( $expectedValue , ARecoveryModule::getSourcePointBootstrapCode() );
	}
}
