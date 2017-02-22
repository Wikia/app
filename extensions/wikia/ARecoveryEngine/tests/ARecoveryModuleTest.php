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
			[false, false, false, false],
			[false, false, true, false],
			[false, true, false, true],
			[false, true, true, false],

			// User is logged in
			[true, true, false, false],
			[true, false, false, false],
		];
	}

	/**
	 * @dataProvider getData
	 *
	 * @param $isLoggedIn boolean
	 * @param $hasSourcePointDisabledWgVars
	 * @param $hasPageFairDisabledWgVars
	 * @param $expected boolean - is SourcePoint recovery disabled
	 */
	public function testSourcePointRecoveryDisabled( $isLoggedIn, $hasSourcePointDisabledWgVars, $hasPageFairDisabledWgVars, $expected ) {
		$this->mockGlobalVariable( 'wgUser', $this->getUser( $isLoggedIn ) );

		$object = $this->getMockBuilder('ARecoveryModule')
			->setMethods(['hasPageFairDisabledWgVars', 'hasSourcePointDisabledWgVars'])
			->getMock();
		$object->expects($this->any())
			->method('hasPageFairDisabledWgVars')
			->will($this->returnValue($hasPageFairDisabledWgVars));
		$object->expects($this->any())
			->method('hasSourcePointDisabledWgVars')
			->will($this->returnValue($hasSourcePointDisabledWgVars));

		$this->assertEquals( $expected, $object->isSourcePointRecoveryDisabled() );
	}
}
