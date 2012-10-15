<?php

if ( !defined( 'MEDIAWIKI' ) ) { define( 'MEDIAWIKI', true ); }
if ( defined( 'MW_INSTALL_PATH' ) ) {
    $IP = MW_INSTALL_PATH;
} else {
    $IP = dirname( '../../../../.' );
}

require_once '../../files/utils.php';
require_once '../../../../includes/GlobalFunctions.php';
require_once '../../includes/IntegrationFunctions.php';
require_once '../p2pBot.php';
require_once '../BasicBot.php';
require_once '../../logootComponent/LogootId.php';
require_once '../../logootComponent/LogootPosition.php';
require_once '../../logootComponent/LogootIns.php';
require_once '../../logootComponent/LogootDel.php';
include_once '../p2pAssert.php';
// require_once '../../DSMW.php';
require_once '../settings.php';
// require_once '../../patch/Patch.php';

// $wgAutoloadClasses['LogootId'] = "$wgDSMWIP/logootEngine/LogootId.php";


/**
 * Description of extensionTest
 *
 * @author hantz
 */
class extensionTest extends PHPUnit_Framework_TestCase {
    var $p2pBot1;
    var $p2pBot2;
    var $p2pBot3;
    var $wiki1 = WIKI1;
    var $wiki2 = WIKI2;
    var $wiki3 = WIKI3;
    var $tmpServerName;
    var $tmpScriptPath;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     *
     * @access protected
     */
    protected function setUp() {
        exec( '../initWikiTest.sh ../dump.sql' );
        exec( 'rm ../cache/*' );
        $basicbot1 = new BasicBot();
        $basicbot1->wikiServer = $this->wiki1;
        $this->p2pBot1 = new p2pBot( $basicbot1 );

        $basicbot2 = new BasicBot();
        $basicbot2->wikiServer = $this->wiki2;
        $this->p2pBot2 = new p2pBot( $basicbot2 );

        $basicbot3 = new BasicBot();
        $basicbot3->wikiServer = $this->wiki3;
        $this->p2pBot3 = new p2pBot( $basicbot3 );
    }

/*
    function testGetOperations() {
       /* global $wgServerName, $wgScriptPath;
        $wgServerName = $this->p2pBot1->bot->wikiServer;
        $wgScriptPath = '';
        //1st patch
        $pageName = "Patch:localhost/wiki1901";
        $Patchcontent='Patch: patchID: [[patchID::localhost/wiki1901]]
 onPage: [[onPage::cooper]]  hasOperation: [[hasOperation::localhost/wiki1902;
Insert;( 5053487913627490220,42601d9c1af38da968d697efde65a473 ) 901;content]] [[hasOperation::localhost/wiki1903;
Insert;( 5053487913627490222,42601d9c1af38da968d697efde65a473 ) 901;content1]]
previous: [[previous::none]]';
        $res = $this->p2pBot1->createPage($pageName,$Patchcontent);

        $operations = getOperations($patchId);
        //assert
        $this->assertEquals('2', count($operations));
    //$this->assertEquals('patch:localhost/wiki1901', $lastPatchId);
    // unset ($patch);
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

   /* function testGetRequestedPages() {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    function testGetPushFeedRequest() {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    function testGetPreviousCSID() {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    function testGetPublishedPatches() {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    function testUpdatePushFeed() {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }
 * function testLogootIntegrate() {

    }

    function testIntegrate() {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }
*/


    function testOperationToLogootOp() {
        $pageName = 'Toto';
        $content = 'toto tata titi';
        $this->assertTrue( $this->p2pBot1->createPage( $pageName, $content ),
            'failed to create page ' . $pageName . ' (' . $this->p2pBot1->bot->results . ')' );

        $patchId = getSemanticRequest( $this->p2pBot1->bot->wikiServer, '[[Patch:+]][[onPage::Toto]]', '' );
        $patchId = $patchId[0];
        $dom = getPatchXML( $this->p2pBot1->bot->wikiServer, $patchId );

        $op = $dom->getElementsByTagName( 'operation' );
        foreach ( $op as $o )
            $operations[] = $o->firstChild->nodeValue;

        $this->assertTrue( count( $operations ) == 1 );

        $op = operationToLogootOp( $operations[0] );
        $this->assertTrue( $op instanceof LogootIns, 'failed to create logootIns operation' );
        $this->assertEquals( $content, $op->getLineContent() );
    // logoutIntegrate
    }

}
?>
