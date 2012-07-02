<?php

define( 'MEDIAWIKI', true );
require_once 'PHPUnit/Framework/TestSuite.php';
require_once '../../../includes/GlobalFunctions.php';
require_once 'p2pTest1.php';
require_once 'p2pTest2.php';
require_once 'p2pTest3.php';
require_once 'p2pTest4.php';
require_once 'p2pTest5.php';
require_once 'p2pTest6.php';
require_once 'p2pTest10.php';
require_once 'p2pAttachmentsTest1.php';
require_once 'p2pAttachmentsTest2.php';
require_once 'p2pAttachmentsTest3.php';
require_once 'p2pAttachmentsTest4.php';
require_once 'p2pAttachmentsTest5.php';
require_once 'p2pAttachmentsTest6.php';
require_once 'p2pAttachmentsTest7.php';



/**
 * Description of AllTests
 * execute all functionnal tests
 * @author hantz, jean-philippe muller
 */

class AllTests {

    public static function main() {
        PHPUnit_TextUI_TestRunner::run( self::suite() );
    }

    public static function suite() {
        $suite = new PHPUnit_Framework_TestSuite( 'p2p' );
        $suite->addTestSuite( 'p2pTest1' );
        $suite->addTestSuite( 'p2pTest2' );
        $suite->addTestSuite( 'p2pTest3' );
        $suite->addTestSuite( 'p2pTest4' );
        $suite->addTestSuite( 'p2pTest5' );
        $suite->addTestSuite( 'p2pTest6' );
        $suite->addTestSuite( 'p2pTest10' );
        $suite->addTestSuite( 'p2pAttachmentsTest1' );
        $suite->addTestSuite( 'p2pAttachmentsTest2' );
        $suite->addTestSuite( 'p2pAttachmentsTest3' );
        $suite->addTestSuite( 'p2pAttachmentsTest4' );
        $suite->addTestSuite( 'p2pAttachmentsTest5' );
        $suite->addTestSuite( 'p2pAttachmentsTest6' );
        $suite->addTestSuite( 'p2pAttachmentsTest7' );
        return $suite;
    }
}

// AllTests::main();

?>
