<?php
use PHPUnit\Framework\TestCase;

class CommunityPageSpecialUsersModelTest extends TestCase {

	protected function setUp() {
		parent::setUp();
		require_once __DIR__ . '/../models/CommunityPageSpecialUsersModel.class.php';
	}

	/**
	 * @param int $userId
	 * @param array $admins
	 * @param boolean $expectedResult
	 *
	 * @dataProvider isAdminDataProvider
	 */
	public function testIsAdmin( $userId, $admins, $expectedResult ) {
		$model = new CommunityPageSpecialUsersModel();
		$this->assertEquals( $expectedResult, $model->isAdmin( $userId, $admins ) );
	}

	public function isAdminDataProvider() {
		return [
			[ 1, [ 1, 2, 3 ] , true ],
			[ 1, [ 2, 3 ] , false ],
			[ 1, [] , false ],
			[ 1, [ 1 ] , true ],
		];
	}
}
