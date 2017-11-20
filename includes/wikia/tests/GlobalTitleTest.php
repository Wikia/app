<?php

/**
 * @group GlobalTitle
 */
class GlobalTitleTest extends WikiaBaseTest {
	protected function setUp() {
		parent::setUp();

		$this->disableMemCache();
		$this->getStaticMethodMock( 'WikiFactory', 'getVarValueByName' )
			->expects( $this->any() )
			->method( 'getVarValueByName' )
			->willReturnMap( [
				// basically all tests where GlobalTitle::load() is executed
				[ 'wgServer', 177, 'http://community.wikia.com' ],
				[ 'wgServer', 113, 'http://memory-alpha.wikia.com' ],
				[ 'wgServer', 490, 'http://wowwiki.wikia.com' ],
				[ 'wgServer', 1686, 'http://spolecznosc.wikia.com' ],
				[ 'wgLanguageCode', 177, 'en' ],
				[ 'wgLanguageCode', 113, 'en' ],
				[ 'wgLanguageCode', 490, 'en' ],
				[ 'wgLanguageCode', 1686, 'pl' ],
				[ 'wgExtraNamespacesLocal', 177, false, [], [] ],
				[ 'wgExtraNamespacesLocal', 113, false, [], [] ],
				[ 'wgExtraNamespacesLocal', 490, false, [], [ 116 => 'Portal' ] ],
				[ 'wgExtraNamespacesLocal', 1686, false, [], [] ],
			] );
	}

	function testNewFromText1() {
		$this->mockProdEnv();

		$title = GlobalTitle::newFromText( "Test", NS_MAIN, 177 );
		$this->assertTrue( $title->getNamespace() === NS_MAIN );
		$this->assertTrue( $title->getNsText() === "" ) ;
		$this->assertTrue( $title->getText() === "Test" );

		$title = GlobalTitle::newFromText( "Test_Ze_Spacjami", NS_MAIN, 177 );
		$this->assertEquals( "Test Ze Spacjami", $title->getText(), "Underscores, spaces expected" );
	}

	function testNewFromText2() {
		$this->mockProdEnv();

		$title = GlobalTitle::newFromText( "Test", NS_TALK, 177 );
		$this->assertTrue( $title->getNamespace() === NS_TALK );
		$this->assertTrue( $title->getNsText() === "Talk" );
		$this->assertTrue( $title->getText() === "Test" );

		$title = GlobalTitle::newFromText( "Test_Ze_Spacjami", NS_TALK, 177 );
		$this->assertEquals( "Test Ze Spacjami", $title->getText(), "Underscores, spaces expected" );
	}

	function testUrlsMainNS() {
		$this->mockProdEnv();

		$title = GlobalTitle::newFromText( "Timeline", NS_MAIN, 113 ); # memory-alpha
		$expectedUrl = "http://memory-alpha.wikia.com/wiki/Timeline";
		$this->assertEquals( $expectedUrl, $title->getFullURL() );
	}

	function testUrlsMainNSonWoW() {
		$this->mockProdEnv();

		$title = GlobalTitle::newFromText( "Main", 116, 490); # wowwiki
		$expectedUrl = "http://wowwiki.wikia.com/wiki/Portal:Main";
		$this->assertEquals( $expectedUrl, $title->getFullURL() );
	}

	/**
	 * @dataProvider urlsSpacesProvider
	 */
	function testUrlsSpaces( $environment, $title, $namespace, $city_id, $expectedUrl ) {
		$this->mockEnvironment( $environment );

		$title = GlobalTitle::newFromText( $title, $namespace, $city_id );
		$this->assertEquals( $expectedUrl, $title->getFullURL() );
	}

	function testUrlsSpecialNS() {
		$this->mockProdEnv();

		$title = GlobalTitle::newFromText( 'WikiFactory', NS_SPECIAL, 1686 ); # pl.wikia.com
		$expectedUrl = 'http://spolecznosc.wikia.com/wiki/Specjalna:WikiFactory';
		$this->assertEquals( $expectedUrl, $title->getFullURL() );
	}

	function testUrlsLocalizedNS() {
		$this->mockProdEnv();

		$title = GlobalTitle::newFromText( 'Test', NS_USER, 1686 ); # pl.wikia.com
		$expectedUrl = 'http://spolecznosc.wikia.com/wiki/U%C5%BCytkownik:Test';
		$this->assertEquals( $expectedUrl, $title->getFullURL() );
	}

	function testUrlsLocalizedSpecialPage() {
		$this->mockProdEnv();

		$title = GlobalTitle::newFromText( 'Search', NS_SPECIAL, 1686 ); # pl.wikia.com
		$expectedUrl = 'http://spolecznosc.wikia.com/wiki/Specjalna:Szukaj';
		$this->assertEquals( $expectedUrl, $title->getFullURL() );
	}

	function testUrlsWithQueryParams() {
		$this->mockProdEnv();

		$title = GlobalTitle::newFromText( "WikiFactory", NS_SPECIAL, 1686 ); # pl.wikia.com
		$this->assertStringEndsWith(
			"?diff=0&oldid=500",
			$title->getFullURL( wfArrayToCGI( [ "diff" => 0, "oldid" => 500 ] ) ),
			"verify if special pages namespace was used"
		);
	}

	function testUrlsWithUtf8() {
		$this->mockProdEnv();

		$title = GlobalTitle::newFromText( "Strona główna", false, 1686 ); # pl.wikia.com
		$this->assertStringEndsWith(
			"Strona_g%C5%82%C3%B3wna?diff=0&oldid=500",
			$title->getFullURL( wfArrayToCGI( [ "diff" => 0, "oldid" => 500 ] ) ),
			"verify if special pages namespace was used"
		);
	}

	/**
	 * @dataProvider mainPageDataProvider
	 */
	function testNewMainPageUrls( $mediaWikiMainpageContent, $exists, $availableNamespaces, $expectedNamespace, $expectedText ) {
		$this->mockProdEnv();

		$globalTitleMock = $this->getMockBuilder( 'GlobalTitle' )->setMethods( [
			'getContent',
			'exists',
			'loadNamespaceNames',
			'loadAll',
		    'getNsText'
		] )->getMock();
		$globalTitleMock->expects( $this->any() )->method( 'loadNamespaceNames' )->willReturn( $availableNamespaces );
		$globalTitleMock->expects( $this->any() )->method( 'loadAll' )->willReturn( null );
		$globalTitleMock->expects( $this->any() )->method( 'getNsText' )->willReturn( $expectedNamespace );
		$globalTitleMock->expects( $this->any() )->method( 'exists' )->willReturn( $exists );
		$globalTitleMock->expects( $this->any() )->method( 'getContent' )->willReturn( $mediaWikiMainpageContent );
		$this->mockClass( GlobalTitle::class, $globalTitleMock );

		$title = GlobalTitle::newMainPage( 177 ); // community.wikia.com

		$this->assertEquals( $title->getNamespace(), $expectedNamespace );
		$this->assertEquals( $title->getText(), $expectedText );
	}

	/**
	 * @dataProvider stripArticlePathDataProvider
	 */
	public function testStripArticlePath( $path, $articlePath, $expResult ) {
		$this->mockProdEnv();

		$this->assertEquals( GlobalTitle::stripArticlePath( $path, $articlePath ), $expResult );
	}

	public function urlsSpacesProvider() {
		return [
			[ WIKIA_ENV_DEV, 'Test Ze Spacjami', NS_TALK, 177, 'http://community.' . self::MOCK_DEV_NAME . '.wikia-dev.us/wiki/Talk:Test_Ze_Spacjami' ],
			[ WIKIA_ENV_PROD, 'Test Ze Spacjami', NS_TALK, 177, 'http://community.wikia.com/wiki/Talk:Test_Ze_Spacjami' ],
			[ WIKIA_ENV_PREVIEW, 'Test Ze Spacjami', NS_TALK, 177, 'http://community.preview.wikia.com/wiki/Talk:Test_Ze_Spacjami' ],
			[ WIKIA_ENV_VERIFY, 'Test Ze Spacjami', NS_TALK, 177, 'http://community.verify.wikia.com/wiki/Talk:Test_Ze_Spacjami' ],
			[ WIKIA_ENV_SANDBOX, 'Test Ze Spacjami', NS_TALK, 177, 'http://community.sandbox-s1.wikia.com/wiki/Talk:Test_Ze_Spacjami' ],
			[ WIKIA_ENV_STAGING, 'Test Ze Spacjami', NS_TALK, 177, 'http://community.wikia-staging.com/wiki/Talk:Test_Ze_Spacjami' ],
		];
	}


	public function stripArticlePathDataProvider() {
		return [
			['/World_of_Warcraft:_Warlords_of_Draenor','/$1','World_of_Warcraft:_Warlords_of_Draenor'],
			['/Aspatria_-_Bedford_Point_Expressway','/$1','Aspatria_-_Bedford_Point_Expressway'],
			['/wiki/Manhattan_Research,_Inc.','/wiki/$1','Manhattan_Research,_Inc.'],
			['/wiki/Ludovic_Hindman','/wiki/$1','Ludovic_Hindman'],
			['/World_of_Warcraft:_Warlords_of_Draenor/subpage','/$1','World_of_Warcraft:_Warlords_of_Draenor/subpage'],
			['/Aspatria_-_Bedford_Point_Expressway/subpage','/$1','Aspatria_-_Bedford_Point_Expressway/subpage'],
			['/wiki/Manhattan_Research,_Inc./subpage','/wiki/$1','Manhattan_Research,_Inc./subpage'],
			['/wiki/Ludovic_Hindman/subpage','/wiki/$1','Ludovic_Hindman/subpage'],
			['/World_of_Warcraft:_Warlords_of_Draenor/wiki','/$1','World_of_Warcraft:_Warlords_of_Draenor/wiki'],
			['/Aspatria_-_Bedford_Point_Expressway/wiki','/$1','Aspatria_-_Bedford_Point_Expressway/wiki'],
			['/wiki/Manhattan_Research,_Inc./wiki','/wiki/$1','Manhattan_Research,_Inc./wiki'],
			['/wiki/Ludovic_Hindman/wiki','/wiki/$1','Ludovic_Hindman/wiki'],
			['/World_of_Warcraft:_Warlords_of_Draenor/subpage','/$1','World_of_Warcraft:_Warlords_of_Draenor/subpage'],
			['/Aspatria_-_Bedford_Point_Expressway/subpage','/$1','Aspatria_-_Bedford_Point_Expressway/subpage'],
			['/wiki/Manhattan_Research,_Inc./subpage','/wiki/$1','Manhattan_Research,_Inc./subpage'],
			['/wiki/Ludovic_Hindman/subpage','/wiki/$1','Ludovic_Hindman/subpage'],
		];
	}

	public function mainPageDataProvider() {
		return [
			[
				'Whatever',
				true,
				[],
				false,
				'Whatever',
			],
			[
				'Namespace:Test',
				true,
				[ '1' => 'Namespace' ],
				1,
				'Test',
			],
			[
				'Namespace with spaces:Test',
				true,
				[ '1' => 'Namespace_with_spaces' ],
				1,
				'Test',
			],
			[
				'Namespaces_with_underlines:Test',
				true,
				[ 2 => 'Namespaces_with_underlines' ],
				2,
				'Test',
			],
			[ 'Notexists', false, [], false, 'Main Page' ],
		];
	}
}
