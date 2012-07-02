<?php
// require_once('../DSMW.php');
require_once( '../../patch/Patch.php' );
require_once( '../../files/utils.php' );
require_once( '../../clockEngine/persistentClock.php' );
require_once '../p2pBot.php';
require_once '../BasicBot.php';
require_once '../settings.php';

/**
 * Description of Test_2
 *
 * @author mullejea
 */




class PatchTest1 extends PHPUnit_Framework_TestCase {

    var $p2pBot1;
    var $wiki1 = WIKI1;

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
    }


    function testGetLastPatchIdwithoutConc() {

        // $patch = new Patch('', '', '', '');
        $lastPatchId = utils::getLastPatchId( 'cooper', $this->p2pBot1->bot->wikiServer );
        // assert
        $this->assertFalse( $lastPatchId );// false because there's no previous patch
        // unset ($patch);


        /*1st patch*/
        $pageName = "Patch:localhost/wiki1901";
        $Patchcontent = 'Patch: patchID: [[patchID::Patch:Localhost/wiki1901]]
 onPage: [[onPage::cooper]]  hasOperation: [[hasOperation::localhost/wiki1902;
Insert;( 5053487913627490220,42601d9c1af38da968d697efde65a473 ) 901;content]]
previous: [[previous::none]]';
        $this->assertTrue( $this->p2pBot1->createPage( $pageName, $Patchcontent ), $this->p2pBot1->bot->results );
        // $patch = new Patch('', '', '', '');
        $lastPatchId = utils::getLastPatchId( 'cooper', $this->p2pBot1->bot->wikiServer );
        // assert
        $this->assertEquals( 'Patch:Localhost/wiki1901', $lastPatchId );
       // unset ($patch);

        /*2nd patch*/
        $pageName = "Patch:localhost/wiki1902";
        $Patchcontent = 'Patch: patchID: [[patchID::Patch:Localhost/wiki1902]]
 onPage: [[onPage::cooper]]  hasOperation: [[hasOperation::localhost/wiki1902;
Insert;( 5053487913627490220,42601d9c1af38da968d697efde65a473 ) 901;content]]
previous: [[previous::Patch:Localhost/wiki1901]]';
        $res = $this->p2pBot1->createPage( $pageName, $Patchcontent );
        // $patch = new Patch('', '', '', '');
        $lastPatchId = utils::getLastPatchId( 'cooper', $this->p2pBot1->bot->wikiServer );
        // assert
        $this->assertEquals( 'Patch:Localhost/wiki1902', $lastPatchId );
        // unset ($patch);

        /*3rd patch*/
        $pageName = "Patch:localhost/wiki1802";
        $Patchcontent = 'Patch: patchID: [[patchID::Patch:Localhost/wiki1802]]
 onPage: [[onPage::cooper]]  hasOperation: [[hasOperation::localhost/wiki1902;
Insert;( 5053487913627490220,42601d9c1af38da968d697efde65a473 ) 901;content]]
previous: [[previous::Patch:Localhost/wiki1902]]';
        $res = $this->p2pBot1->createPage( $pageName, $Patchcontent );
        // $patch = new Patch('', '', '', '');
        $lastPatchId = utils::getLastPatchId( 'cooper', $this->p2pBot1->bot->wikiServer );
        // assert
        $this->assertEquals( 'Patch:Localhost/wiki1802', $lastPatchId );
       // unset ($patch);

        /*4th patch*/
        $pageName = "Patch:localhost/wiki1803";
        $Patchcontent = 'Patch: patchID: [[patchID::Patch:Localhost/wiki1803]]
 onPage: [[onPage::cooper]]  hasOperation: [[hasOperation::localhost/wiki1902;
Insert;( 5053487913627490220,42601d9c1af38da968d697efde65a473 ) 901;content]]
previous: [[previous::Patch:Localhost/wiki1802]]';
        $res = $this->p2pBot1->createPage( $pageName, $Patchcontent );
        // $patch = new Patch('', '', '', '');
        $lastPatchId = utils::getLastPatchId( 'cooper', $this->p2pBot1->bot->wikiServer );
        // assert
        $this->assertEquals( 'Patch:Localhost/wiki1803', $lastPatchId );
        // unset ($patch);

        /*5th patch*/
        $pageName = "Patch:localhost/wiki1700";
        $Patchcontent = 'Patch: patchID: [[patchID::Patch:Localhost/wiki1700]]
 onPage: [[onPage::cooper]]  hasOperation: [[hasOperation::localhost/wiki1902;
Insert;( 5053487913627490220,42601d9c1af38da968d697efde65a473 ) 901;content]]
previous: [[previous::Patch:Localhost/wiki1803]]';
        $res = $this->p2pBot1->createPage( $pageName, $Patchcontent );
        // $patch = new Patch('', '', '', '');
        $lastPatchId = utils::getLastPatchId( 'cooper', $this->p2pBot1->bot->wikiServer );
        // assert
        $this->assertEquals( 'Patch:Localhost/wiki1700', $lastPatchId );
        // unset ($patch);

        /*6th patch*/
        $pageName = "Patch:localhost/wiki1905";
        $Patchcontent = 'Patch: patchID: [[patchID::Patch:Localhost/wiki1905]]
 onPage: [[onPage::cooper]]  hasOperation: [[hasOperation::localhost/wiki1902;
Insert;( 5053487913627490220,42601d9c1af38da968d697efde65a473 ) 901;content]]
previous: [[previous::Patch:Localhost/wiki1700]]';
        $res = $this->p2pBot1->createPage( $pageName, $Patchcontent );
        // $patch = new Patch('', '', '', '');
        $lastPatchId = utils::getLastPatchId( 'cooper', $this->p2pBot1->bot->wikiServer );
        // assert
        $this->assertEquals( 'Patch:Localhost/wiki1905', $lastPatchId );
        // unset ($patch);

    }


}

?>
