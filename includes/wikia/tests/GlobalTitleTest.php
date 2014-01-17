<?php
class GlobalTitleTest extends PHPUnit_Framework_TestCase {
	private $wgDevelEnv;
	private $wgDevelEnvName;
	
	function setUp() {
		parent::setUp();
		
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

		$this->assertFalse( $title instanceof Title );
		$this->assertTrue( $title instanceof GlobalTitle );

		$this->assertTrue( $title->getNamespace() === NS_MAIN );
		$this->assertTrue( $title->getNsText() === "" ) ;
		$this->assertTrue( $title->getText() === "Test" );

		$title = GlobalTitle::newFromText( "Test_Ze_Spacjami", NS_MAIN, 177 );
		$this->assertEquals( "Test Ze Spacjami", $title->getText(), "Underscores, spaces expected" );
		$this->assertEquals( "Test_Ze_Spacjami", $title->getPrefixedDBkey() );
	}

	function testNewFromText2() {
		$title = GlobalTitle::newFromText( "Test", NS_TALK, 177 );
		$this->assertTrue( $title->getNamespace() === NS_TALK );
		$this->assertTrue( $title->getNsText() === "Talk" );
		$this->assertTrue( $title->getText() === "Test" );
		$this->assertEquals( "Talk:Test", $title->getPrefixedDBkey() );
		$this->assertEquals( "Talk:Test", $title->getPrefixedText() );

		$title = GlobalTitle::newFromText( "Test_Ze_Spacjami", NS_TALK, 177 );
		$this->assertEquals( "Test Ze Spacjami", $title->getText(), "Underscores, spaces expected" );
		$this->assertEquals( "Talk:Test Ze Spacjami", $title->getPrefixedText() );
	}
	
	function testUrlsMainNS() {
		$title = GlobalTitle::newFromText( "Timeline", NS_MAIN, 113 ); # memory-alpha
		$url = "http://en.memory-alpha.org/wiki/Timeline";
		$this->assertTrue( $title->getFullURL() === $url, sprintf("%s = %s, NOT MATCH", $title->getFullURL(), $url ) );
	}
	
	function testUrlsMainNSonWoW() {
		$title = GlobalTitle::newFromText( "Main", 116, 490); # wowwiki
		$url = "http://www.wowwiki.com/Portal:Main";
		$this->assertTrue( $title->getFullURL() === $url, sprintf("%s = %s, NOT MATCH", $title->getFullURL(), $url ) );
	}
	
	function testUrlsSpacebars() {
		$title = GlobalTitle::newFromText( "Test Ze Spacjami", NS_TALK, 177 );
		$url = "http://community.wikia.com/wiki/Talk:Test_Ze_Spacjami";
		$this->assertTrue( $title->getFullURL() === $url, sprintf("%s = %s, NOT MATCH", $title->getFullURL(), $url ) );
	}
	
	function testUrlsPolishWiki() {
		$title = GlobalTitle::newFromText( "WikiFactory", NS_SPECIAL, 1686 ); # pl.wikia.com
		$url = "http://spolecznosc.wikia.com/wiki/Special:WikiFactory";
		$this->assertTrue( $title->getFullURL() === $url, sprintf("%s = %s, NOT MATCH", $title->getFullURL(), $url ) );

		$url = "http://spolecznosc.wikia.com/wiki/Special:WikiFactory?diff=0&oldid=500";
		$this->assertTrue( $title->getFullURL( wfArrayToCGI(array( "diff" => 0, "oldid" => 500 ) ) ) === $url, sprintf("%s = %s, NOT MATCH", $title->getFullURL(), $url ) );

		$title = GlobalTitle::newFromText( "Strona główna", false, 1686 ); # pl.wikia.com
		$url = "http://spolecznosc.wikia.com/wiki/Strona_g%C5%82%C3%B3wna?diff=0&oldid=500";
		$this->assertTrue( $title->getFullURL( wfArrayToCGI(array( "diff" => 0, "oldid" => 500 ) ) ) === $url, "NOT MATCH" );
	}

	function testSquidURLs() {
		$title = GlobalTitle::newFromText( "Test", NS_MAIN, 177 );
		$squidURLs = $title->getSquidURLs();

		$this->assertContains('http://community.wikia.com/wiki/Test', $squidURLs);
		$this->assertContains('http://community.wikia.com/wiki/Test?action=history', $squidURLs);
	}
};
