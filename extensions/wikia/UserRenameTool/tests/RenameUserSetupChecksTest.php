<?php

/**
 * @group RenameUser
 */
class RenameUserSetupChecksTest extends WikiaBaseTest {

	/**
	 * @param string $destName
	 * @param bool $expectedResult
	 * @dataProvider spoofUserDataProvider
	 */
	function testSpoofUser( string $destName, bool $expectedResult ) {
		$process = new RenameUserProcess( 'Sannse', $destName, true );

		// mock anti-spoof
		$this->mockClassWithMethods(SpoofUser::class, [
			'getConflicts' => $expectedResult ? [] : [ 'foo' ]
		]);

		// perform initial checks for user rename process
		$this->assertEquals( $expectedResult, $process->setup() );

		if ( $expectedResult ) {
			// no warnings or errors should be reported
			$this->assertEmpty( $process->getWarnings() );
			$this->assertEmpty( $process->getErrors() );
		}
		else {
			/* @var Message $msg */
			// AntiSpoof warning - there is already a username similar to "WikiaB0t".
			$msg = $process->getErrors()[0];
			$this->assertContains( 'AntiSpoof', (string) $msg );
		}
	}

	function spoofUserDataProvider() {
		return [
			[ 'WikiaB0t', false ],
			[ 'FooBar123', true ],
		];
	}
}
