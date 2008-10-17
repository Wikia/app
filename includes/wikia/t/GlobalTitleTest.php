<?php


putenv( "MW_INSTALL_PATH=/srv/web/l1/" );
putenv( "SERVER_ID=177" );
ini_set( "include_path", dirname(__FILE__)."/../../../" );

require_once( dirname(__FILE__) . "/../../../maintenance/commandLine.inc" );
require_once( $IP . "/includes/wikia/GlobalTitle.php" );

require_once( "simpletest/autorun.php" );
require_once( "simpletest/reporter.php" );



class GlobalTitleCase extends UnitTestCase {

	function testNewFromText1Param() {
		$title = GlobalTitle::newFromText( "Test" );
		$this->assertTrue( $title->getNamespace() === NS_MAIN );
		$this->assertTrue( $title->getNsText() === "" ) ;
	}

	function testNewFromText2Param() {
		$title = GlobalTitle::newFromText( "Test", NS_TALK );
		$this->assertTrue( $title->getNamespace() === NS_TALK );
		$this->assertTrue( $title->getNsText() === "Talk" ) ;
	}

};

$test = new TestSuite("GlobaTitle tests");
$test->addTestCase(new GlobalTitleCase());
$test->run( new TextReporter() );
