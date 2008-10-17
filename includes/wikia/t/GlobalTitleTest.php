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
		$this->assertTrue( $title->getFullURL() === "http://memory-alpha.org/en/wiki/Timeline" );
	}

};

$test = new TestSuite("GlobaTitle tests");
$test->addTestCase(new GlobalTitleCase());
$test->run( new TextReporter() );
