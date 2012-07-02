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
 * Description of p2pAttachmentTest3
 *
 * @author Émile Morel
 */


class p2pAttachmentsTest3 extends PHPUnit_Framework_TestCase {

    var $p2pBot1;
    var $p2pBot2;
    var $p2pBot3;
    var $wiki1 = WIKI1;
    var $wiki2 = WIKI2;
    var $wiki3 = WIKI3;
    var $pageName = "Ours";
    var $pushRequest = "[[Category:Animal]]";
    var $pushFeed = 'PushFeed:PushAnimal';
    var $pullFeed = 'PullFeed:PullAnimal';
    var $pushName = 'PushAnimal';
    var $pullName = 'PullAnimal';
    var $fileDir = 'Import/';
    var $file = 'Ours.jpg';
    var $filePage = 'File:Ours.jpg';
    var $file1 = 'Ours1.jpg';
    var $file2 = 'Ours2.jpg';
    var $file3 = 'Ours3.jpg';
    var $file_size1;
    var $file_size2;
    var $file_size3;
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

        $basicbot3 = new BasicBot();
        $basicbot3->wikiServer = $this->wiki3;
        $this->p2pBot3 = new p2pBot( $basicbot3 );

        // trois fichiers images de tailles differentes pour les reconnaitres.
        $this->file_size1 = filesize( $this->fileDir . $this->file1 );
        $this->file_size2 = filesize( $this->fileDir . $this->file2 );
        $this->file_size3 = filesize( $this->fileDir . $this->file3 );
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
     * execute criss cross merge with attachment

    W1|W2
    1  2 - make change in 2 wiki
    |\/|
    |/\|
    3==4
    */
    public function testSimple1() {
        // create page
        $this->assertTrue( $this->p2pBot1->createPage( $this->pageName, $this->content ),
                'Failed to create page ' . $this->pageName . ' (' . $this->p2pBot1->bot->results . ')' );

        // assert page Ours exist on wiki1
        assertPageExist( $this->p2pBot1->bot->wikiServer, $this->pageName );

        // upload the file on wiki1
        $this->assertTrue( $this->p2pBot1->uploadFile( $this->fileDir . $this->file1, $this->file, '0' ) );

        // test if the file was upload on the push
        $this->assertTrue( $this->p2pBot1->getFileFeatures( $this->file, $this->file_size1 ) );
        assertPageExist( $this->p2pBot1->bot->wikiServer, $this->filePage );

        $PatchonWiki1 = getSemanticRequest( $this->p2pBot1->bot->wikiServer, '[[Patch:+]][[onPage::' . $this->filePage . ']]', '-3FpatchID' );
        $PatchonWiki1 = arraytolower( $PatchonWiki1 );
        $this->assertEquals( count( $PatchonWiki1 ), 1 );

        // edit File:Ours.jpg on wiki1
        $this->assertTrue( $this->p2pBot1->editPage( $this->filePage, $this->pushRequest ),
            'failed to edit page ' . $this->filePage . ' ( ' . $this->p2pBot1->bot->results . ' )' );

        $PatchonWiki1 = getSemanticRequest( $this->p2pBot1->bot->wikiServer, '[[Patch:+]][[onPage::' . $this->filePage . ']]', '-3FpatchID' );
        $PatchonWiki1 = arraytolower( $PatchonWiki1 );
        $this->assertEquals( count( $PatchonWiki1 ), 2 );

        // create push on wiki1
        $this->assertTrue( $this->p2pBot1->createPush( $this->pushName, $this->pushRequest ),
                'Failed to create push : ' . $this->pushName . ' (' . $this->p2pBot1->bot->results . ')' );

        // push
        $this->assertTrue( $this->p2pBot1->push( $this->pushFeed ),
                'failed to push ' . $this->pushFeed . ' (' . $this->p2pBot2->bot->results . ')' );



        // create page
        $this->assertTrue( $this->p2pBot2->createPage( $this->pageName, $this->content ),
                'Failed to create page ' . $this->pageName . ' (' . $this->p2pBot2->bot->results . ')' );

        // assert page Ours exist on wiki2
        assertPageExist( $this->p2pBot2->bot->wikiServer, $this->pageName );

        // upload the file on wiki2
        $this->assertTrue( $this->p2pBot2->uploadFile( $this->fileDir . $this->file2, $this->file, '0' ) );

        // test if the file was upload on the push
        $this->assertTrue( $this->p2pBot2->getFileFeatures( $this->file, $this->file_size2 ) );
        assertPageExist( $this->p2pBot2->bot->wikiServer, $this->filePage );

        $PatchonWiki1 = getSemanticRequest( $this->p2pBot2->bot->wikiServer, '[[Patch:+]][[onPage::' . $this->filePage . ']]', '-3FpatchID' );
        $PatchonWiki1 = arraytolower( $PatchonWiki1 );
        $this->assertEquals( count( $PatchonWiki1 ), 1 );

        // edit File:Ours.jpg on wiki2
        $this->assertTrue( $this->p2pBot2->editPage( $this->filePage, $this->pushRequest ),
            'failed to edit page ' . $this->filePage . ' ( ' . $this->p2pBot2->bot->results . ' )' );

        $PatchonWiki1 = getSemanticRequest( $this->p2pBot2->bot->wikiServer, '[[Patch:+]][[onPage::' . $this->filePage . ']]', '-3FpatchID' );
        $PatchonWiki1 = arraytolower( $PatchonWiki1 );
        $this->assertEquals( count( $PatchonWiki1 ), 2 );

        // create push on wiki2
        $this->assertTrue( $this->p2pBot2->createPush( $this->pushName, $this->pushRequest ),
                'Failed to create push : ' . $this->pushName . ' (' . $this->p2pBot2->bot->results . ')' );

        // push
        $this->assertTrue( $this->p2pBot2->push( $this->pushFeed ),
                'failed to push ' . $this->pushFeed . ' (' . $this->p2pBot2->bot->results . ')' );



        // create pull on wiki2
        $this->assertTrue( $this->p2pBot2->createPull( $this->pullName, $this->wiki1, $this->pushName ),
                'failed to create pull ' . $this->pullName . ' (' . $this->p2pBot2->bot->results . ')' );

        // pull
        $this->assertTrue( $this->p2pBot2->pull( $this->pullFeed ),
                'failed to pull ' . $this->pullFeed . ' (' . $this->p2pBot2->bot->results . ')' );

        // assert page Ours exist on wiki2
        assertPageExist( $this->p2pBot2->bot->wikiServer, $this->pageName );

        // test if the good file was upload on wiki2
        $this->assertTrue( $this->p2pBot2->getFileFeatures( $this->file, $this->file_size2 ) );
        assertPageExist( $this->p2pBot2->bot->wikiServer, $this->filePage );


        // create pull on wiki1
        $this->assertTrue( $this->p2pBot1->createPull( $this->pullName, $this->wiki2, $this->pushName ),
                'failed to create pull ' . $this->pullName . ' (' . $this->p2pBot1->bot->results . ')' );

        // pull
        $this->assertTrue( $this->p2pBot1->pull( $this->pullFeed ),
                'failed to pull ' . $this->pullFeed . ' (' . $this->p2pBot1->bot->results . ')' );

        // assert page Ours exist on wiki1
        assertPageExist( $this->p2pBot1->bot->wikiServer, $this->pageName );

        // test if the good file was upload on wiki1
        $this->assertTrue( $this->p2pBot1->getFileFeatures( $this->file, $this->file_size2 ) );
        assertPageExist( $this->p2pBot1->bot->wikiServer, $this->filePage );




        // assert that there is the same changeSet on the 2 wikis
        $CSonWiki1 = getSemanticRequest( $this->p2pBot1->bot->wikiServer, '[[ChangeSet:+]][[inPushFeed::' . $this->pushFeed . ']]', '-3FchangeSetID' );
        $CSonWiki2 = getSemanticRequest( $this->p2pBot2->bot->wikiServer, '[[ChangeSet:+]][[inPullFeed::' . $this->pullFeed . ']]', '-3FchangeSetID' );
        $this->assertEquals( $CSonWiki1, $CSonWiki2, 'changeSet are not equals on the 2 wikis' );

        // assert that there is the same patch on the 2 wikis
        $PatchonWiki1 = getSemanticRequest( $this->p2pBot1->bot->wikiServer, '[[Patch:+]][[onPage::' . $this->filePage . ']]', '-3FpatchID' );
        $PatchonWiki2 = getSemanticRequest( $this->p2pBot2->bot->wikiServer, '[[Patch:+]][[onPage::' . $this->filePage . ']]', '-3FpatchID' );
        $PatchonWiki1 = arraytolower( $PatchonWiki1 );
        $PatchonWiki2 = arraytolower( $PatchonWiki2 );
        $this->assertEquals( $PatchonWiki1, $PatchonWiki2, 'patch are not equals on the 2 wikis' );

        // assert that wiki1/File:Ours == wiki2/File:Ours
        assertContentEquals( $this->p2pBot1->bot->wikiServer, $this->p2pBot2->bot->wikiServer, $this->filePage );
    }

    /**
     * execute criss cross merge bis

    W1|W2
    1
    |\
    | \
    3  2 - make change in 2 wiki with attachment
    |\/|
    |/\|
    4==5
    */
    public function testSimple2() {
        // 1
        // create page
        $this->assertTrue( $this->p2pBot1->createPage( $this->pageName, $this->content ),
                'Failed to create page ' . $this->pageName . ' (' . $this->p2pBot1->bot->results . ')' );

        // assert page Ours exist on wiki1
        assertPageExist( $this->p2pBot1->bot->wikiServer, $this->pageName );

        // upload the file on wiki1
        $this->assertTrue( $this->p2pBot1->uploadFile( $this->fileDir . $this->file1, $this->file, '0' ) );

        // test if the file was upload
        $this->assertTrue( $this->p2pBot1->getFileFeatures( $this->file, $this->file_size1 ) );
        assertPageExist( $this->p2pBot1->bot->wikiServer, $this->filePage );

        $PatchonWiki1 = getSemanticRequest( $this->p2pBot1->bot->wikiServer, '[[Patch:+]][[onPage::' . $this->filePage . ']]', '-3FpatchID' );
        $PatchonWiki1 = arraytolower( $PatchonWiki1 );
        $this->assertEquals( count( $PatchonWiki1 ), 1 );

        // edit File:Ours.jpg on wiki1
        $this->assertTrue( $this->p2pBot1->editPage( $this->filePage, $this->pushRequest ),
            'failed to edit page ' . $this->filePage . ' ( ' . $this->p2pBot1->bot->results . ' )' );

        $PatchonWiki1 = getSemanticRequest( $this->p2pBot1->bot->wikiServer, '[[Patch:+]][[onPage::' . $this->filePage . ']]', '-3FpatchID' );
        $PatchonWiki1 = arraytolower( $PatchonWiki1 );
        $this->assertEquals( count( $PatchonWiki1 ), 2 );

        // create push on wiki1
        $this->assertTrue( $this->p2pBot1->createPush( $this->pushName, $this->pushRequest ),
                'Failed to create push : ' . $this->pushName . ' (' . $this->p2pBot1->bot->results . ')' );

        // push
        $this->assertTrue( $this->p2pBot1->push( $this->pushFeed ),
                'failed to push ' . $this->pushFeed . ' (' . $this->p2pBot1->bot->results . ')' );



        // 2
        // create pull on wiki2
        $this->assertTrue( $this->p2pBot2->createPull( $this->pullName, $this->wiki1, $this->pushName ),
                'failed to create pull ' . $this->pullName . ' (' . $this->p2pBot2->bot->results . ')' );

        // pull
        $this->assertTrue( $this->p2pBot2->pull( $this->pullFeed ),
                'failed to pull ' . $this->pullFeed . ' (' . $this->p2pBot2->bot->results . ')' );

        // test if the good file was upload on wiki2
        $this->assertTrue( $this->p2pBot2->getFileFeatures( $this->file, $this->file_size1 ) );
        assertPageExist( $this->p2pBot2->bot->wikiServer, $this->filePage );

        $PatchonWiki1 = getSemanticRequest( $this->p2pBot2->bot->wikiServer, '[[Patch:+]][[onPage::' . $this->filePage . ']]', '-3FpatchID' );
        $PatchonWiki1 = arraytolower( $PatchonWiki1 );
        $this->assertEquals( count( $PatchonWiki1 ), 2 );

        // edit File:Ours.jpg on wiki2
        $this->assertTrue( $this->p2pBot2->editPage( $this->filePage, $this->pushRequest ),
            'failed to edit page ' . $this->filePage . ' ( ' . $this->p2pBot2->bot->results . ' )' );

        // upload the file on wiki2
        $this->assertTrue( $this->p2pBot2->uploadFile( $this->fileDir . $this->file2, $this->file, '0' ) );

        // test if the file was upload
        $this->assertTrue( $this->p2pBot2->getFileFeatures( $this->file, $this->file_size2 ) );

       // create push on wiki2
        $this->assertTrue( $this->p2pBot2->createPush( $this->pushName, $this->pushRequest ),
                'Failed to create push : ' . $this->pushName . ' (' . $this->p2pBot2->bot->results . ')' );

        // push
        $this->assertTrue( $this->p2pBot2->push( $this->pushFeed ),
                'failed to push ' . $this->pushFeed . ' (' . $this->p2pBot2->bot->results . ')' );



        // 3
        // edit File:Ours.jpg on wiki1
        $this->assertTrue( $this->p2pBot1->editPage( $this->filePage, $this->pushRequest ),
            'failed to edit page ' . $this->filePage . ' ( ' . $this->p2pBot1->bot->results . ' )' );

        // push
        $this->assertTrue( $this->p2pBot1->push( $this->pushFeed ),
                'failed to push ' . $this->pushFeed . ' (' . $this->p2pBot1->bot->results . ')' );


        // 4
        // create pull on wiki1
        $this->assertTrue( $this->p2pBot1->createPull( $this->pullName, $this->wiki2, $this->pushName ),
                'failed to create pull ' . $this->pullName . ' (' . $this->p2pBot1->bot->results . ')' );

        // pull
        $this->assertTrue( $this->p2pBot1->pull( $this->pullFeed ),
                'failed to pull ' . $this->pullFeed . ' (' . $this->p2pBot1->bot->results . ')' );

        // test if the good file was upload on wiki1
        $this->assertTrue( $this->p2pBot1->getFileFeatures( $this->file, $this->file_size2 ) );
        assertPageExist( $this->p2pBot1->bot->wikiServer, $this->filePage );



        // 5
        // create pull on wiki2
        // $this->assertTrue($this->p2pBot2->createPull($this->pullName,$this->wiki1, $this->pushName),
         //       'failed to create pull '.$this->pullName.' ('.$this->p2pBot2->bot->results.')');

        // pull
        $this->assertTrue( $this->p2pBot2->pull( $this->pullFeed ),
                'failed to pull ' . $this->pullFeed . ' (' . $this->p2pBot2->bot->results . ')' );




        // assert that there is the same patch on the 2 wikis
        $PatchonWiki1 = getSemanticRequest( $this->p2pBot1->bot->wikiServer, '[[Patch:+]][[onPage::' . $this->filePage . ']]', '-3FpatchID' );
        $PatchonWiki2 = getSemanticRequest( $this->p2pBot2->bot->wikiServer, '[[Patch:+]][[onPage::' . $this->filePage . ']]', '-3FpatchID' );
        $PatchonWiki1 = arraytolower( $PatchonWiki1 );
        $PatchonWiki2 = arraytolower( $PatchonWiki2 );
        $this->assertEquals( $PatchonWiki1, $PatchonWiki2, 'patch are not equals on the 2 wikis' );

        // assert that wiki1/File:Ours == wiki2/File:Ours
        assertContentEquals( $this->p2pBot1->bot->wikiServer, $this->p2pBot2->bot->wikiServer, $this->filePage );
    }


    /**
     * execute criss cross merge

    W1|W2
    1  2 - make change in 2 wiki
    |\/|
    |/\|
    3==4
    */
   public function testSimple3() {
        // create page
        $this->assertTrue( $this->p2pBot1->createPage( $this->pageName, $this->content ),
                'Failed to create page ' . $this->pageName . ' (' . $this->p2pBot1->bot->results . ')' );

        // assert page Ours exist on wiki1
        assertPageExist( $this->p2pBot1->bot->wikiServer, $this->pageName );

        // create push on wiki1
        $this->assertTrue( $this->p2pBot1->createPush( $this->pushName, $this->pushRequest ),
                'Failed to create push : ' . $this->pushName . ' (' . $this->p2pBot1->bot->results . ')' );

        // push
        $this->assertTrue( $this->p2pBot1->push( $this->pushFeed ),
                'failed to push ' . $this->pushFeed . ' (' . $this->p2pBot2->bot->results . ')' );



        // create page
        $this->assertTrue( $this->p2pBot2->createPage( $this->pageName, $this->content ),
                'Failed to create page ' . $this->pageName . ' (' . $this->p2pBot2->bot->results . ')' );

        // assert page Ours exist on wiki2
        assertPageExist( $this->p2pBot2->bot->wikiServer, $this->pageName );



        // create push on wiki2
        $this->assertTrue( $this->p2pBot2->createPush( $this->pushName, $this->pushRequest ),
                'Failed to create push : ' . $this->pushName . ' (' . $this->p2pBot2->bot->results . ')' );

        // push
        $this->assertTrue( $this->p2pBot2->push( $this->pushFeed ),
                'failed to push ' . $this->pushFeed . ' (' . $this->p2pBot2->bot->results . ')' );



        // create pull on wiki2
        $this->assertTrue( $this->p2pBot2->createPull( $this->pullName, $this->wiki1, $this->pushName ),
                'failed to create pull ' . $this->pullName . ' (' . $this->p2pBot2->bot->results . ')' );

        // pull
        $this->assertTrue( $this->p2pBot2->pull( $this->pullFeed ),
                'failed to pull ' . $this->pullFeed . ' (' . $this->p2pBot2->bot->results . ')' );




        // create pull on wiki1
        $this->assertTrue( $this->p2pBot1->createPull( $this->pullName, $this->wiki2, $this->pushName ),
                'failed to create pull ' . $this->pullName . ' (' . $this->p2pBot1->bot->results . ')' );

        // pull
        $this->assertTrue( $this->p2pBot1->pull( $this->pullFeed ),
                'failed to pull ' . $this->pullFeed . ' (' . $this->p2pBot1->bot->results . ')' );




        // assert that there is the same changeSet on the 2 wikis
        $CSonWiki1 = getSemanticRequest( $this->p2pBot1->bot->wikiServer, '[[ChangeSet:+]][[inPushFeed::' . $this->pushFeed . ']]', '-3FchangeSetID' );
        $CSonWiki2 = getSemanticRequest( $this->p2pBot2->bot->wikiServer, '[[ChangeSet:+]][[inPullFeed::' . $this->pullFeed . ']]', '-3FchangeSetID' );
        $this->assertEquals( $CSonWiki1, $CSonWiki2, 'changeSet are not equals on the 2 wikis' );

        // assert that there is the same patch on the 2 wikis
        $PatchonWiki1 = getSemanticRequest( $this->p2pBot1->bot->wikiServer, '[[Patch:+]][[onPage::' . $this->pageName . ']]', '-3FpatchID' );
        $PatchonWiki2 = getSemanticRequest( $this->p2pBot2->bot->wikiServer, '[[Patch:+]][[onPage::' . $this->pageName . ']]', '-3FpatchID' );
        $PatchonWiki1 = arraytolower( $PatchonWiki1 );
        $PatchonWiki2 = arraytolower( $PatchonWiki2 );
        $this->assertEquals( $PatchonWiki1, $PatchonWiki2, 'patch are not equals on the 2 wikis' );

        // assert that wiki1/File:Ours == wiki2/File:Ours
        assertContentEquals( $this->p2pBot1->bot->wikiServer, $this->p2pBot2->bot->wikiServer, $this->pageName );
    }

    function viderRepertoire() {
    }
}

?>
