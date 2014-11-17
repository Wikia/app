<?php
include( dirname(__FILE__) . '/../../models/WikiaHubsModel.class.php' );

class WikiaHubsModuleWAMServiceTest extends WikiaBaseTest {
	/**
	 * (non-PHPdoc)
	 * @see WikiaBaseTest::setUp()
	 */
	public function setUp() {
		$this->setupFile = dirname(__FILE__) . '/../../WikiaHubsServices.setup.php';
		parent::setUp();
	}

	/**
	 * @group UsingDB
	 * @dataProvider getStructuredDataProvider
	 */
	public function testGetStructuredData($inputData, $expectedData) {
		$wamServiceMock = $this->getMock('WikiaHubsModuleWAMService', array('getWamPageUrl'), array($inputData['lang'], 1, $inputData['vertical_id']));
		$wamServiceMock->expects($this->any())
			->method('getWamPageUrl')
			->will($this->returnValue('http://www.wikia.com/WAM'));
		$result = $wamServiceMock->getStructuredData($inputData);
		$this->assertEquals($expectedData, $result);
	}

	public function getStructuredDataProvider() {
		return [[
			'inputData' => [
				'vertical_id' => 2,
				'lang' => 'en',
				'api_response' => [
					'wam_index' => [
						304 => [
							'wiki_id' => '304',
							'wam'=> '99.9554',
							'wam_rank' => '1',
							'peak_wam_rank' => '1',
							'peak_hub_wam_rank' => '1',
							'top_1k_days' => '431',
							'top_1k_weeks' => '62',
							'first_peak' => '2012-01-03',
							'last_peak' => '2013-03-06',
							'title' => 'RuneScape Wiki',
							'url' => 'runescape.wikia.com',
							'hub_id' => '2',
							'wam_change' => '0.0045',
							'admins' => [],
							'wiki_image' => 'http://images1.wikia.nocookie.net/__cb20121004184329/wikiaglobal/images/thumb/8/8b/Wikia-Visualization-Main%2Crunescape.png/150px-Wikia-Visualization-Main%2Crunescape.png',
						],
						14764 => [
							'wiki_id' => '14764',
							'wam'=> '99.8767',
							'wam_rank' => '2',
							'hub_wam_rank' => '2',
							'peak_wam_rank' => '1',
							'peak_hub_wam_rank' => '1',
							'top_1k_days' => '431',
							'top_1k_weeks' => '62',
							'first_peak' => '2012-04-21',
							'last_peak' => '2013-02-18',
							'title' => 'League of Legends Wiki',
							'url' => 'leagueoflegends.wikia.com',
							'hub_id' => '2',
							'wam_change' => '0.0039',
							'admins' => [],
							'wiki_image' => 'http://images4.wikia.nocookie.net/__cb20120828154214/wikiaglobal/images/thumb/e/ea/Wikia-Visualization-Main%2Cleagueoflegends.png/150px-Wikia-Visualization-Main%2Cleagueoflegends.png.jpeg',
						],
						1706 => [
							'wiki_id' => '1706',
							'wam'=> '99.7942',
							'wam_rank' => '4',
							'hub_wam_rank' => '3',
							'peak_wam_rank' => '1',
							'peak_hub_wam_rank' => '1',
							'top_1k_days' => '431',
							'top_1k_weeks' => '62',
							'first_peak' => '2012-01-01',
							'last_peak' => '2013-02-13',
							'title' => 'Elder Scrolls',
							'url' => 'elderscrolls.wikia.com',
							'hub_id' => '2',
							'wam_change' => '-0.0016',
							'admins' => [],
							'wiki_image' => 'http://images1.wikia.nocookie.net/__cb20121214183339/wikiaglobal/images/thumb/d/d4/Wikia-Visualization-Main%2Celderscrolls.png/150px-Wikia-Visualization-Main%2Celderscrolls.png',
						],
						3035 => [
							'wiki_id' => '3035',
							'wam'=> '99.6520',
							'wam_rank' => '9',
							'hub_wam_rank' => '4',
							'peak_wam_rank' => '4',
							'peak_hub_wam_rank' => '3',
							'top_1k_days' => '431',
							'top_1k_weeks' => '62',
							'first_peak' => '2012-01-02',
							'last_peak' => '2013-09-11',
							'title' => 'Fallout Wiki',
							'url' => 'fallout.wikia.com',
							'hub_id' => '2',
							'wam_change' => '0.0091',
							'admins' => [],
							'wiki_image' => 'http://images1.wikia.nocookie.net/__cb20121113183421/wikiaglobal/images/thumb/3/35/Wikia-Visualization-Main%2Cfallout.png/150px-Wikia-Visualization-Main%2Cfallout.png',
						],
						3125 => [
							'wiki_id' => '3125',
							'wam'=> '99.5516',
							'wam_rank' => '17',
							'hub_wam_rank' => '5',
							'peak_wam_rank' => '2',
							'peak_hub_wam_rank' => '2',
							'top_1k_days' => '431',
							'top_1k_weeks' => '62',
							'first_peak' => '2012-05-04',
							'last_peak' => '2013-05-07',
							'title' => 'Call of Duty Wiki',
							'url' => 'callofduty.wikia.com',
							'hub_id' => '2',
							'wam_change' => '-0.0093',
							'admins' => [],
							'wiki_image' => 'http://images3.wikia.nocookie.net/__cb20120828154219/wikiaglobal/images/thumb/d/da/Wikia-Visualization-Main%2CCallofduty.png/150px-Wikia-Visualization-Main%2CCallofduty.png.jpeg',
						],
					],
				],
			],
			'expectedData' => [
				'wamPageUrl' => 'http://www.wikia.com/WAM',
				'verticalName' => 'Video Games',
				'canonicalVerticalName' => 'VideoGames',
				'ranking' => [
					[
						'rank' => 1,
						'wamScore' => 99.96,
						'imageUrl' => 'http://images1.wikia.nocookie.net/__cb20121004184329/wikiaglobal/images/thumb/8/8b/Wikia-Visualization-Main%2Crunescape.png/150px-Wikia-Visualization-Main%2Crunescape.png',
						'wikiName' => 'RuneScape Wiki',
						'wikiUrl' => 'http://runescape.wikia.com',
						'change' => 1,
					],
					[
						'rank' => 2,
						'wamScore' => 99.88,
						'imageUrl' => 'http://images4.wikia.nocookie.net/__cb20120828154214/wikiaglobal/images/thumb/e/ea/Wikia-Visualization-Main%2Cleagueoflegends.png/150px-Wikia-Visualization-Main%2Cleagueoflegends.png.jpeg',
						'wikiName' => 'League of Legends Wiki',
						'wikiUrl' => 'http://leagueoflegends.wikia.com',
						'change' => 1,
					],
					[
						'rank' => 3,
						'wamScore' => 99.79,
						'imageUrl' => 'http://images1.wikia.nocookie.net/__cb20121214183339/wikiaglobal/images/thumb/d/d4/Wikia-Visualization-Main%2Celderscrolls.png/150px-Wikia-Visualization-Main%2Celderscrolls.png',
						'wikiName' => 'Elder Scrolls',
						'wikiUrl' => 'http://elderscrolls.wikia.com',
						'change' => -1,
					],
					[
						'rank' => 4,
						'wamScore' => 99.65,
						'imageUrl' => 'http://images1.wikia.nocookie.net/__cb20121113183421/wikiaglobal/images/thumb/3/35/Wikia-Visualization-Main%2Cfallout.png/150px-Wikia-Visualization-Main%2Cfallout.png',
						'wikiName' => 'Fallout Wiki',
						'wikiUrl' => 'http://fallout.wikia.com',
						'change' => 1,
					],
					[
						'rank' => 5,
						'wamScore' => 99.55,
						'imageUrl' => 'http://images3.wikia.nocookie.net/__cb20120828154219/wikiaglobal/images/thumb/d/da/Wikia-Visualization-Main%2CCallofduty.png/150px-Wikia-Visualization-Main%2CCallofduty.png.jpeg',
						'wikiName' => 'Call of Duty Wiki',
						'wikiUrl' => 'http://callofduty.wikia.com',
						'change' => -1,
					],
				]
			],
		]];
	}
}
