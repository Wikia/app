<?php
require_once( $IP . '/extensions/wikia/CommunityPage/models/CommunityPageSpecialUsersModel.class.php' );

class CommunityPageSpecialUsersModelTest extends WikiaBaseTest {
	/**
	 * @param int $userId
	 * @param array $admins
	 * @param boolean $expectedResult
	 *
	 * @dataProvider testIsAdminDataProvider
	 */
	public function testIsAdmin( $userId, $admins, $expectedResult ) {
		$model = new CommunityPageSpecialUsersModel( $this->getMock( 'WikiService' ) );
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
