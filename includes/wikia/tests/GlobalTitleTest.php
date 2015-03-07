<?php

class GlobalTitleTest extends WikiaBaseTest {
	private $wgDevelEnv;
	private $wgDevelEnvName;

	function setUp() {
		parent::setUp();

		$this->disableMemCache();
		$this->getStaticMethodMock( 'WikiFactory', 'getVarValueByName' )
			->expects( $this->any() )
			->method( 'getVarValueByName' )
			->willReturnMap( [
				// basically all tests where GlobalTitle::load() is executed
				[ 'wgServer', 177, 'http://community.wikia.com' ],
				[ 'wgServer', 113, 'http://en.memory-alpha.org' ],
				[ 'wgServer', 490, 'http://www.wowwiki.com' ],
				[ 'wgServer', 1686, 'http://spolecznosc.wikia.com' ],
				/** @see testUrlsMainNSonWoW **/
				[ 'wgArticlePath', 490, '/$1' ],
				[ 'wgExtraNamespacesLocal', 490, [ 116 => 'Portal' ] ],
			] );

		global $wgDevelEnvironment,$wgDevelEnvironmentName;
		$this->wgDevelEnv = $wgDevelEnvironment;
		$this->wgDevelEnvName = $wgDevelEnvironmentName;
		$wgDevelEnvironment = false;
		$wgDevelEnvironmentName = 'qa-testing-class-' . get_class($this);
	}
	
	function tearDown() {
		global $wgDevelEnvironment,$wgDevelEnvironmentName;
		$wgDevelEnvironment = $this->wgDevelEnv;
		$wgDevelEnvironmentName = $this->wgDevelEnvName;
		
		parent::tearDown();
	}

	function testNewFromText1() {
		$title = GlobalTitle::newFromText( "Test", NS_MAIN, 177 );
		$this->assertTrue( $title->getNamespace() === NS_MAIN );
		$this->assertTrue( $title->getNsText() === "" ) ;
		$this->assertTrue( $title->getText() === "Test" );

		$title = GlobalTitle::newFromText( "Test_Ze_Spacjami", NS_MAIN, 177 );
		$this->assertEquals( "Test Ze Spacjami", $title->getText(), "Underscores, spaces expected" );
	}

	function testNewFromText2() {
		$title = GlobalTitle::newFromText( "Test", NS_TALK, 177 );
		$this->assertTrue( $title->getNamespace() === NS_TALK );
		$this->assertTrue( $title->getNsText() === "Talk" );
		$this->assertTrue( $title->getText() === "Test" );

		$title = GlobalTitle::newFromText( "Test_Ze_Spacjami", NS_TALK, 177 );
		$this->assertEquals( "Test Ze Spacjami", $title->getText(), "Underscores, spaces expected" );
	}

	function testUrlsMainNS() {
		$title = GlobalTitle::newFromText( "Timeline", NS_MAIN, 113 ); # memory-alpha
		$expectedUrl = "http://en.memory-alpha.org/wiki/Timeline";
		$this->assertEquals( $expectedUrl, $title->getFullURL() );
	}

	function testUrlsMainNSonWoW() {
		$title = GlobalTitle::newFromText( "Main", 116, 490); # wowwiki
		$expectedUrl = "http://www.wowwiki.com/Portal:Main";
		$this->assertEquals( $expectedUrl, $title->getFullURL() );
	}

	function testUrlsSpacebars() {
		$title = GlobalTitle::newFromText( "Test Ze Spacjami", NS_TALK, 177 );
		$expectedUrl = "http://community.wikia.com/wiki/Talk:Test_Ze_Spacjami";
		$this->assertEquals( $expectedUrl, $title->getFullURL() );
	}

	function testUrlsSpecialNS() {
		$title = GlobalTitle::newFromText( "WikiFactory", NS_SPECIAL, 1686 ); # pl.wikia.com
		$expectedUrl = "http://spolecznosc.wikia.com/wiki/Special:WikiFactory";
		$this->assertEquals( $expectedUrl, $title->getFullURL() );
	}

	function testUrlsWithQueryParams() {
		$title = GlobalTitle::newFromText( "WikiFactory", NS_SPECIAL, 1686 ); # pl.wikia.com
		$this->assertStringEndsWith(
			"?diff=0&oldid=500",
			$title->getFullURL( wfArrayToCGI( [ "diff" => 0, "oldid" => 500 ] ) ),
			"verify if special pages namespace was used"
		);
	}

	function testUrlsWithUtf8() {
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
		$this->assertEquals( GlobalTitle::stripArticlePath( $path, $articlePath ), $expResult );
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
};
