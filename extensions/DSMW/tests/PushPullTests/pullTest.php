<?php

if ( !defined( 'MEDIAWIKI' ) ) { define( 'MEDIAWIKI', true ); }
require_once '../p2pBot.php';
require_once '../BasicBot.php';
require_once '../../../../includes/GlobalFunctions.php';
require_once '../../patch/Patch.php';
require_once '../../files/utils.php';
include_once '../p2pAssert.php';
require_once '../settings.php';

/**
 * Description of pullTest
 *
 * @author hantz
 */
class pullTest extends PHPUnit_Framework_TestCase {

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
        $this->p2pBot1->bot->wikiConnect();
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

    public function testCreatePull() {
        $pullName = 'pullCity';
        $this->assertTrue( $this->p2pBot2->createPull( $pullName, $this->wiki1, 'pushCity' ),
            'failed to create pull pullCity (' . $this->p2pBot2->bot->results . ')' );
        assertPageExist( $this->p2pBot2->bot->wikiServer, 'PullFeed:' . $pullName );

        $pullFound = getSemanticRequest( $this->p2pBot2->bot->wikiServer, '[[name::PullFeed:' . $pullName . ']]'
            , '-3FhasPullHead/-3FpushFeedServer/-3FpushFeedName' );

        $this->assertEquals( '', $pullFound[0],
            'failed to create pull pullCity, pullHead must be null but ' . $pullFound[0] . ' was found' );
        $this->assertEquals( $this->wiki1, strtolower( $pullFound[1] ),
            'failed to create pull pullCity, pushFeedServer must be ' . $this->wiki1 . ' but ' . strtolower( $pullFound[1] ) . ' was found' );
        $this->assertEquals( 'pushfeed:pushcity', strtolower( $pullFound[2] ),
            'failed to create pull pullCity, pushFeedName must be PushFeed:PushCity but ' . $pullFound[2] . ' was found' );
    }

    public function testPull() {
    // create pushFeed on wiki1
        $pushName = 'pushCity';
        $pushContent = 'PushFeed:
[[name::pushCity]]
[[hasSemanticQuery::-5B-5BCategory:city-5D-5D]]
[[hasPushHead::ChangeSet:testCS1Pull]]';
        $this->assertTrue( $this->p2pBot1->createPage( 'PushFeed:' . $pushName, $pushContent ),
            'failed on create page pushCity (' . $this->p2pBot1->bot->results . ')' );

        $CSName = 'testCS1Pull';
        $CSContent = '[[changeSetID::TestCS1Pull]]
[[inPushFeed::PushFeed:pushCity]]
[[previousChangeSet::none]]
[[hasPatch::Patch:testpatch1]]';
        $this->assertTrue( $this->p2pBot1->createPage( 'ChangeSet:' . $CSName, $CSContent ),
            'failed on create page testCS1Pull (' . $this->p2pBot1->bot->results . ')' );

        $patchName = 'Testpatch1';
        $patchContent = 'Patch: patchID: [[patchID::Patch:Testpatch1]]
 onPage: [[onPage::Pouxeux]]  hasOperation: [[hasOperation::op;test;(55:5ed);test]] previous: [[previous::none]] [[siteID::id1]]';
        $this->assertTrue( $this->p2pBot1->createPage( 'Patch:' . $patchName, $patchContent ),
            'failed on create page testPatch1 (' . $this->p2pBot1->bot->results . ')' );

        // create pull on wiki2
        $pullName = 'pullCityonWiki1';
        $pullContent = '[[name::PullFeed:pullCityonWiki1]]
[[pushFeedServer::' . $this->wiki1 . ']]
[[pushFeedName::PushFeed:' . $pushName . ']] [[hasPullHead::none]]';
        exec( 'rm ../cache/*' );
        $this->p2pBot2->bot->wikiConnected = false;
        $this->assertTrue( $this->p2pBot2->createPage( 'PullFeed:' . $pullName, $pullContent ),
            'failed on create pull (' . $this->p2pBot2->bot->results . ')' );

        // pull
        $this->assertTrue( $this->p2pBot2->pull( 'PullFeed:' . $pullName ), 'error on pull ' . $pullName . '(' . $this->p2pBot2->bot->results . ')' );

        assertPageExist( $this->p2pBot2->bot->wikiServer, 'ChangeSet:' . $CSName );
        assertPageExist( $this->p2pBot2->bot->wikiServer, 'Patch:' . $patchName );

        $pullHead = getSemanticRequest( $this->p2pBot2->bot->wikiServer, '[[name::PullFeed:' . $pullName . ']]', '-3FhasPullHead' );
        $this->assertEquals( strtolower( $CSName ), strtolower( $pullHead[0] ) );

        // pull without update
        $countCS = count( getSemanticRequest( $this->p2pBot1->bot->wikiServer, '[[ChangeSet:+]]', '-3FchangeSetID' ) );

        $this->assertTrue( $this->p2pBot2->pull( 'PullFeed:' . $pullName ), 'error on pull ' . $pullName . '(' . $this->p2pBot2->bot->results . ')' );

        $countCSAfter = count( getSemanticRequest( $this->p2pBot1->bot->wikiServer, '[[ChangeSet:+]]', '-3FchangeSetID' ) );
        $pullFound = getSemanticRequest( $this->p2pBot1->bot->wikiServer, '[[name::PullFeed:' . $pushName . ']]', '-3FhasPullHead' );
        $this->assertEquals( strtolower( $CSIDFound ), strtolower( substr( $pushFound[0], 0, -1 ) ),
            'failed to push ' . $pushName . ' pushHead must be ' . $CSIDFound . ' but ' . $pushFound[0] . ' was found' );

        $this->assertTrue( $countCS == $countCSAfter );
    }

    public function testMultiPull() {
        $pushName = 'PushCity11';
        $pushContent = 'PushFeed:
[[name::PushCity11]]
[[hasSemanticQuery::-5B-5BCategory:city-5D-5D]]
[[hasPushHead::ChangeSet:TestCS1Pull11]]';
        $this->assertTrue( $this->p2pBot1->createPage( 'PushFeed:' . $pushName, $pushContent ),
            'failed on create page pushCity (' . $this->p2pBot1->bot->results . ')' );

        $CSName = 'TestCS1Pull11';
        $CSContent = '[[changeSetID::TestCS1Pull11]]
[[inPushFeed::PushFeed:PushCity11]]
[[previousChangeSet::none]]
[[hasPatch::patch:Testpatch11]]';
        $this->assertTrue( $this->p2pBot1->createPage( 'ChangeSet:' . $CSName, $CSContent ),
            'failed on create page testCS1Pull (' . $this->p2pBot1->bot->results . ')' );

        $patchName = 'Testpatch11';
        $patchContent = 'Patch: patchID: [[patchID::Patch:Testpatch11]]
 onPage: [[onPage::Pouxeux]]  hasOperation: [[hasOperation::46c8a54b5793cea6e2de75cacbab89e31072;Insert;(31093912328563252139:0cd3731e772d2fe6bcdc48d53ce59543) ;Testline]] previous: [[previous::none]] [[siteID::id1]]';
        $this->assertTrue( $this->p2pBot1->createPage( 'Patch:' . $patchName, $patchContent ),
            'failed on create page testPatch1 (' . $this->p2pBot1->bot->results . ')' );

        $pushName = 'PushCity12';
        $pushContent = 'PushFeed:
[[name::PushCity12]]
[[hasSemanticQuery::-5B-5BCategory:city-5D-5D]]
[[hasPushHead::ChangeSet:TestCS1Pull12]]';
        $this->assertTrue( $this->p2pBot1->createPage( 'PushFeed:' . $pushName, $pushContent ),
            'failed on create page pushCity (' . $this->p2pBot1->bot->results . ')' );

        $CSName = 'TestCS1Pull12';
        $CSContent = '[[changeSetID::TestCS1Pull12]]
[[inPushFeed::PushFeed:pushCity12]]
[[previousChangeSet::none]]
[[hasPatch::Patch:Testpatch12]]';
        $this->assertTrue( $this->p2pBot1->createPage( 'ChangeSet:' . $CSName, $CSContent ),
            'failed on create page testCS1Pull (' . $this->p2pBot1->bot->results . ')' );

        $patchName = 'Testpatch12';
        $patchContent = 'Patch: patchID: [[patchID::Patch:Testpatch12]]
 onPage: [[onPage::Pouxeux]]  hasOperation: [[hasOperation::46c8a54b5793cea6e2de75cacbab89e31073;Insert;(21093912328563252139:0cd3731e772d2fe6bcdc48d53ce59543) ;testline]] previous: [[previous::none]] [[siteID::id1]]';
        $this->assertTrue( $this->p2pBot1->createPage( 'Patch:' . $patchName, $patchContent ),
            'failed on create page testPatch12 (' . $this->p2pBot1->bot->results . ')' );

        exec( 'rm ../cache/*' );
        $this->p2pBot2->bot->wikiConnected = false;

        $pullContent = '[[name::PullFeed:PullCityonWiki11]]
[[pushFeedServer::' . $this->wiki1 . ']]
[[pushFeedName::PushFeed:PushCity11]] [[hasPullHead::none]]';
        $this->assertTrue( $this->p2pBot2->createPage( 'PullFeed:pullCityonWiki11', $pullContent ),
            'failed on create pull (' . $this->p2pBot2->bot->results . ')' );

        $pullContent = '[[name::PullFeed:PullCityonWiki12]]
[[pushFeedServer::' . $this->wiki1 . ']]
[[pushFeedName::PushFeed:PushCity12]] [[hasPullHead::none]]';
        $this->assertTrue( $this->p2pBot2->createPage( 'PullFeed:pullCityonWiki12', $pullContent ),
            'failed on create pull (' . $this->p2pBot2->bot->results . ')' );

        // pull
        $array = array( 'PullFeed:PullCityonWiki11', 'PullFeed:PullCityonWiki12' );
        $this->assertTrue( $this->p2pBot2->pull( $array ), 'error on pull (' . $this->p2pBot2->bot->results . ')' );

        assertPageExist( $this->p2pBot2->bot->wikiServer, 'ChangeSet:TestCS1Pull11' );
        assertPageExist( $this->p2pBot2->bot->wikiServer, 'Patch:Testpatch11' );

        assertPageExist( $this->p2pBot2->bot->wikiServer, 'ChangeSet:TestCS1Pull12' );
        assertPageExist( $this->p2pBot2->bot->wikiServer, 'Patch:Testpatch12' );

    }
}
?>
