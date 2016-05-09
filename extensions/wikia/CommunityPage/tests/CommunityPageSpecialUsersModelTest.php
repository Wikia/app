<?php
require_once( $IP . '/extensions/wikia/CommunityPage/models/CommunityPageSpecialUsersModel.class.php' );

class CommunityPageSpecialUsersModelTest extends WikiaBaseTest {
	/**
	 * @param string $userGroups
	 * @param boolean $expectedResult
	 *
	 * @dataProvider testIsAdminDataProvider
	 */
	public function testIsAdmin( $userGroups, $expectedResult ) {
		$this->assertEquals( $expectedResult, ( new CommunityPageSpecialUsersModel )->isAdmin( $userGroups ) );
	}

	public function testIsAdminDataProvider() {
		return [
			[ 'sysop', true ],
			[ '', false ],
			[ 'foo sysop', true ],
			[ 'sysop foo', true ],
			[ 'foo sysop bar', true ],
		];
	}
}
