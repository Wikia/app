<?php

/**
 * @group GlobalTitle
 * @group Integration
 */
class GlobalTitleIntegrationTest extends WikiaDatabaseTest {
	use MockEnvironmentTrait;

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

		$title = GlobalTitle::newFromText( "Main", 116, 490 ); # wow
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
	 * @dataProvider stripArticlePathDataProvider
	 */
	public function testStripArticlePath( $path, $articlePath, $expResult ) {
		$this->mockProdEnv();

		$this->assertEquals( GlobalTitle::stripArticlePath( $path, $articlePath ), $expResult );
	}

	/**
	 * @dataProvider httpsUrlsProvider
	 */
	public function testHTTPSUrls( $cityId, $requestProtocol, $expectedUrl ) {
		$this->mockProdEnv();

		if ( isset( $_SERVER['HTTP_FASTLY_SSL'] ) ) {
			$orig = $_SERVER['HTTP_FASTLY_SSL'];
		}

		try {
			$_SERVER['HTTP_FASTLY_SSL'] = $requestProtocol === 'https';

			$fullUrl = GlobalTitle::newFromText( 'Test', NS_MAIN, $cityId )->getFullURL();
			$this->assertEquals( $expectedUrl, $fullUrl );
		} finally {
			if ( isset( $orig ) ) {
				$_SERVER['HTTP_FASTLY_SSL'] = $orig;
			}
		}
	}

	public function urlsSpacesProvider() {
		return [
			[ WIKIA_ENV_PROD, 'Test Ze Spacjami', NS_TALK, 177, 'http://community.fandom.com/wiki/Talk:Test_Ze_Spacjami' ],
			[ WIKIA_ENV_PREVIEW, 'Test Ze Spacjami', NS_TALK, 177, 'http://community.preview.fandom.com/wiki/Talk:Test_Ze_Spacjami' ],
			[ WIKIA_ENV_VERIFY, 'Test Ze Spacjami', NS_TALK, 177, 'http://community.verify.fandom.com/wiki/Talk:Test_Ze_Spacjami' ],
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

	public function httpsUrlsProvider() {
		return [
			[ 177, 'http', 'http://community.fandom.com/wiki/Test' ],
			[ 177, 'https', 'https://community.fandom.com/wiki/Test' ],
			[ 165, 'http', 'http://firefly.wikia.com/wiki/Test' ],
			[ 165, 'https', 'https://firefly.wikia.com/wiki/Test' ],
			[ 5931, 'http', 'http://ja.starwars.wikia.com/wiki/Test' ],
			[ 5931, 'https', 'http://ja.starwars.wikia.com/wiki/Test' ],
		];
	}

	protected function getDataSet() {
		return $this->createYamlDataSet( __DIR__ . '/_fixtures/global_title.yaml' );
	}
}
