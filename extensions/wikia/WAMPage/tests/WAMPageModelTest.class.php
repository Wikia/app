<?php
class WAMPageModelTest extends WikiaBaseTest {
	
	public function setUp() {
		include_once __DIR__ . DIRECTORY_SEPARATOR
			. '..' . DIRECTORY_SEPARATOR
			. 'models' . DIRECTORY_SEPARATOR
			. 'WAMPageModel.class.php';
		
		parent::setUp();
	}

	/**
	 * @dataProvider getTabsProvider
	 * @param $configData
	 * @param $expectedTabs
	 */
	public function testGetTabs($configData, $expectedTabs) {
		$modelMock = $this->getMock('WAMPageModel', array('getConfig'), array(), '', false);
		$modelMock->expects($this->once())
			->method('getConfig')
			->will($this->returnValue($configData));
		
		$this->assertEquals($expectedTabs, $modelMock->getTabs());
	}
	
	public function getTabsProvider() {
		return [
			//all fine
			[
				'configData' => [
					'pageName' => 'WAM',
					'faqPageName' => 'WAM/FAQ',
					'tabsNames' => array(
						'Top wikis',
						'The biggest gainers',
						'Top video games wikis',
						'Top entertainment wikis',
						'Top lifestyle wikis',
					),
				],
				'expectedTabs' => [
					[
						'name' => 'Top wikis',
						'url' => '/wiki/WAM/Top_wikis',
						'selected' => true,
					],
					[
						'name' => 'The biggest gainers',
						'url' => '/wiki/WAM/The_biggest_gainers',
					],
					[
						'name' => 'Top video games wikis',
						'url' => '/wiki/WAM/Top_video_games_wikis',
					],
					[
						'name' => 'Top entertainment wikis',
						'url' => '/wiki/WAM/Top_entertainment_wikis',
					],
					[
						'name' => 'Top lifestyle wikis',
						'url' => '/wiki/WAM/Top_lifestyle_wikis',
					],
				],
			],
		];
	}
}