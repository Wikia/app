<?php
class WAMPageModelTest extends WikiaBaseTest {
	private $wamRedirects;

	static protected $failoverTabsNames = [
		'Top wikis',
		'The biggest gainers',
		'Top video games wikis',
		'Top entertainment wikis',
		'Top lifestyle wikis'
	];
	
	static protected $wamPagesDbKeysMap = [
		'wam/faq' => 'WAM/FAQ', 
		'wam/a_subpage' => 'WAM/A_Subpage',
		'wam' => 'WAM'
	];

	
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
	public function testGetTabs( $configData, $expectedTabs ) {
		$modelMock = $this->getMock(
			'WAMPageModel',
			array( 'getWAMMainPageName', 'getConfig', 'getDefaultTabsNames' ),
			array(),
			'',
			false
		);

		$modelMock->expects( $this->once() )
			->method( 'getWAMMainPageName' )
			->will( $this->returnValue( 'WAM' ) );
		$modelMock->expects( $this->any() )
			->method( 'getConfig' )
			->will( $this->returnValue( $configData ) );

		$modelMock->expects( $this->any() )
			->method( 'getDefaultTabsNames' )
			->will( $this->returnValue( self::$failoverTabsNames ) );
		
		$this->assertEquals( $expectedTabs, $modelMock->getTabs() );
	}
	
	public function getTabsProvider() {
		return [
			//all fine
			[
				'configData' => [
					'pageName' => 'WAM',
					'faqPageName' => 'WAM/FAQ',
					'tabsNames' => [
						'Top wikis',
						'The biggest gainers',
						'Top video games wikis',
						'Top entertainment wikis',
						'Top lifestyle wikis',
					],
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
			//no tabsNames element in WikiFactory
			[
				'configData' => [
					'pageName' => 'WAM',
					'faqPageName' => 'WAM/FAQ',
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

	/**
	 * @dataProvider getWAMSubpageUrlProvider
	 * 
	 * @param Array $mockedTitleData
	 * @param Boolean $isWAMPage returned value of a mocked method WAMPageModel::isWAMPage()
	 * @param Boolean $fullUrl flag parameter passed to getWAMSubpageUrl() method; by default it's true to make the method return full url
	 * @param String $expectedResult
	 */
	public function testGetWAMSubpageUrl( $mockedTitleData, $isWAMPage, $fullUrl, $expectedResult ) {
		$titleMock = $this->getMock(
			'Title',
			array( 'getDBKey', 'newFromText', 'getFullUrl', 'getLocalURL' ),
			array(),
			'',
			false
		);

		$titleMock->expects( $this->once() )
			->method( 'getDBKey' )
			->will( $this->returnValue( $mockedTitleData['getDBKey'] ) );

		$titleMock->expects( $this->any() )
			->method( 'newFromText' )
			->will( $this->returnValue( $mockedTitleData['newFromText'] ) );

		$titleMock->expects( $this->any() )
			->method( 'getFullUrl' )
			->will( $this->returnValue( $mockedTitleData['getFullUrl'] ) );

		$titleMock->expects( $this->any() )
			->method( 'getLocalURL' )
			->will( $this->returnValue( $mockedTitleData['getLocalURL'] ) );

		$modelMock = $this->getMock(
			'WAMPageModel',
			array( 'isWAMPage', 'getWamPagesDbKeysMap', 'getTitleFromText' ),
			array(),
			'',
			false
		);

		$modelMock->expects( $this->once() )
			->method( 'isWAMPage' )
			->will( $this->returnValue( $isWAMPage ) );

		$modelMock->expects( $this->once() )
			->method( 'getWamPagesDbKeysMap' )
			->will( $this->returnValue( self::$wamPagesDbKeysMap ) );

		$modelMock->expects( $this->any() ) //any() because in last example from data provider it shouldn't be called
			->method( 'getTitleFromText' )
			->will( $this->returnValue( $titleMock ) );
		
		$this->assertEquals( $expectedResult, $modelMock->getWAMSubpageUrl( $titleMock, $fullUrl ) );
	}
	
	public function getWAMSubpageUrlProvider() {
		return [
			[
				'mockedTitleData' => [
					'getDBKey' => 'WAM/A_Subpage',
					'newFromText' => 'WAM/A_Subpage',
					'getFullUrl' => 'http://www.example.wikia.com/wiki/WAM/A_Subpage',
					'getLocalURL' => '/wiki/WAM/A_Subpage',
				],
				'isWAMPage' => true,
				'fullUrl' => true,
				'expectedResult' => 'http://www.example.wikia.com/wiki/WAM/A_Subpage',
			],
			[
				'mockedTitleData' => [
					'getDBKey' => 'WAM/A_Subpage',
					'newFromText' => 'WAM/A_Subpage',
					'getFullUrl' => 'http://www.example.wikia.com/wiki/WAM/A_Subpage',
					'getLocalURL' => '/wiki/WAM/A_Subpage',
				],
				'isWAMPage' => true,
				'fullUrl' => false,
				'expectedResult' => '/wiki/WAM/A_Subpage',
			],
			[
				'mockedTitleData' => [
					'getDBKey' => 'WAM/faq',
					'newFromText' => 'WAM/FAQ',
					'getFullUrl' => 'http://www.example.wikia.com/wiki/WAM/FAQ',
					'getLocalURL' => '/wiki/WAM/FAQ',
				],
				'isWAMPage' => true,
				'fullUrl' => true,
				'expectedResult' => 'http://www.example.wikia.com/wiki/WAM/FAQ',
			],
			[
				'mockedTitleData' => [
					'getDBKey' => 'WAM/faq',
					'newFromText' => 'WAM/FAQ',
					'getFullUrl' => 'http://www.example.wikia.com/wiki/WAM/FAQ',
					'getLocalURL' => '/wiki/WAM/FAQ',
				],
				'isWAMPage' => true,
				'fullUrl' => false,
				'expectedResult' => '/wiki/WAM/FAQ',
			],
			[
				'mockedTitleData' => [
					'getDBKey' => 'Video_Games',
					'newFromText' => 'Video_Games',
					'getFullUrl' => 'http://www.example.wikia.com/wiki/Video_Games',
					'getLocalURL' => '/wiki/Video_Games',
				],
				'isWAMPage' => true,
				'fullUrl' => true,
				'expectedResult' => 'http://www.example.wikia.com/wiki/Video_Games',
			],
		];
	}

	 /**
	  * @dataProvider calculateFilterIndexProvider
	  */
	public function testCalculateFilterIndex( $wamWikis, $params, $expected ) {
		$class = new ReflectionClass( 'WAMPageModel' );
		$method = $class->getMethod( 'calculateFilterIndex' );
		$method->setAccessible( true );

		$wamModel = new WAMPageModel();
		$computedWikis = $method->invokeArgs( $wamModel, array( $wamWikis, $params ) );
		$this->assertEquals( $expected, $computedWikis );
	}

	public function calculateFilterIndexProvider() {
		return [
			[
				[
					['wiki_id' => 1],
					['wiki_id' => 2],
				],
				['offset' => 50, 'limit' => 20],
				[
					['wiki_id' => 1, 'index' => 51],
					['wiki_id' => 2, 'index' => 52],
				]
			],
			[
				[
					['wiki_id' => 1],
				],
				['offset' => 511, 'limit' => 21],
				[
					['wiki_id' => 1, 'index' => 512],
				]
			],
			[
				[
					['wiki_id' => 1],
					['wiki_id' => 2],
					['wiki_id' => 3],
					['wiki_id' => 4],
					['wiki_id' => 5],
					['wiki_id' => 6],
					['wiki_id' => 7],
				],
				['offset' => 0, 'limit' => 5],
				[
					['wiki_id' => 1, 'index' => 1],
					['wiki_id' => 2, 'index' => 2],
					['wiki_id' => 3, 'index' => 3],
					['wiki_id' => 4, 'index' => 4],
					['wiki_id' => 5, 'index' => 5],
					['wiki_id' => 6, 'index' => 6],
					['wiki_id' => 7, 'index' => 7],
				]
			],
		];
	}
	/**
	 * @dataProvider getWAMRedirectsDataProvider
	 */
	public function testGetWAMRedirect( $title, $expectedTitle, $wamRedirects ) {
		$this->mockWgWAMRedirects( $wamRedirects );

		$wamModel = new WAMPageModel();
		$newTitle = $wamModel->getWAMRedirect( $title );

		$this->assertEquals( $expectedTitle, $newTitle );

		$this->unmockWgWAMRedirects();
	}

	private function mockWgWAMRedirects( $wamRedirects ) {
		global $wgWAMRedirects;
		$this->wamRedirects = $wgWAMRedirects;
		$wgWAMRedirects = $wamRedirects;
	}

	private function unmockWgWAMRedirects() {
		global $wgWAMRedirects;
		$wgWAMRedirects = $this->wamRedirects;
	}

	public function getWAMRedirectsDataProvider() {
		return [
			[
				Title::newFromText('WAM/Old tab name'),
				Title::newFromText('WAM/New tab name'),
				[
					'Old tab name'	=> 'New tab name',
					'a' 			=> 'b',
					'test tab name' => 'new test tab name'
				]
			],
			[
				Title::newFromText('WAM/Old tab name'),
				Title::newFromText('WAM/New tab name'),
				[
					'OLD TAB NAME'	=> 'New tab name',
					'a' 			=> 'b',
					'test tab name' => 'new test tab name'
				]
			],
			[
				Title::newFromText('WAM/Old tab namę'),
				Title::newFromText('WAM/New tab name'),
				[
					'OLD TAB NAMĘ'	=> 'New tab name',
					'a' 			=> 'b',
					'test tab name' => 'new test tab name'
				]
			],
			[
				Title::newFromText('WAM/a'),
				Title::newFromText('WAM/b'),
				[
					'OLD TAB NAMę'	=> 'New tab name',
					'a' 			=> 'b',
					'test tab name' => 'new test tab name'
				]
			],
			[
				Title::newFromText('WAM/Not existing redirect'),
				null,
				[
					'OLD TAB NAMę'	=> 'New tab name',
					'a' 			=> 'b',
					'test tab name' => 'new test tab name'
				]
			],
			[
				null,
				null,
				[
					'OLD TAB NAMę'	=> 'New tab name',
					'a' 			=> 'b',
					'test tab name' => 'new test tab name'
				]
			],
			[
				Title::newFromText('WAM/Not existing redirect'),
				null,
				[]
			],
			[
				Title::newFromText('WAM/Not existing redirect'),
				null,
				null
			],

		];
	}
}
