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
 * p2pTest4 tests the same features than p2pTest1 except that the pagename has
 * a namespace added
 *
 * @author jean-philippe muller
 * @copyright INRIA-LORIA-ECOO project
 */
class p2pTest4 extends PHPUnit_Framework_TestCase {

    var $p2pBot1;
    var $p2pBot2;
    var $p2pBot3;
    var $wiki1 = WIKI1;
    var $wiki2 = WIKI2;
    var $wiki3 = WIKI3;

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

    /**
     * create one page, push it on wiki10 and pull it on wiki11
     */
    public function testSimple1() {
        $pageName = "Category:Lambach";
        $content = 'content page Lambach';
        $this->assertTrue( $this->p2pBot1->createPage( $pageName, $content ),
            'Failed to create page ' . $pageName . ' (' . $this->p2pBot1->bot->results . ')' );

        // create push on wiki1
        $pushName = 'PushCity10';
        $pushRequest = '[[category:Lambach]]';
        $this->assertTrue( $this->p2pBot1->createPush( $pushName, $pushRequest ),
            'Failed to create push : ' . $pushName . ' (' . $this->p2pBot1->bot->results . ')' );

        // push on wiki1
        $this->assertTrue( $this->p2pBot1->push( 'PushFeed:' . $pushName ),
            'failed to push ' . $pushName . ' (' . $this->p2pBot2->bot->results . ')' );

        // create pull on wiki2
        $pullName = 'PullCity';
        $this->assertTrue( $this->p2pBot2->createPull( $pullName, $this->wiki1, $pushName ),
            'failed to create pull ' . $pullName . ' (' . $this->p2pBot2->bot->results . ')' );

        // pull
        $this->assertTrue( $this->p2pBot2->Pull( 'PullFeed:' . $pullName ),
            'failed to pull ' . $pullName . ' (' . $this->p2pBot2->bot->results . ')' );

        // assert page Lambach exist
        assertPageExist( $this->p2pBot1->bot->wikiServer, $pageName );

        // assert that there is the same changeSet on the 2 wikis
        $CSonWiki1 = getSemanticRequest( $this->p2pBot1->bot->wikiServer, '[[ChangeSet:+]]', '-3FchangeSetID' );
        $CSonWiki2 = getSemanticRequest( $this->p2pBot2->bot->wikiServer, '[[ChangeSet:+]]', '-3FchangeSetID' );
        $this->assertEquals( $CSonWiki1, $CSonWiki2, 'changeSet are not equals on the 2 wikis' );

        // assert that there is the same patch on the 2 wikis
        $PatchonWiki1 = getSemanticRequest( $this->p2pBot1->bot->wikiServer, '[[Patch:+]]', '-3FpatchID' );
        $PatchonWiki2 = getSemanticRequest( $this->p2pBot2->bot->wikiServer, '[[Patch:+]]', '-3FpatchID' );
        $PatchonWiki1 = arraytolower( $PatchonWiki1 );
        $PatchonWiki2 = arraytolower( $PatchonWiki2 );
        $this->assertEquals( $PatchonWiki1, $PatchonWiki2, 'patch are not equals on the 2 wikis' );

        // assert that wiki1/paris == wiki2/paris
        assertContentEquals( $this->p2pBot1->bot->wikiServer, $this->p2pBot2->bot->wikiServer, 'Category:Lambach' );
    }

    /**
     * create a page push it on wiki1, edit it on wiki1, push it again
     * and pull it on wiki2
     * wiki2 must receive 2 changeSet
     */
    function testSimple2() {
        $pageName = "Category:Lambach";
        $content = 'content page Lambach';
        $this->assertTrue( $this->p2pBot1->createPage( $pageName, $content ),
            'Failed to create page ' . $pageName . ' (' . $this->p2pBot1->bot->results . ')' );

//        $this->assertTrue($this->p2pBot1->createPage($pageName,$content),
//            'Failed to create page '.$pageName.' ('.$this->p2pBot1->bot->results.')');

        // create push on wiki10
        $pushName = 'PushCity10';
        $pushRequest = '[[category:Lambach]]';

        $this->assertTrue( $this->p2pBot1->createPush( $pushName, $pushRequest ),
            'Failed to create push : ' . $pushName . ' (' . $this->p2pBot1->bot->results . ')' );

        // push on wiki10
        $this->assertTrue( $this->p2pBot1->push( 'PushFeed:' . $pushName ),
            'failed to push ' . $pushName . ' (' . $this->p2pBot2->bot->results . ')' );

        // edit on wiki10
        $this->assertTrue( $this->p2pBot1->editPage( $pageName, 'create the second changeSet' ),
            'failed to edit page ' . $pageName . ' ( ' . $this->p2pBot1->bot->results . ' )' );

        // push on wiki10
        $this->assertTrue( $this->p2pBot1->push( 'PushFeed:' . $pushName ),
            'failed to push ' . $pushName . ' (' . $this->p2pBot2->bot->results . ')' );

        // create pull on wiki11
        $pullName = 'PullCity';
        $this->assertTrue( $this->p2pBot2->createPull( $pullName, $this->wiki1, $pushName ),
            'failed to create pull ' . $pullName . ' (' . $this->p2pBot2->bot->results . ')' );

        // pull
        $this->assertTrue( $this->p2pBot2->Pull( 'PullFeed:' . $pullName ),
            'failed to pull ' . $pullName . ' (' . $this->p2pBot2->bot->results . ')' );
        // assert page paris exist
        assertPageExist( $this->p2pBot1->bot->wikiServer, $pageName );

        // assert that there is the same changeSet on the 2 wikis
        $CSonWiki1 = getSemanticRequest( $this->p2pBot1->bot->wikiServer, '[[ChangeSet:+]]', '-3FchangeSetID' );
        $CSonWiki2 = getSemanticRequest( $this->p2pBot2->bot->wikiServer, '[[ChangeSet:+]]', '-3FchangeSetID' );
        $this->assertEquals( $CSonWiki1, $CSonWiki2, 'changeSet are not equals on the 2 wikis' );

        // assert that there is the same patch on the 2 wikis
        $PatchonWiki1 = getSemanticRequest( $this->p2pBot1->bot->wikiServer, '[[Patch:+]]', '-3FpatchID' );
        $PatchonWiki2 = getSemanticRequest( $this->p2pBot2->bot->wikiServer, '[[Patch:+]]', '-3FpatchID' );
        $PatchonWiki1 = arraytolower( $PatchonWiki1 );
        $PatchonWiki2 = arraytolower( $PatchonWiki2 );
        $this->assertEquals( $PatchonWiki1, $PatchonWiki2, 'patch are not equals on the 2 wikis' );
        // assert that wiki1/paris == wiki2/paris
        assertContentEquals( $this->p2pBot1->bot->wikiServer, $this->p2pBot2->bot->wikiServer, 'Category:Lambach' );
    }

    /*
     * continue the testSimple1 by pushing the same page on wiki2 and pulling it on wiki1
     */
    function testSimple3() {
        $this->testSimple1();

        $countCSonWiki1 = count( getSemanticRequest( $this->p2pBot1->bot->wikiServer, '[[Patch:+]]', '-3FpatchID' ) );

        // create push on wiki2
        $pushName = 'PushCity10';
        $pushRequest = '[[category:Lambach]]';
        $this->assertTrue( $this->p2pBot2->createPush( $pushName, $pushRequest ),
            'Failed to create push : ' . $pushName . ' (' . $this->p2pBot2->bot->results . ')' );

        $this->assertTrue( $this->p2pBot2->push( 'PushFeed:' . $pushName ),
            'failed to push ' . $pushName . ' (' . $this->p2pBot2->bot->results . ')' );

        // assert that wiki1/Category:Lambach == wiki2/Category:Lambach
        assertContentEquals( $this->p2pBot1->bot->wikiServer, $this->p2pBot2->bot->wikiServer, 'Category:Lambach' );

        // create pull on wiki1
        $pullName = 'pullCity';
        $this->assertTrue( $this->p2pBot1->createPull( $pullName, $this->wiki2, $pushName ),
            'failed to create pull ' . $pullName . ' (' . $this->p2pBot1->bot->results . ')' );

        // pull
        $this->assertTrue( $this->p2pBot1->Pull( 'PullFeed:' . $pullName ),
            'failed to pull ' . $pullName . ' (' . $this->p2pBot1->bot->results . ')' );

        $countCS = count( getSemanticRequest( $this->p2pBot1->bot->wikiServer, '[[Patch:+]]', '-3FpatchID' ) );
        // assert no patch created on wiki1
        $this->assertTrue( $countCSonWiki1 == $countCS );

        // assert that wiki1/Category:Lambach == wiki2/Category:Lambach
        $contentWiki1 = getContentPage( $this->p2pBot1->bot->wikiServer, 'Category:Lambach' );
        $contentWiki2 = getContentPage( $this->p2pBot2->bot->wikiServer, 'Category:Lambach' );
        assertPageExist( $this->p2pBot2->bot->wikiServer, 'Category:Lambach' );
        $this->assertEquals( $contentWiki1, $contentWiki2,
            'Failed content page Lambach' );

        // assert that there is the same patch on the 2 wikis
        $PatchonWiki1 = getSemanticRequest( $this->p2pBot1->bot->wikiServer, '[[Patch:+]]', '-3FpatchID' );
        $PatchonWiki2 = getSemanticRequest( $this->p2pBot2->bot->wikiServer, '[[Patch:+]]', '-3FpatchID' );
        $PatchonWiki1 = arraytolower( $PatchonWiki1 );
        $PatchonWiki2 = arraytolower( $PatchonWiki2 );
        $this->assertEquals( $PatchonWiki1, $PatchonWiki2 );

        // assert that there is the same changeSet on the 2 wikis
        $CSonWiki1 = getSemanticRequest( $this->p2pBot1->bot->wikiServer, '[[ChangeSet:+]]', '-3FchangeSetID' );
        $CSonWiki2 = getSemanticRequest( $this->p2pBot2->bot->wikiServer, '[[ChangeSet:+]]', '-3FchangeSetID' );
        $this->assertEquals( $CSonWiki1, $CSonWiki2 );
    }

    /*
     * continue the testSimple3 by pushing again on wiki1 and pulling again on wiki2
     */
    function testSimple4() {
        $this->testSimple2();

        $countCSonWiki1 = count( getSemanticRequest( $this->p2pBot1->bot->wikiServer, '[[Patch:+]]', '-3FpatchID' ) );
        $countCSonWiki2 = count( getSemanticRequest( $this->p2pBot2->bot->wikiServer, '[[Patch:+]]', '-3FpatchID' ) );

        $pushName = 'PushCity10';
        $pullName = 'pullCity';
        $this->assertTrue( $this->p2pBot1->push( 'PushFeed:' . $pushName ),
            'failed to push ' . $pushName . ' (' . $this->p2pBot1->bot->results . ')' );

        $this->assertTrue( $this->p2pBot2->Pull( 'PullFeed:' . $pullName ),
            'failed to pull ' . $pullName . ' (' . $this->p2pBot2->bot->results . ')' );

        $countCS = count( getSemanticRequest( $this->p2pBot2->bot->wikiServer, '[[Patch:+]]', '-3FpatchID' ) );
        // assert no patch created
        $this->assertTrue( $countCSonWiki2 == $countCS );

        // assert that wiki1/Category:Lambach == wiki2/Category:Lambach
        $contentWiki1 = getContentPage( $this->p2pBot1->bot->wikiServer, 'Category:Lambach' );
        $contentWiki2 = getContentPage( $this->p2pBot2->bot->wikiServer, 'Category:Lambach' );
        assertPageExist( $this->p2pBot2->bot->wikiServer, 'Category:Lambach' );
        $this->assertEquals( $contentWiki1, $contentWiki2,
            'Failed content page Lambach' );

        // assert that there is the same changeSet on the 2 wikis
        $CSonWiki1 = count( getSemanticRequest( $this->p2pBot1->bot->wikiServer, '[[ChangeSet:+]]', '-3FchangeSetID' ) );
        $CSonWiki2 = count( getSemanticRequest( $this->p2pBot2->bot->wikiServer, '[[ChangeSet:+]]', '-3FchangeSetID' ) );
        $this->assertEquals( $CSonWiki1, $CSonWiki2 );

        // assert that there is the same patch on the 2 wikis
        $PatchonWiki1 = count( getSemanticRequest( $this->p2pBot1->bot->wikiServer, '[[Patch:+]]', '-3FpatchID' ) );
        $PatchonWiki2 = count( getSemanticRequest( $this->p2pBot2->bot->wikiServer, '[[Patch:+]]', '-3FpatchID' ) );
        $this->assertEquals( $PatchonWiki1, $PatchonWiki2 );
    }
}
?>
