<?php
class WAMPageModelTest extends WikiaBaseTest {
	
	public function setUp() {
		include_once __DIR__ . DIRECTORY_SEPARATOR
			. '..' . DIRECTORY_SEPARATOR
			. 'models' . DIRECTORY_SEPARATOR
			. 'WAMPageModel.class.php';
		
		parent::setUp();
	}
	
	public function testGetTabs() {
		$modelMock = $this->getMock('WAMPageModel', array('getConfig'), array(), '', false);
		$modelMock->expects($this->once())
			->method('getConfig')
			->will($this->returnValue([
				'pageName' => 'WAM',
				'faqPageName' => 'WAM/FAQ',
				'tabsNames' => array(
					'Top wikis',
					'The biggest gainers',
					'Top video games wikis',
					'Top entertainment wikis',
					'Top lifestyle wikis',
				),
			]));
		
		$this->assertEquals(
			[
				[
					'name' => 'Top wikis',
					'url' => '/wiki/WAM/Top_wikis',
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
			$modelMock->getTabs()
		);
	}
}