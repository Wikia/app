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
 * Description of p2pAttachmentTest6
 *
 * @author Émile Morel
 */


class p2pAttachmentsTest6 extends PHPUnit_Framework_TestCase {

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
    var $file = 'Ours.pdf';
    var $filePage = 'File:Ours.pdf';
    var $file11 = 'ours1.pdf';
    var $file12 = 'ours2.pdf';

    var $file2 = 'Ours.jpg';
    var $filePage2 = 'File:Ours.jpg';
    var $file21 = 'Ours1.jpg';
    var $file22 = 'Ours2.jpg';

    var $file_size1;
    var $file_size2;
    var $file_size3;
    var $file_size4;

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

        // trois fichiers images de tailles differentes pour les reconnaitres.
        $this->file_size1 = filesize( $this->fileDir . $this->file11 );
        $this->file_size2 = filesize( $this->fileDir . $this->file12 );
        $this->file_size3 = filesize( $this->fileDir . $this->file21 );
        $this->file_size4 = filesize( $this->fileDir . $this->file22 );
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
     * modify the attachment on wiki2 , push it
     * pull it on wiki1
     * the tow wiki must have the same page and attachment
     */
    public function testSimple1() {
        // create page
        $this->assertTrue( $this->p2pBot1->createPage( $this->pageName, $this->content ),
                'Failed to create page ' . $this->pageName . ' (' . $this->p2pBot1->bot->results . ')' );

        // assert page Ours exist on wiki1
        assertPageExist( $this->p2pBot1->bot->wikiServer, $this->pageName );

        // upload the file on wiki1
        $this->assertTrue( $this->p2pBot1->uploadFile( $this->fileDir . $this->file11, $this->file, '0' ) );

        // test if the good file was upload on wiki1
        $this->assertTrue( $this->p2pBot1->getFileFeatures( $this->file, $this->file_size1 ) );

        // edit File:Ours.jpg on wiki1
        $this->assertTrue( $this->p2pBot1->editPage( $this->filePage, $this->pushRequest ),
            'failed to edit page ' . $this->filePage . ' ( ' . $this->p2pBot1->bot->results . ' )' );

        // upload the second file on wiki1
        $this->assertTrue( $this->p2pBot1->uploadFile( $this->fileDir . $this->file21, $this->file2, '0' ) );

        // test if the good file was upload on wiki1
        $this->assertTrue( $this->p2pBot1->getFileFeatures( $this->file2, $this->file_size3 ) );

        // edit File:Ours.pdf on wiki1
        $this->assertTrue( $this->p2pBot1->editPage( $this->filePage2, $this->pushRequest ),
            'failed to edit page ' . $this->filePage . ' ( ' . $this->p2pBot1->bot->results . ' )' );

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

        // change file on wiki2
        $this->assertTrue( $this->p2pBot2->uploadFile( $this->fileDir . $this->file12, $this->file, '1' ) );

        // test if the good file was upload on wiki2
        $this->assertTrue( $this->p2pBot2->getFileFeatures( $this->file, $this->file_size2 ) );

        // change second file on wiki2
        $this->assertTrue( $this->p2pBot2->uploadFile( $this->fileDir . $this->file22, $this->file2, '1' ) );

        // test if the good file was upload on wiki2
        $this->assertTrue( $this->p2pBot2->getFileFeatures( $this->file2, $this->file_size4 ) );

        // create push on wiki2
        $this->assertTrue( $this->p2pBot2->createPush( $this->pushName, $this->pushRequest ),
                'Failed to create push : ' . $this->pushName . ' (' . $this->p2pBot2->bot->results . ')' );

        // push
        $this->assertTrue( $this->p2pBot2->push( $this->pushFeed ),
                'failed to push ' . $this->pushFeed . ' (' . $this->p2pBot2->bot->results . ')' );

        // create pull on wiki1
        $this->assertTrue( $this->p2pBot1->createPull( $this->pullName, $this->wiki2, $this->pushName ),
                'failed to create pull ' . $this->pullName . ' (' . $this->p2pBot1->bot->results . ')' );

        // pull
        $this->assertTrue( $this->p2pBot1->Pull( $this->pullFeed ),
                'failed to pull ' . $this->pullFeed . ' (' . $this->p2pBot1->bot->results . ')' );

        // test if the good file was upload on wiki1
        $this->assertTrue( $this->p2pBot1->getFileFeatures( $this->file, $this->file_size2 ) );
        // test if the good file was upload on wiki1
        $this->assertTrue( $this->p2pBot1->getFileFeatures( $this->file2, $this->file_size4 ) );

        $PatchonWiki1 = getSemanticRequest( $this->p2pBot1->bot->wikiServer, '[[Patch:+]][[onPage::' . $this->filePage . ']]', '-3FpatchID' );
        $PatchonWiki1 = arraytolower( $PatchonWiki1 );
        $PatchonWiki2 = getSemanticRequest( $this->p2pBot2->bot->wikiServer, '[[Patch:+]][[onPage::' . $this->filePage . ']]', '-3FpatchID' );
        $PatchonWiki2 = arraytolower( $PatchonWiki2 );
        $this->assertEquals( count( $PatchonWiki1 ), count( $PatchonWiki2 ) );

        $PatchonWiki1 = getSemanticRequest( $this->p2pBot1->bot->wikiServer, '[[Patch:+]][[onPage::' . $this->filePage2 . ']]', '-3FpatchID' );
        $PatchonWiki1 = arraytolower( $PatchonWiki1 );
        $PatchonWiki2 = getSemanticRequest( $this->p2pBot2->bot->wikiServer, '[[Patch:+]][[onPage::' . $this->filePage2 . ']]', '-3FpatchID' );
        $PatchonWiki2 = arraytolower( $PatchonWiki2 );
        $this->assertEquals( count( $PatchonWiki1 ), count( $PatchonWiki2 ) );

        // assert that wiki1/File:Ours == wiki2/File:Ours
        assertContentEquals( $this->p2pBot1->bot->wikiServer, $this->p2pBot2->bot->wikiServer, $this->filePage );
        // assert that wiki1/File:Ours == wiki2/File:Ours
        assertContentEquals( $this->p2pBot1->bot->wikiServer, $this->p2pBot2->bot->wikiServer, $this->filePage2 );
    }

    function viderRepertoire() {
    }
}

?>
