<?php
class SpecialCssModelTest extends WikiaBaseTest {
	const FULL_URL_EXAMPLE = 'http://www.wikia.com/wiki/Special:CSS';
	const LOCAL_URL_EXAMPLE = '/wiki/Special:CSS';
	
	private $wgCssUpdatesLangMapMock = [
		'en' => 'wikia',
		'pl' => 'plwikia',
		'de' => 'de',
		'fr' => 'frfr',
		'es' => 'es',
		'ru' => 'ruwikia',
		'it' => 'it',
	];

	protected function setUp () {
		require_once( dirname(__FILE__) . '/../SpecialCssModel.class.php');
		parent::setUp();
	}

	/**
	 * @dataProvider testGetSpecialCssDataProvider
	 */
	public function testGetSpecialCssUrl($fullUrl, $expected, $params) {
		$titleMock = $this->getMock('Title', array('getLocalURL', 'getFullUrl'));
		$titleMock->expects($this->any())
			->method('getLocalURL')
			->with($params, false)
			->will($this->returnValue(self::LOCAL_URL_EXAMPLE));
		$titleMock->expects($this->any())
			->method('getFullUrl')
			->with($params, false)
			->will($this->returnValue(self::FULL_URL_EXAMPLE));

		/** @var $specialCssModelMock PHPUnit_Framework_MockObject_MockObject */
		$specialCssModelMock = $this->getMock('SpecialCssModel', array('getSpecialCssTitle'));
		$specialCssModelMock->expects($this->once())
			->method('getSpecialCssTitle')
			->will($this->returnValue($titleMock));

		/** @var $specialCssModelMock SpecialCssModel */
		$result = $specialCssModelMock->getSpecialCssUrl($fullUrl, $params);
		$this->assertEquals($expected, $result);
	}

	public function testGetSpecialCssDataProvider() {
		return [
			[true, self::FULL_URL_EXAMPLE, null],
			[false, self::LOCAL_URL_EXAMPLE, null],
			[true, self::FULL_URL_EXAMPLE, array( 'oldid' => 1)],
			[false, self::LOCAL_URL_EXAMPLE, array( 'oldid' => 1)]
		];
	}

	/**
	 * @dataProvider testGetCssFileContentDataProvider
	 */
	public function testGetCssFileContent($expected, $articleContent) {
		if (isset($articleContent)) {
			/** @var $fileArticle PHPUnit_Framework_MockObject_MockObject */
			$fileArticle = $this->getMock('Article', array('getContent'), [new Title()]);
			$fileArticle->expects($this->any())
				->method('getContent')
				->will($this->returnValue($articleContent));
		} else {
			$fileArticle = null;
		}

		/** @var $specialCssModelMock PHPUnit_Framework_MockObject_MockObject */
		$specialCssModelMock = $this->getMock('SpecialCssModel', array('getCssFileArticle'));
		$specialCssModelMock->expects($this->any())
			->method('getCssFileArticle')
			->will($this->returnValue($fileArticle));

		/** @var $specialCssModelMock SpecialCssModel */
		$this->assertEquals($expected, $specialCssModelMock->getCssFileContent());
	}

	public function testGetCssFileContentDataProvider() {
		return [
			['', null],
			['test content', 'test content']
		];
	}

	/**
	 * @param String $title
	 * @param String $expected
	 *
	 * @dataProvider testGetAfterLastSlashTextDataProvider
	 */
	public function testGetAfterLastSlashText($title, $expected) {
		$getAfterLastSlashTextMethod = new ReflectionMethod('SpecialCssModel', 'getAfterLastSlashText');
		$getAfterLastSlashTextMethod->setAccessible(true);

		$this->assertEquals( $expected, $getAfterLastSlashTextMethod->invoke( new SpecialCssModel(), $title ) );
	}

	public function testGetAfterLastSlashTextDataProvider() {
		return [
			[
				'title' => '',
				'expected' => '',
			],
			[
				'title' => 'Technical_Update:_November_20,_2012',
				'expected' => 'Technical_Update:_November_20,_2012',
			],
			[
				'title' => 'DaNASCAT/Technical_Update:_November_20,_2012',
				'expected' => 'Technical_Update:_November_20,_2012',
			],
			[
				'title' => 'DaNASCAT/Technical_Update:_November_20,_2012#Major_Bugs_Fixed',
				'expected' => 'Technical_Update:_November_20,_2012#Major_Bugs_Fixed',
			],
			[
				'title' => 'User_blog:DaNASCAT/Technical_Update:_November_21,_2012',
				'expected' => 'Technical_Update:_November_21,_2012',
			],
			[
				'title' => 'Rappy 4187/Technical_Update:_November_22,_2012',
				'expected' => 'Technical_Update:_November_22,_2012',
			],
			[
				'title' => 'Test page/Rappy 4187/Technical_Update:_November_22,_2012',
				'expected' => 'Technical_Update:_November_22,_2012',
			],
		];
	}

	/**
	 * @param String $titleText
	 * @param String $fallbackUser
	 * @param String $expected
	 *
	 * @dataProvider testGetUserFromTitleTextDataProvider
	 */
	public function testGetUserFromTitleText($titleText, $fallbackUser, $expected) {
		$getUserFromTitleTextMethod = new ReflectionMethod('SpecialCssModel', 'getUserFromTitleText');
		$getUserFromTitleTextMethod->setAccessible(true);

		$this->assertEquals( $expected, $getUserFromTitleTextMethod->invoke( new SpecialCssModel(), $titleText, $fallbackUser ) );
	}

	public function testGetUserFromTitleTextDataProvider() {
		return [
			[
				'titleText' => '',
				'fallbackUser' => 'User',
				'expected' => 'User',
			],
			[
				'titleText' => 'Technical_Update:_November_20,_2012',
				'fallbackUser' => 'User',
				'expected' => 'User',
			],
			[
				'titleText' => 'DaNASCAT/Technical_Update:_November_20,_2012',
				'fallbackUser' => 'User',
				'expected' => 'DaNASCAT',
			],
			[
				'titleText' => 'DaNASCAT/Technical_Update:_November_20,_2012#Major_Bugs_Fixed',
				'fallbackUser' => 'User',
				'expected' => 'DaNASCAT',
			],
			[
				'titleText' => 'User_blog:DaNASCAT/Technical_Update:_November_21,_2012',
				'fallbackUser' => 'User',
				'expected' => 'DaNASCAT',
			],
			[
				'titleText' => 'Rappy 4187/Technical_Update:_November_22,_2012',
				'fallbackUser' => 'User',
				'expected' => 'Rappy 4187',
			],
			[
				'titleText' => 'Test page/Rappy 4187/Technical_Update:_November_22,_2012',
				'fallbackUser' => 'User',
				'expected' => 'Rappy 4187',
			],
		];
	}

	/**
	 * @param $langCode
	 * @param $expectedDbName
	 *
	 * @dataProvider testGetCommunityDbNameDataProvider
	 */
	public function testGetCommunityDbName( $langCode, $expectedDbName ) {
		$this->mockGlobalVariable( 'wgCssUpdatesLangMap', $this->wgCssUpdatesLangMapMock );
		/** @var $specialCssModelMock PHPUnit_Framework_MockObject_MockObject */
		$specialCssModelMock = $this->getMock( 'SpecialCssModel', ['getCssUpdateLang'] );
		$specialCssModelMock->expects( $this->any() )
			->method( 'getCssUpdateLang' )
			->will( $this->returnValue( $langCode ) );

		/** @var $specialCssModelMock SpecialCssModel */
		$dbName = $specialCssModelMock->getCommunityDbName();
		$this->assertEquals( $expectedDbName, $dbName );
	}


	public function testGetCommunityDbNameDataProvider() {
		return [
			[
				'langCode' => 'en',
				'dbName' => 'wikia',
			],
			[
				'langCode' => 'pl',
				'dbName' => 'plwikia',
			],
			[
				'langCode' => 'de',
				'dbName' => 'de',
			],
			[
				'langCode' => 'fr',
				'dbName' => 'frfr',
			],
			[
				'langCode' => 'es',
				'dbName' => 'es',
			],
			[
				'langCode' => 'ru',
				'dbName' => 'ruwikia',
			],
			[
				'langCode' => 'it',
				'dbName' => 'it',
			],
			[
				'langCode' => 'zh-hans',
				'dbName' => 'wikia',
			],
			[
				'langCode' => 'hi',
				'dbName' => 'wikia',
			],
			[
				'langCode' => 'ar',
				'dbName' => 'wikia',
			],
			[
				'langCode' => 'pt',
				'dbName' => 'wikia',
			],
			[
				'langCode' => 'ja',
				'dbName' => 'wikia',
			],
		];
	}

	/**
	 * @param $userLang
	 * @param $expectedLang
	 *
	 * @dataProvider testGetCssUpdateLangDataProvider
	 */
	public function testGetCssUpdateLang($userLang, $expectedLang) {
		$this->mockGlobalVariable( 'wgCssUpdatesLangMap', $this->wgCssUpdatesLangMapMock );
		$langMock = $this->getMock( 'Language', ['getCode'] );
		$langMock->expects( $this->any() )
			->method( 'getCode' )
			->will( $this->returnValue( $userLang ) );
		$specialCssModelMock = $this->getMock( 'SpecialCssModel', null );
		$this->mockGlobalVariable( 'wgLang', $langMock );

		/** @var $specialCssModelMock SpecialCssModel */
		$cssLang = $specialCssModelMock->getCssUpdateLang();
		$this->assertEquals( $expectedLang, $cssLang );
	}

	public function testGetCssUpdateLangDataProvider() {
		return [
			[
				'userLang' => 'en',
				'expectedLang' => 'en',
			],
			[
				'userLang' => 'pl',
				'expectedLang' => 'pl',
			],
			[
				'userLang' => 'de',
				'expectedLang' => 'de',
			],
			[
				'userLang' => 'fr',
				'expectedLang' => 'fr',
			],
			[
				'userLang' => 'es',
				'expectedLang' => 'es',
			],
			[
				'userLang' => 'ru',
				'expectedLang' => 'ru',
			],
			[
				'userLang' => 'it',
				'expectedLang' => 'it',
			],
			[
				'userLang' => 'zh-hans',
				'expectedLang' => 'en',
			],
			[
				'userLang' => 'hi',
				'expectedLang' => 'en',
			],
			[
				'userLang' => 'ar',
				'expectedLang' => 'en',
			],
			[
				'userLang' => 'pt',
				'expectedLang' => 'en',
			],
			[
				'userLang' => 'ja',
				'expectedLang' => 'en',
			],
		];
	}

	/**
	 * @dataProvider testGetCssUpdateSectionDataProvider
	 */
	public function testGetCssUpdateSection( $blogPostWikitext, $expected ) {
		$getCssUpdateSectionMethod = new ReflectionMethod('SpecialCssModel', 'getCssUpdateSection');
		$getCssUpdateSectionMethod->setAccessible(true);
		
		$specialCssModelMock = $this->getMock( 'SpecialCssModel', ['getCssUpdateHeadline'] );
		$specialCssModelMock->expects( $this->once() )
			->method( 'getCssUpdateHeadline' )
			->will( $this->returnValue( 'CSS Updates') );

		$this->assertEquals( $expected, $getCssUpdateSectionMethod->invoke( $specialCssModelMock, $blogPostWikitext ) );
	}
	
	public function testGetCssUpdateSectionDataProvider() {
		return [
			'CSS Updates section in the middle' => 
			[
				'blogPostWikitext' => '===one===
da da da
=== CSS Updates===
* point one,
* point two,
* new with=100
* point three.
==== Secondary headline for this section #1 ====
* 1a,
* 1b.
=== two ===
asdasdasd
asdasdasd
asdasdasd
', 
				'expected' => '* point one,
* point two,
* new with=100
* point three.
==== Secondary headline for this section #1 ====
* 1a,
* 1b.'
			],
			'CSS Updates section at the beginning' =>
			[
				'blogPostWikitext' => '=== CSS Updates===
* point one,
* point two,
* new with=100
* point three.
==== Secondary headline for this section #1 ====
* 1a,
* 1b.
===one===
da da da
=== two ===
asdasdasd
asdasdasd
asdasdasd
',
				'expected' => '* point one,
* point two,
* new with=100
* point three.
==== Secondary headline for this section #1 ====
* 1a,
* 1b.'
			],
			'CSS Updates section at the end' => 
			[
				'blogPostWikitext' => '===one===
da da da
=== two ===
asdasdasd
asdasdasd
asdasdasd
=== CSS Updates===
* point one,
* point two,
==== Secondary headline for this section #1 ====
* 1a,
* 1b.',
				'expected' => '* point one,
* point two,
==== Secondary headline for this section #1 ====
* 1a,
* 1b.'
			],
			// H2 before and after our CSS Updates section
			[
				'blogPostWikitext' => '===one===
da da da
== first h2  ==
asdasdasd
asdasdasd
asdasdasd
=== CSS Updates===
* point one,
* point two,
==== Secondary headline for this section #1 ====
* 1a,
* 1b.
Paragraph text, text, sample text.
== second h2 ==
* new with=100
* point three.
=== two ===
More sample text in paragraph. What to write here?
I don\'t really know. Any ideas?
=== three===
This is the last one.',
				'expected' => '* point one,
* point two,
==== Secondary headline for this section #1 ====
* 1a,
* 1b.
Paragraph text, text, sample text.'
			]
		];
	}
}
