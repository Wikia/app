<?php

class CommunityPageSpecialTopAdminsFormatterTest extends WikiaBaseTest {

	public function setUp() {
		$this->setupFile = __DIR__ . '/../CommunityPage.setup.php';
		parent::setUp();
	}

	/**
	 * @dataProvider adminsDataFormatProvider
	 */
	public function testAdminsDataFormat( $param, $expected, $expectedTopAdminsCount, $message ) {
		$result = CommunityPageSpecialTopAdminsFormatter::prepareData( $param );
		$this->assertEquals( $result['haveOtherAdmins'], $expected['haveOtherAdmins'], "$message 'haveOtherAdmins' field doesn't match" );
		$this->assertEquals( $result['allAdminsCount'], $expected['allAdminsCount'], "$message 'allAdminsCount' field doesn't match" );
		// Check just the count as order is randomized
		$this->assertEquals( count( $result['topAdminsList'] ), $expectedTopAdminsCount, "$message 'topAdminsList' size doesn't match" );

	}

	public function adminsDataFormatProvider() {
		return [
			[
				[ 'admin1', 'admin2', 'admin3', 'admin4' ],
				[
					'haveOtherAdmins' => true,
					'allAdminsCount' => 4,
				],
				2,
				'For four users provided should return first two and info on remaining number'
			],
			[
				[ 'admin1', 'admin2', 'admin3' ],
				[
					'haveOtherAdmins' => true,
					'allAdminsCount' => 3,
				],
				2,
				'For three users provided should return first two and info on remaining number'
			],
			[
				[ 'admin1', 'admin2' ],
				[
					'haveOtherAdmins' => false,
					'allAdminsCount' => 2,
				],
				2,
				'For two users provided should return all two'
			],
			[
				[ 'admin1' ],
				[
					'haveOtherAdmins' => false,
					'allAdminsCount' => 1,
				],
				1,
				'For one user provided should return the one'
			],
			[
				[],
				[
					'haveOtherAdmins' => false,
					'allAdminsCount' => 0,
				],
				0,
				'For none users provided should return empty list and zero count'
			],
		];
	}

}
