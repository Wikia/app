<?php

class ExactTargetUserUpdateDriverTest extends WikiaBaseTest {

	public function setUp() {
		$this->setupFile = __DIR__ . '/../../ExactTargetUpdates.setup.php';
		parent::setUp();
	}

	/**
	 * @dataProvider editsDataProvider
	 */
	public function testSumUp( $first, $second, $expected ) {
		$result = \Wikia\ExactTarget\ExactTargetUserUpdateDriver::sumUpEdits( $first, $second );
		$this->assertEquals( $expected, $result );
	}

	public function editsDataProvider() {
		return [
			[ [ ], [ ], [ ] ],
			[ [ 1 => [ 1 => 1 ] ], [ ], [ 1 => [ 1 => 1 ] ] ],
			[ [ 1 => [ 1 => 1 ] ], [ 1 => [ 1 => 1 ] ], [ 1 => [ 1 => 2 ] ] ],
			[ [ 1 => [ 1 => 1 ] ], [ 2 => [ 1 => 1 ] ], [ 1 => [ 1 => 1 ], 2 => [ 1 => 1 ] ] ],
			[ [ 1 => [ 1 => 1 ], 3 => [ 1 => 1 ] ], [ 1 => [ 1 => 1 ], 2 => [ 1 => 1 ] ],
			  [ 1 => [ 1 => 2 ], 2 => [ 1 => 1 ], 3 => [ 1 => 1 ] ] ],
			[ null, null, [ ] ],
		];
	}

	/**
	 * @dataProvider shouldCreateProvider
	 */
	public function testShouldCreate( $oldEmail, $newEmail, $expected ) {
		$this->assertEquals(
			$expected,
			\Wikia\ExactTarget\ExactTargetUserUpdateDriver::shouldCreateAsEmailChanged( $oldEmail, $newEmail )
		);
	}

	/**
	 * @dataProvider shouldDeleteProvider
	 */
	public function testShouldDelete( $oldEmail, $newEmail, $expected ) {
		$this->assertEquals(
			$expected,
			\Wikia\ExactTarget\ExactTargetUserUpdateDriver::shouldDeleteAsEmailChanged( $oldEmail, $newEmail )
		);
	}

	/**
	 * @dataProvider isUsedProvider
	 */
	public function testIsUsed( $email, $usedBy, $expected ) {
		$this->assertEquals(
			$expected,
			\Wikia\ExactTarget\ExactTargetUserUpdateDriver::isUsed( $email, $usedBy )
		);
	}

	public function shouldCreateProvider() {
		return [
			[ 'equal@test.com', 'equal@test.com', false ],
			[ 'old@test.com', 'new@test.com', true ],
			[ '', 'new@test.com', true ],
			[ '', 'new@test.com', true ],
			[ '', '', false ],
			[ 'old@test.com', '', false ]
		];
	}

	public function shouldDeleteProvider() {
		return [
			[ 'equal@test.com', 'equal@test.com', false ],
			[ 'old@test.com', 'new@test.com', true ],
			[ '', 'new@test.com', false ],
			[ '', 'new@test.com', false ],
			[ '', '', false ],
			[ 'old@test.com', '', true ]
		];
	}

	public function isUsedProvider() {
		return [
			[ 1, [ ], false ],
			[ 1, [ 1 ], false ],
			[ 1, [ 2 ], true ],
			[ 1, [ 1, 2 ], true ],
			[ 1, [ 2, 1 ], true ],
		];
	}

}
