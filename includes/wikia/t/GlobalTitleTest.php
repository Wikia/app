<?php


putenv( "MW_INSTALL_PATH=/srv/web/l1/" );
putenv( "SERVER_ID=177" );
ini_set( "include_path", dirname(__FILE__)."/../../../" );

require_once( dirname(__FILE__) . "/../../../maintenance/commandLine.inc" );
require_once( $IP . "/includes/wikia/GlobalTitle.php" );

require_once( "simpletest/autorun.php" );
require_once( "simpletest/reporter.php" );



class GlobalTitleCase extends UnitTestCase {

	function testNewFromText1() {
		$title = GlobalTitle::newFromText( "Test", NS_MAIN, 177 );
		$this->assertTrue( $title->getNamespace() === NS_MAIN );
		$this->assertTrue( $title->getNsText() === "" ) ;
		$this->assertTrue( $title->getText() === "Test" );

		$title = GlobalTitle::newFromText( "Test_Ze_Spacjami", NS_MAIN, 177 );
		$this->assertTrue( $title->getText() === "Test Ze Spacjami", "Underscores, spaces expected" );

	}

	function testNewFromText2() {
		$title = GlobalTitle::newFromText( "Test", NS_TALK, 177 );
		$this->assertTrue( $title->getNamespace() === NS_TALK );
		$this->assertTrue( $title->getNsText() === "Talk" );
		$this->assertTrue( $title->getText() === "Test" );

		$title = GlobalTitle::newFromText( "Test_Ze_Spacjami", NS_TALK, 177 );
		$this->assertTrue( $title->getText() === "Test Ze Spacjami", "Underscores, spaces expected" );

	}

	function testUrls() {
		$title = GlobalTitle::newFromText( "Timeline", NS_MAIN, 113 ); # memory-alpha
		$url = "http://memory-alpha.org/en/wiki/Timeline";
		$this->assertTrue( $title->getFullURL() === $url, sprintf("%s = %s, NOT MATCH", $title->getFullURL(), $url ) );

		$title = GlobalTitle::newFromText( "Main", 116, 490); # wowwiki
		$url = "http://www.wowwiki.com/Portal:Main";
		$this->assertTrue( $title->getFullURL() === $url, sprintf("%s = %s, NOT MATCH", $title->getFullURL(), $url ) );

		/**
		 * spaces
		 */
		$title = GlobalTitle::newFromText( "Test Ze Spacjami", NS_TALK, 177 );
		$url = "http://www.wikia.com/wiki/Talk:Test_Ze_Spacjami";
		$this->assertTrue( $title->getFullURL() === $url, sprintf("%s = %s, NOT MATCH", $title->getFullURL(), $url ) );

		/**
		 * Polish wikia
		 */
		$title = GlobalTitle::newFromText( "WikiFactory", NS_SPECIAL, 1686 ); # pl.wikia.com
		$url = "http://pl.wikia.com/wiki/Special:WikiFactory";
		$this->assertTrue( $title->getFullURL() === $url, sprintf("%s = %s, NOT MATCH", $title->getFullURL(), $url ) );

		$url = "http://pl.wikia.com/wiki/Special:WikiFactory?diff=0&oldid=500";
		$this->assertTrue( $title->getFullURL( wfArrayToCGI(array( "diff" => 0, "oldid" => 500 ) ) ) === $url, sprintf("%s = %s, NOT MATCH", $title->getFullURL(), $url ) );
		;

		$title = GlobalTitle::newFromText( "Strona główna", false, 1686 ); # pl.wikia.com
		$url = "http://pl.wikia.com/wiki/Strona_g%C5%82%C3%B3wna?diff=0&oldid=500";
		$this->assertTrue( $title->getFullURL( wfArrayToCGI(array( "diff" => 0, "oldid" => 500 ) ) ) === $url, "NOT MATCH" );

		$title = GlobalTitle::newFromText( "Search_Wikia", 0, 94 ); # search.wikia.com
		$url = "http://search.wikia.com/wiki/Search_Wikia";
		$this->assertTrue( $title->getFullURL( ) === $url, "NOT MATCH" );

		$title = GlobalTitle::newFromText( "Search_Wikia", 1, 94 ); # search.wikia.com
		$url = "http://search.wikia.com/wiki/Talk:Search_Wikia";
		$this->assertTrue( $title->getFullURL( ) === $url, "NOT MATCH" );

	}

};

$test = new TestSuite("GlobaTitle tests");
$test->addTestCase(new GlobalTitleCase());
$test->run( new TextReporter() );
