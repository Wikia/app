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
			[
				'title' => 'Blog_użytkownika:Andrzej_Łukaszewski/Test_on_dev_2013-07-12',
				'expected' => 'Test_on_dev_2013-07-12',
			],
			[
				'title' => '由于管理员不活跃:由于管理员不活跃/由于管理员不活跃，数据库已经被自动锁定',
				'expected' => '由于管理员不活跃，数据库已经被自动锁定',
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
				'blogPostWikitext' => '<h3>one</h3>
da da da
<h3> CSS Updates</h3>
<ul><li>point one,</li>
<li>point two</li>
<li>new with=100</li>
<li>point three.</li></ul>
<h4> Secondary headline for this section #1 </h4>
<ul><li>1a,</li>
<li>1b.</li></ul>
<h3> two </h3>
asdasdasd
asdasdasd
asdasdasd
',
				'expected' => '<ul><li>point one,</li>
<li>point two</li>
<li>new with=100</li>
<li>point three.</li></ul>
<h4> Secondary headline for this section #1 </h4>
<ul><li>1a,</li>
<li>1b.</li></ul>'
			],
			'CSS Updates section at the beginning' =>
			[
				'blogPostWikitext' => '<h3><span>CSS Updates </span></h3>
<ul><li>point one,</li>
<li>point two</li>
<li>new with=100</li>
<li>point three.</li></ul>
<h4> Secondary headline for this section #1 </h4>
<ul><li>1a,</li>
<li>1b.</li></ul>
<h3>one</h3>
da da da
<h3> two </h3>
asdasdasd
asdasdasd
asdasdasd
',
				'expected' => '<ul><li>point one,</li>
<li>point two</li>
<li>new with=100</li>
<li>point three.</li></ul>
<h4> Secondary headline for this section #1 </h4>
<ul><li>1a,</li>
<li>1b.</li></ul>'
			],
			'CSS Updates section at the end' =>
			[
				'blogPostWikitext' => '<h3>one </h3>
da da da
<h3> two </h3>
asdasdasd
asdasdasd
asdasdasd
<h3>CSS Updates</h3>
<ul><li>point one,</li>
<li>point two,</li></ul>
<h4>Secondary headline for this section #1</h4>
<ul><li>1a,</li>
<li>1b.</li></ul>',
				'expected' => '<ul><li>point one,</li>
<li>point two,</li></ul>
<h4>Secondary headline for this section #1</h4>
<ul><li>1a,</li>
<li>1b.</li></ul>'
			],
			// H2 before and after our CSS Updates section
			[
				'blogPostWikitext' => '<h3>one</h3>
da da da
<h2> first h2  </h2>
asdasdasd
asdasdasd
asdasdasd
<h3> CSS Updates</h3>
<ul><li>point one,</li>
<li>point two,</li></ul>
<h4> Secondary headline for this section #1 </h4>
<ul><li>1a,</li>
<li>1b.</li></ul>
Paragraph text, text, sample text.
<h2>second h2 </h2>
<ul><li>new with=100</li>
<li>point three.</li></ul>
<h3> two </h3>
More sample text in paragraph. What to write here?
I don\'t really know. Any ideas?
<h3> three</h3>
This is the last one.',
				'expected' => '<ul><li>point one,</li>
<li>point two,</li></ul>
<h4> Secondary headline for this section #1 </h4>
<ul><li>1a,</li>
<li>1b.</li></ul>
Paragraph text, text, sample text.'
			],
			'Just CSS Updates section' =>
			[
				'blogPostWikitext' => '<h3>CSS Updates</h3>
<ul><li>point one,</li>
<li>point two,</li></ul>',
				'expected' => '<ul><li>point one,</li>
<li>point two,</li></ul>'
			],
		];
	}

	/**
	 * @dataProvider testConvertLocalToInterwikiLinksDataProvider
	 *
	 * @param String $wikitext
	 * @param String $expected
	 */
	public function testConvertLocalToInterwikiLinks($wikitext, $communityUrl, $expected) {
		$this->mockGlobalVariable( 'wgCssUpdatesLangMap', $this->wgCssUpdatesLangMapMock );

		$changeLocalLinks = new ReflectionMethod('SpecialCssModel', 'convertLocalToInterwikiLinks');
		$changeLocalLinks->setAccessible(true);

		$communityUrlMock = $this->getMock( 'SpecialCssModel', ['getCommunityUrl'] );
		$communityUrlMock->expects( $this->any() )
			->method( 'getCommunityUrl' )
			->will( $this->returnValue(  $communityUrl ) );


		$this->assertEquals( $expected, $changeLocalLinks->invoke( $communityUrlMock, $wikitext ) );
	}

	public function testConvertLocalToInterwikiLinksDataProvider() {
		return [
			[
				'wikitext' => 'The structure of the <a href="/Help:Galleries, Slideshows, and Sliders">sliders<a/> has changed slightly. We have converted the sliders <a href="http://wikia.com/Guidelines">Guidelines</a> <a href="/About">About Us</a> files over to <a href="http://sass-lang.com/">SCSS</a>.',
				'communityUrl' => 'http://community.wikia.com/',
				'expected' => 'The structure of the <a href="http://community.wikia.com/Help:Galleries, Slideshows, and Sliders">sliders<a/> has changed slightly. We have converted the sliders <a href="http://wikia.com/Guidelines">Guidelines</a> <a href="http://community.wikia.com/About">About Us</a> files over to <a href="http://sass-lang.com/">SCSS</a>.'
			],
			[
				'wikitext' => 'The structure of the <a href="/Help:Galleries, Slideshows, and Sliders">sliders<a/> has changed slightly. We have converted the sliders <a href="http://wikia.com/Guidelines">Guidelines</a> <a href="/About">About Us</a> files over to <a href="http://sass-lang.com/">SCSS</a>.',
				'communityUrl' => 'http://spolecznosc.wikia.com/',
				'expected' => 'The structure of the <a href="http://spolecznosc.wikia.com/Help:Galleries, Slideshows, and Sliders">sliders<a/> has changed slightly. We have converted the sliders <a href="http://wikia.com/Guidelines">Guidelines</a> <a href="http://spolecznosc.wikia.com/About">About Us</a> files over to <a href="http://sass-lang.com/">SCSS</a>.'
			],
			[
				'wikitext' => 'The structure of the <a href="http://muppet.wikia.com/wiki/Help:Galleries, Slideshows, and Sliders">sliders<a/> has changed slightly. We have converted the sliders <a href="http://wikia.com/Guidelines">Guidelines</a> files over to <a href="http://sass-lang.com/">SCSS</a>.',
				'communityUrl' => 'http://community.wikia.com/',
				'expected' => 'The structure of the <a href="http://muppet.wikia.com/wiki/Help:Galleries, Slideshows, and Sliders">sliders<a/> has changed slightly. We have converted the sliders <a href="http://wikia.com/Guidelines">Guidelines</a> files over to <a href="http://sass-lang.com/">SCSS</a>.'
			],
			[
				'wikitext' => 'The structure of the sliders has changed slightly. We have converted the sliders files over to SCSS.',
				'communityUrl' => 'http://community.wikia.com/',
				'expected' => 'The structure of the sliders has changed slightly. We have converted the sliders files over to SCSS.'
			],
			[
				'wikitext' => 'The structure of the <a href="/Help:Galleries, Slideshows, and Sliders">sliders<a/> has changed slightly. We have converted the sliders <a href="/Guidelines">Guidelines</a> <a href="/About">About Us</a> files over to <a href="http://sass-lang.com/">SCSS</a>.',
				'communityUrl' => 'http://de.community.wikia.com/',
				'expected' => 'The structure of the <a href="http://de.community.wikia.com/Help:Galleries, Slideshows, and Sliders">sliders<a/> has changed slightly. We have converted the sliders <a href="http://de.community.wikia.com/Guidelines">Guidelines</a> <a href="http://de.community.wikia.com/About">About Us</a> files over to <a href="http://sass-lang.com/">SCSS</a>.'
			],
		];
	}
}

