<?php

define( 'MEDIAWIKI', true );
// ini_set("include_path", "..".PATH_SEPARATOR);
require_once 'PHPUnit/Framework/TestSuite.php';
require_once '../../../../includes/GlobalFunctions.php';
require_once 'apiTest.php';
require_once 'pushTest.php';
require_once 'pullTest.php';
require_once 'extensionTest.php';
require_once 'PatchTest1.php';
require_once 'PatchTest2.php';


/**
 * Description of AllTests
 *
 * @author hantz
 */

class AllTests {

    public static function main() {
        PHPUnit_TextUI_TestRunner::run( self::suite() );
    }

    public static function suite() {
        $suite = new PHPUnit_Framework_TestSuite( 'p2p' );
        $suite->addTestSuite( 'PatchTest1' );
        $suite->addTestSuite( 'PatchTest2' );
        $suite->addTestSuite( 'extensionTest' );
        $suite->addTestSuite( 'apiTest' );
        $suite->addTestSuite( 'pushTest' );
        $suite->addTestSuite( 'pullTest' );
        return $suite;
    }
}

?>
