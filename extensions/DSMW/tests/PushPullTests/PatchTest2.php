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




class PatchTest2 extends PHPUnit_Framework_TestCase {

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


    function testGetLastPatchIdwithConc() {
       // $patch = new Patch('', '', '', '');
        $lastPatchId = utils::getLastPatchId( 'cooper1', $this->p2pBot1->bot->wikiServer );
        // assert
        $this->assertFalse( $lastPatchId );// false because there's no previous patch
        // unset ($patch);


        /*1st patch*/
        $pageName = "Patch:localhost/wiki19010";
        $Patchcontent = 'Patch: patchID: [[patchID::Patch:Localhost/wiki19010]]
 onPage: [[onPage::cooper1]]  hasOperation: [[hasOperation::localhost/wiki1902;
Insert;( 5053487913627490220,42601d9c1af38da968d697efde65a473 ) 901;content]]
previous: [[previous::none]]';
        $res = $this->p2pBot1->createPage( $pageName, $Patchcontent );
        // $patch = new Patch('', '', '', '');
        $lastPatchId = utils::getLastPatchId( 'cooper1', $this->p2pBot1->bot->wikiServer );
        // assert
        $this->assertEquals( 'Patch:Localhost/wiki19010', $lastPatchId );
        // unset ($patch);

        /*2nd patch*/
        $pageName = "Patch:localhost/wiki19020";
        $Patchcontent = 'Patch: patchID: [[patchID::Patch:Localhost/wiki19020]]
 onPage: [[onPage::cooper1]]  hasOperation: [[hasOperation::localhost/wiki1902;
Insert;( 5053487913627490220,42601d9c1af38da968d697efde65a473 ) 901;content]]
previous: [[previous::Patch:Localhost/wiki19010]]';
        $res = $this->p2pBot1->createPage( $pageName, $Patchcontent );
        // $patch = new Patch('', '', '', '');
        $lastPatchId = utils::getLastPatchId( 'cooper1', $this->p2pBot1->bot->wikiServer );
        // assert
        $this->assertEquals( 'Patch:Localhost/wiki19020', $lastPatchId );
        // unset ($patch);

        /*3rd patch*/
        $pageName = "Patch:localhost/wiki18020";
        $Patchcontent = 'Patch: patchID: [[patchID::Patch:Localhost/wiki18020]]
 onPage: [[onPage::cooper1]]  hasOperation: [[hasOperation::localhost/wiki1902;
Insert;( 5053487913627490220,42601d9c1af38da968d697efde65a473 ) 901;content]]
previous: [[previous::Patch:Localhost/wiki19020]]';
        $res = $this->p2pBot1->createPage( $pageName, $Patchcontent );
        // $patch = new Patch('', '', '', '');
        $lastPatchId = utils::getLastPatchId( 'cooper1', $this->p2pBot1->bot->wikiServer );
        // assert
        $this->assertEquals( 'Patch:Localhost/wiki18020', $lastPatchId );
        // unset ($patch);

        /*4th patch*/
        $pageName = "Patch:localhost/wiki18030";
        $Patchcontent = 'Patch: patchID: [[patchID::Patch:Localhost/wiki18030]]
 onPage: [[onPage::cooper1]]  hasOperation: [[hasOperation::localhost/wiki1902;
Insert;( 5053487913627490220,42601d9c1af38da968d697efde65a473 ) 901;content]]
previous: [[previous::Patch:Localhost/wiki19020]]';
        $res = $this->p2pBot1->createPage( $pageName, $Patchcontent );
        // $patch = new Patch('', '', '', '');
        $lastPatchId = utils::getLastPatchId( 'cooper1', $this->p2pBot1->bot->wikiServer );
        // assert
        $patchid = array_shift( $lastPatchId );
        $this->assertEquals( 'Patch:Localhost/wiki18020', $patchid );
        $patchid = array_shift( $lastPatchId );
        $this->assertEquals( 'Patch:Localhost/wiki18030', $patchid );
       // unset ($patch);

        /*5th patch*/
        $pageName = "Patch:localhost/wiki17000";
        $Patchcontent = 'Patch: patchID: [[patchID::Patch:Localhost/wiki17000]]
 onPage: [[onPage::cooper1]]  hasOperation: [[hasOperation::localhost/wiki1902;
Insert;( 5053487913627490220,42601d9c1af38da968d697efde65a473 ) 901;content]]
previous: [[previous::Patch:Localhost/wiki18030;Patch:Localhost/wiki18020]]';
        $res = $this->p2pBot1->createPage( $pageName, $Patchcontent );
        // $patch = new Patch('', '', '', '');
        $lastPatchId = utils::getLastPatchId( 'cooper1', $this->p2pBot1->bot->wikiServer );
        // assert
        $this->assertEquals( 'Patch:Localhost/wiki17000', $lastPatchId );
        // unset ($patch);

        /*6th patch*/
        $pageName = "Patch:localhost/wiki19050";
        $Patchcontent = 'Patch: patchID: [[patchID::Patch:Localhost/wiki19050]]
 onPage: [[onPage::cooper1]]  hasOperation: [[hasOperation::localhost/wiki1902;
Insert;( 5053487913627490220,42601d9c1af38da968d697efde65a473 ) 901;content]]
previous: [[previous::Patch:Localhost/wiki17000]]';
        $res = $this->p2pBot1->createPage( $pageName, $Patchcontent );
        // $patch = new Patch('', '', '', '');
        $lastPatchId = utils::getLastPatchId( 'cooper1', $this->p2pBot1->bot->wikiServer );
        // assert
        $this->assertEquals( 'Patch:Localhost/wiki19050', $lastPatchId );
        // unset ($patch);
    }

}

?>
