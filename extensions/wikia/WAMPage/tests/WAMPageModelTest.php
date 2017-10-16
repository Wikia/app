<?php
class WAMPageModelTest extends WikiaBaseTest {
	private $wamRedirects;
	
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
		];
	}
}
