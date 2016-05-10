<?php

class CommunityPageSpecialTopAdminsFormatterTest extends WikiaBaseTest {

	public function setUp() {
		$this->setupFile = __DIR__ . '/../CommunityPage.setup.php';
		parent::setUp();
	}

	/**
	 * @dataProvider adminsDataFormatProvider
	 */
	public function testAdminsDataFormat( $param, $result, $message ) {
		$this->assertEquals( CommunityPageSpecialTopAdminsFormatter::prepareData( $param ), $result, $message );
	}

	public function adminsDataFormatProvider() {
		return [
			[
				[ 'admin1', 'admin2', 'admin3', 'admin4' ],
				[
					'admins' => [ 'admin1', 'admin2' ],
					'otherAdminCount' => 2,
					'haveOtherAdmins' => true,
					'adminCount' => 4,
				],
				'For four users provided should return first two and info on remaining number'
			],
			[
				[ 'admin1', 'admin2', 'admin3' ],
				[
					'admins' => [ 'admin1', 'admin2', 'admin3' ],
					'otherAdminCount' => 0,
					'haveOtherAdmins' => false,
					'adminCount' => 3,
				],
				'For three users provided should return all three'
			],
			[
				[ 'admin1', 'admin2' ],
				[
					'admins' => [ 'admin1', 'admin2' ],
					'otherAdminCount' => 0,
					'haveOtherAdmins' => false,
					'adminCount' => 2,
				],
				'For two users provided should return all two'
			],
			[
				[ 'admin1' ],
				[
					'admins' => [ 'admin1' ],
					'otherAdminCount' => 0,
					'haveOtherAdmins' => false,
					'adminCount' => 1,
				],
				'For one user provided should return the one'
			],
			[
				[],
				[
					'admins' => [],
					'otherAdminCount' => 0,
					'haveOtherAdmins' => false,
					'adminCount' => 0,
				],
				'For none users provided should return empty list and zero count'
			],
		];
	}

}
