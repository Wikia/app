<?php

if ( !defined( 'MEDIAWIKI' ) ) { define( 'MEDIAWIKI', true ); }
require_once 'p2pBot.php';
require_once 'BasicBot.php';
include_once 'p2pAssert.php';
require_once '../../../includes/GlobalFunctions.php';
require_once '../patch/Patch.php';
require_once '../files/utils.php';
require_once 'settings.php';

$wgDebugLogGroups  = array(
        'p2p' => "/tmp/p2p.log",
);

/**
 * Description of p2pAttachmentTest7
 *
 * @author Émile Morel
 */


class p2pAttachmentsTest7 extends PHPUnit_Framework_TestCase {

    var $p2pBot1;
    var $p2pBot2;
    var $wiki1 = WIKI1;
    var $wiki2 = WIKI2;

    var $pageName = "Ours";
    var $pushRequest = "[[Category:Animal]]";
    var $pushFeed = 'PushFeed:PushAnimal';
    var $pullFeed = 'PullFeed:PullAnimal';
    var $pushName = 'PushAnimal';
    var $pullName = 'PullAnimal';

    var $fileDir = 'Import/';
    var $file = 'Ours';
    var $filePage = 'File:Ours';

    var $nb;

    var $content = "Les ours (ou ursinés, du latin ŭrsus, de même sens) sont de grands
mammifères plantigrades appartenant à la famille des ursidés. Il
n'existe que huit espèces d'ours vivants, mais ils sont largement
répandus et apparaissent dans une grande variété d'habitats, aussi
bien dans l'hémisphère nord qu'une partie de l'hémisphère sud. Les
ours vivent dans les continents d'Europe, d'Amérique du Nord,
d'Amérique du Sud, et en Asie.
[[Image:ours.jpg|right|frame|Un Ours]]
[[Category:Animal]]";

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

        $basicbot2 = new BasicBot();
        $basicbot2->wikiServer = $this->wiki2;
        $this->p2pBot2 = new p2pBot( $basicbot2 );

        $this->nb = 100;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     *
     * @access protected
     */
    protected function tearDown() {
        $this->viderRepertoire();
        // exec('./deleteTest.sh');
    }


    /**
     * Create one page with tow attachment, push it
     * pull it on wiki2
     */
    public function testSimple1() {
        // create page
        $this->assertTrue( $this->p2pBot1->createPage( $this->pageName, $this->content ),
                'Failed to create page ' . $this->pageName . ' (' . $this->p2pBot1->bot->results . ')' );

        // assert page Ours exist on wiki1
        assertPageExist( $this->p2pBot1->bot->wikiServer, $this->pageName );

        system( "cp Import/Ours1.jpg cache/Ours1.jpg" );
        $file_size = filesize( "cache/Ours1.jpg" );

        for ( $i = 1; $i <= $this->nb; $i++ ) {

            $file = "cache/Ours" . $i . ".jpg";

            // upload the file on wiki1
            $this->assertTrue( $this->p2pBot1->uploadFile( $file, $this->file . $i . ".jpg", '0' ) );

            // test if the good file was upload on wiki1
            $this->assertTrue( $this->p2pBot1->getFileFeatures( $this->file . $i . ".jpg", $file_size ) );

            // edit File:Ours.jpg on wiki1
            $this->assertTrue( $this->p2pBot1->editPage( $this->filePage . $i . ".jpg", $this->pushRequest ),
                    'failed to edit page ' . $this->filePage . ' ( ' . $this->p2pBot1->bot->results . ' )' );

            // remove file
            system( "mv cache/Ours" . $i . ".jpg cache/Ours" . ( $i + 1 ) . ".jpg" );
        }

        system( "rm cache/Ours*" );

        // create push on wiki1
        $this->assertTrue( $this->p2pBot1->createPush( $this->pushName, $this->pushRequest ),
                'Failed to create push : ' . $this->pushName . ' (' . $this->p2pBot1->bot->results . ')' );

        // push
        $this->assertTrue( $this->p2pBot1->push( $this->pushFeed ),
                'failed to push ' . $this->pushFeed . ' (' . $this->p2pBot2->bot->results . ')' );

        // create pull on wiki2
        $this->assertTrue( $this->p2pBot2->createPull( $this->pullName, $this->wiki1, $this->pushName ),
                'failed to create pull ' . $this->pullName . ' (' . $this->p2pBot2->bot->results . ')' );

        // pull
        $this->assertTrue( $this->p2pBot2->Pull( $this->pullFeed ),
                'failed to pull ' . $this->pullFeed . ' (' . $this->p2pBot2->bot->results . ')' );

        $PatchonWiki1 = getSemanticRequest( $this->p2pBot1->bot->wikiServer, '[[Patch:+]]', '-3FpatchID' );
        $PatchonWiki1 = arraytolower( $PatchonWiki1 );
        $PatchonWiki2 = getSemanticRequest( $this->p2pBot2->bot->wikiServer, '[[Patch:+]]', '-3FpatchID' );
        $PatchonWiki2 = arraytolower( $PatchonWiki2 );
        $this->assertEquals( count( $PatchonWiki1 ), count( $PatchonWiki2 ) );

    }

    function viderRepertoire() {
    }
}

?>
