<?php
require_once 'PHPUnit/Framework/TestSuite.php';
require_once 'logootTest.php';
require_once 'logootTest1.php';


/**
 * Description of logootTestSuite
 *
 * @author Jean-Philippe Muller
 */

class logootTestSuite {

    public static function main() {
        PHPUnit_TextUI_TestRunner::run( self::suite() );
    }

    public static function suite() {
        $suite = new PHPUnit_Framework_TestSuite( 'p2p' );
        $suite->addTestSuite( 'logootTest' );
        $suite->addTestSuite( 'logootTest1' );
        return $suite;
    }
}

logootTestSuite::main();

?>
