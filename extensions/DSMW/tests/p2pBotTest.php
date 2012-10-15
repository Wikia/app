<?php

if ( !defined( 'MEDIAWIKI' ) ) { define( 'MEDIAWIKI', true ); }
require_once 'p2pBot.php';
require_once 'BasicBot.php';
include_once 'p2pAssert.php';
require_once '../../..//includes/GlobalFunctions.php';
require_once '../patch/Patch.php';
require_once '../files/utils.php';
require_once 'settings.php';

/**
 * Description of p2pBotTest
 *
 * @author hantz
 */
class p2pBotTest extends PHPUnit_Framework_TestCase {

    var $p2pBot1;
    var $wiki1 = WIKI1;

    public static function main() {
        require_once 'PHPUnit/TextUI/TestRunner.php';

        $suite  = new PHPUnit_Framework_TestSuite( 'MyFileTest' );
        $result = PHPUnit_TextUI_TestRunner::run( $suite );
    }

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     *
     * @access protected
     */
    protected function setUp() {
        exec( './initWikiTest.sh ./dump.sql' );
        exec( 'rm ./cache/*' );
        $basicbot1 = new BasicBot();
        $basicbot1->wikiServer = $this->wiki1;
        $this->p2pBot1 = new p2pBot( $basicbot1 );
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     *
     * @access protected
     */
    protected function tearDown() {
    // exec('./deleteTest.sh');
    }

    public function testCreatePage() {
        $pageName = "Lambach";
        $content = 'content page Lambach
[[Category:city1]]';
        $this->p2pBot1->createPage( $pageName, $content );
        assertPageExist( $this->p2pBot1->bot->wikiServer, $pageName );
        $contentFound = getContentPage( $this->p2pBot1->bot->wikiServer, $pageName );
        $this->assertEquals( $content, $contentFound );

        $pageName = "Pouxeux";
        $content = 'content page Pouxeux
[[Category:city1]]';
        $this->p2pBot1->createPage( $pageName, $content );
        $contentFound = getContentPage( $this->p2pBot1->bot->wikiServer, $pageName );
        $this->assertEquals( $content, $contentFound );
    }

    public function testAppendPage() {
        $pageName = "Lambach";
        $content = 'content page Lambach
[[Category:city1]]';
        $this->p2pBot1->createPage( $pageName, $content );
        assertPageExist( $this->p2pBot1->bot->wikiServer, $pageName );
        $contentFound = getContentPage( $this->p2pBot1->bot->wikiServer, $pageName );
        $this->assertEquals( $content, $contentFound );

        $this->p2pBot1->editPage( $pageName, "toto" );
        $content .= '
toto';
        $contentFound = getContentPage( $this->p2pBot1->bot->wikiServer, $pageName );
        $this->assertEquals( $content, $contentFound );
    }
}
?>
