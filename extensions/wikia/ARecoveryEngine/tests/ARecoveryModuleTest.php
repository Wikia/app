<?php


class ARecoveryModuleTest extends WikiaBaseTest {
	const BOOTSTRAP_CODE = 'BOOTSTRAP_CODE';

	public function getUser( $isAnon ) {
		$stubs = $this->getMockBuilder( User::class )->getMock();
		$stubs->method( 'isAnon' )
			->willReturn( $isAnon );
		return $stubs;
	}

	public function getData() {
		// User is logged in, SPRecoveryEnabled, SPMMSEnabled, isDisabled (expected value)
		return [
			// User is not logged in
			[true, false, false, false],
			[true, false, true, false],
			[true, true, false, true],
			[true, true, true, false],

			// User is logged in
			[false, true, true, false],
			[false, false, false, false],
		];
	}

	/**
	 * @dataProvider getData
	 *
	 * @param $isAnon boolean - current user is loggedIn
	 * @param $hasSourcePointEnabledWgVars
	 * @param $hasPageFairEnabledWgVars
	 * @param $expected boolean - is SourcePoint recovery enabled
	 */
	public function testSourcePointRecoveryEnabled($isAnon, $hasSourcePointEnabledWgVars, $hasPageFairEnabledWgVars, $expected ) {
		$this->mockGlobalVariable( 'wgUser', $this->getUser( $isAnon ) );

		$object = $this->getMockBuilder('ARecoveryModule')
			->setMethods(['hasPageFairEnabledWgVars', 'hasSourcePointEnabledWgVars'])
			->getMock();
		$object->expects($this->any())
			->method('hasPageFairEnabledWgVars')
			->will($this->returnValue($hasPageFairEnabledWgVars));
		$object->expects($this->any())
			->method('hasSourcePointEnabledWgVars')
			->will($this->returnValue($hasSourcePointEnabledWgVars));

		$this->assertEquals( $expected, $object->isSourcePointRecoveryEnabled() );
	}
}
