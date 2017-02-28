<?php

class CommunityPageSpecialUsersModelTest extends WikiaBaseTest {

	protected function setUp() {
		$this->setupFile = __DIR__ . '/../CommunityPage.setup.php';
		parent::setUp();
	}

	/**
	 * @param int $userId
	 * @param array $admins
	 * @param boolean $expectedResult
	 *
	 * @dataProvider testIsAdminDataProvider
	 */
	public function testIsAdmin( $userId, $admins, $expectedResult ) {
		$mockUser = $this->getMock( 'User' );
		$model = new CommunityPageSpecialUsersModel( $mockUser );
		$this->assertEquals( $expectedResult, $model->isAdmin( $userId, $admins ) );
	}

	public function testIsAdminDataProvider() {
		return [
			[ 1, [ 1, 2, 3 ] , true ],
			[ 1, [ 2, 3 ] , false ],
			[ 1, [] , false ],
			[ 1, [ 1 ] , true ],
		];
	}
}
