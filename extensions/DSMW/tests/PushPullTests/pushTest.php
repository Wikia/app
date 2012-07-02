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
 * Description of pushPullTest
 *
 * @author hantz
 */
class pushTest extends PHPUnit_Framework_TestCase {

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

    public function testPatch() {
    // test patch after creating page
        $pageName = "Pouxeux";
        $contentPage = 'content page Pouxeux
toto titi
[[Category:city]]';

        $this->assertTrue( $this->p2pBot1->createPage( $pageName, $contentPage ), 'Create page Pouxeux failed : ' . $this->p2pBot1->bot->results );

        $patch = getSemanticRequest( $this->p2pBot1->bot->wikiServer, '[[Patch:+]][[onPage::' . $pageName . ']]', '-3FpatchID' );

        // assert that one patch was created
        $this->assertTrue( count( $patch ) == 1 );

        // test patch after editing page
        $this->assertTrue( $this->p2pBot1->editPage( $pageName, 'toto' ),
            'failed to edit page ' . $pageName . ' : ' . $this->p2pBot1->bot->results );

        $patch = getSemanticRequest( $this->p2pBot1->bot->wikiServer, '[[Patch:+]][[onPage::' . $pageName . ']]', '-3FpatchID' );

        // assert that one patch was created
        $this->assertTrue( count( $patch ) == 2 );
    }

    public function testCreatePush() {
        $this->assertTrue( $this->p2pBot1->createPush( 'PushCity11', '[[Category:titi]]' ),
            'failed to create push PushCity : (' . $this->p2pBot1->bot->results . ')' );

        assertPageExist( $this->p2pBot1->bot->wikiServer, 'PushFeed:PushCity11' );

        // assert that patch contains is ok
        $pushFound = getSemanticRequest( $this->p2pBot1->bot->wikiServer, '[[name::PushFeed:PushCity11]]', '-3Fname/-3FhasSemanticQuery' );

        $this->assertEquals( 'PushFeed:PushCity11', $pushFound[0],
            'Create push PushCity error, push name must be PushFeed:PushCity but ' . $pushFound[0] . ' was found' );

        $this->assertEquals( utils::encodeRequest( '[[Category:titi]]' ), $pushFound[1],
            'Create push PushCity error, semantic request must be [[Category:city]] but ' .
            utils::decodeRequest( $pushFound[1] ) . ' was found' );
    }

    public function testPushWithNoChangeSet() {
    // create pushFeed
        $this->testCreatePush();

        $CS = getSemanticRequest( $this->p2pBot1->bot->wikiServer, '[[ChangeSet:+]]', '' );
        $res = count( $CS );
        // push without changeSet creationg
        $this->assertTrue( $this->p2pBot1->push( 'PushFeed:PushCity11' ),
            'failed to push PushCity : (' . $this->p2pBot1->bot->results . ')' );

        $CS = getSemanticRequest( $this->p2pBot1->bot->wikiServer, '[[ChangeSet:+]]', '' );
        $res1 = count( $CS );

        // assert that no changeSet was created
        $this->assertTrue( $res == $res1,
            'failed on push, no changeSet must be created but ' . $res1 -$res . ' changeSet were found' );

        // assert that pushHead attribute is always null
        $pushFound = getSemanticRequest( $this->p2pBot1->bot->wikiServer, '[[name::PushFeed:PushCity11]]', '-3FhasPushHead' );
        $this->assertEquals( '', substr( $pushFound[0], 0, -1 ),
            'push PushCity error, pushHead must be null but ' . $pushFound[0] . ' was found' );
    }

    public function testPushOrderPatchInChangeSet() {
        $this->p2pBot1->createPage( 'Patch:46B0DDA330CB057434586A52435CE43222', 'Patch: patchID: [[patchID::Patch:46B0DDA330CB057434586A52435CE43222]]
 onPage: [[onPage::Moldova]]  hasOperation:
[[hasOperation::46B0DDA330CB057434586A52435CE43223;Delete;(6394517056216502886:26a70380f78f203e27ed3db9322b2f78) ;JycnTW9sZG92YScnJyB7e0F1ZGlvLUlQQXxlbi11cy1Nb2xkb3ZhLm9nZ3wvbcmSbMuIZG/KinbJmS99fSwgb2ZmaWNpYWxseSB0aGUgJycnUmVwdWJsaWMgb2YgTW9sZG92YScnJyAoJydSZXB1YmxpY2EgTW9sZG92YScnKSBpcyBhIFtbbGFuZGxvY2tlZF1dIGNvdW50cnkgaW4gW1tsb2NhdGVkX2luOjpFdXJvcF1dLCBsb2NhdGVkIGJldHdlZW4gW1tSb21hbmlhXV0gdG8gdGhlIHdlc3QgYW5kIFtbVWtyYWluZV1dIHRvIHRoZSBub3J0aCwgZWFzdCBhbmQgc291dGgu]]
hasOperation: [[hasOperation::46B0DDA330CB057434586A52435CE43224;Insert;(587539302497374424:26a70380f78f203e27ed3db9322b2f78) ;JycnTW9sZG92YScnJywgb2ZmaWNpYWxseSB0aGUgJycnUmVwdWJsaWMgb2YgTW9sZG92YScnJyAoJydSZXB1YmxpY2EgTW9sZG92YScnKSBpcyBhIFtbbGFuZGxvY2tlZF1dIGNvdW50cnkgaW4gW1tsb2NhdGVkX2luOjpFdXJvcF1dLCBsb2NhdGVkIGJldHdlZW4gW1tSb21hbmlhXV0gdG8gdGhlIHdlc3QgYW5kIFtbVWtyYWluZV1dIHRvIHRoZSBub3J0aCwgZWFzdCBhbmQgc291dGgus]]
previous: [[previous::Patch:46B0DDA330CB057434586A52435CE4329]]' );

        $this->p2pBot1->createPage( 'Patch:46B0DDA330CB057434586A52435CE43225', 'Patch: patchID: [[patchID::Patch:46B0DDA330CB057434586A52435CE43225]]
 onPage: [[onPage::Moldova]]  hasOperation: [[hasOperation::46B0DDA330CB057434586A52435CE43226;Delete;(587539302497374424:26a70380f78f203e27ed3db9322b2f78) ;JycnTW9sZG92YScnJywgb2ZmaWNpYWxseSB0aGUgJycnUmVwdWJsaWMgb2YgTW9sZG92YScnJyAoJydSZXB1YmxpY2EgTW9sZG92YScnKSBpcyBhIFtbbGFuZGxvY2tlZF1dIGNvdW50cnkgaW4gW1tsb2NhdGVkX2luOjpFdXJvcF1dLCBsb2NhdGVkIGJldHdlZW4gW1tSb21hbmlhXV0gdG8gdGhlIHdlc3QgYW5kIFtbVWtyYWluZV1dIHRvIHRoZSBub3J0aCwgZWFzdCBhbmQgc291dGgu]]
hasOperation: [[hasOperation::46B0DDA330CB057434586A52435CE43227;Insert;(11542324226759575630:26a70380f78f203e27ed3db9322b2f78) ;JycnTW9sZG92YScnJywgb2ZmaWNpYWxseSB0aGUgJycnUmVwdWJsaWMgb2YgTW9sZG92YScnJyAoJydSZXB1YmxpY2EgTW9sZG92YScnKSBpcyBhIGxhbmRsb2NrZWQgY291bnRyeSBpbiBbW2xvY2F0ZWRfaW46OkV1cm9wXV0sIGxvY2F0ZWQgYmV0d2VlbiBbW1JvbWFuaWFdXSB0byB0aGUgd2VzdCBhbmQgW1tVa3JhaW5lXV0gdG8gdGhlIG5vcnRoLCBlYXN0IGFuZCBzb3V0aC4=]]
hasOperation: [[hasOperation::46B0DDA330CB057434586A52435CE43228;Delete;(29158425422724464787:26a70380f78f203e27ed3db9322b2f78) ;SW4gdGhlIFtbTWlkZGxlIEFnZXNdXSwgbW9zdCBvZiB0aGUgcHJlc2VudCB0ZXJyaXRvcnkgb2YgTW9sZG92YSB3YXMgcGFydCBvZiB0aGUgW1tQcmluY2lwYWxpdHkgb2YgTW9sZGF2aWFdXS4gSW4gMTgxMiwgaXQgd2FzIFtbQmVzc2FyYWJpYSBHb3Zlcm5vcmF0ZXxhbm5leGVkXV0gYnkgdGhlIFtbUnVzc2lhbiBFbXBpcmVdXSwgYW5kIGJlY2FtZSBrbm93biBhcyBbW0Jlc3NhcmFiaWFdXS4gQmV0d2VlbiAxODU2IGFuZCAxODc4LCB0aGUgc291dGhlcm4gcGFydCB3YXMgcmV0dXJuZWQgdG8gTW9sZGF2aWEuICBJbiAxODU5IGl0IHVuaXRlZCB3aXRoIFtbV2FsbGFjaGlhXV0gdG8gZm9ybSBtb2Rlcm4gUm9tYW5pYS4g]]
hasOperation: [[hasOperation::46B0DDA330CB057434586A52435CE43229;Insert;(19837381990834233306:26a70380f78f203e27ed3db9322b2f78) ;SW4gdGhlIE1pZGRsZSBBZ2VzLCBtb3N0IG9mIHRoZSBwcmVzZW50IHRlcnJpdG9yeSBvZiBNb2xkb3ZhIHdhcyBwYXJ0IG9mIHRoZSBbW1ByaW5jaXBhbGl0eSBvZiBNb2xkYXZpYV1dLiBJbiAxODEyLCBpdCB3YXMgQmVzc2FyYWJpYSBHb3Zlcm5vcmF0ZXxhbm5leGVkIGJ5IHRoZSBSdXNzaWFuIEVtcGlyZSwgYW5kIGJlY2FtZSBrbm93biBhcyBCZXNzYXJhYmlhLiBCZXR3ZWVuIDE4NTYgYW5kIDE4NzgsIHRoZSBzb3V0aGVybiBwYXJ0IHdhcyByZXR1cm5lZCB0byBNb2xkYXZpYS4gIEluIDE4NTkgaXQgdW5pdGVkIHdpdGggW1tXYWxsYWNoaWFdXSB0byBmb3JtIG1vZGVybiBSb21hbmlhLiA=]]
hasOperation: [[hasOperation::46B0DDA330CB057434586A52435CE43230;Delete;(78211748375579569933:26a70380f78f203e27ed3db9322b2f78) ;SW4gU2VwdGVtYmVyIDE5OTAsIGEgYnJlYWthd2F5IGdvdmVybm1lbnQgd2FzIGZvcm1lZCBpbiBbW1RyYW5zbmlzdHJpYV1dLCBhIHN0cmlwIG9mIE1vbGRhdmlhbiBTU1Igb24gdGhlIGVhc3QgYmFuayBvZiB0aGUgcml2ZXIgW1tEbmllc3Rlcl1dLiAgQWZ0ZXIgYSBicmllZiBbW1dhciBvZiBUcmFuc25pc3RyaWF8d2FyIGluIDE5OTJdXSwgaXQgYmVjYW1lICcnZGUgZmFjdG8nJyBpbmRlcGVuZGVudCwgYWx0aG91Z2ggbm8gVU4gbWVtYmVyIGhhcyByZWNvZ25pemVkIGl0cyBpbmRlcGVuZGVuY2Uu]]
hasOperation: [[hasOperation::46B0DDA330CB057434586A52435CE43231;Insert;(69195044814522978305:26a70380f78f203e27ed3db9322b2f78) ;SW4gU2VwdGVtYmVyIDE5OTAsIGEgYnJlYWthd2F5IGdvdmVybm1lbnQgd2FzIGZvcm1lZCBpbiBUcmFuc25pc3RyaWEsIGEgc3RyaXAgb2YgTW9sZGF2aWFuIFNTUiBvbiB0aGUgZWFzdCBiYW5rIG9mIHRoZSByaXZlciBEbmllc3Rlci4gIEFmdGVyIGEgYnJpZWYgV2FyIG9mIFRyYW5zbmlzdHJpYXx3YXIgaW4gMTk5MiwgaXQgYmVjYW1lICcnZGUgZmFjdG8nJyBpbmRlcGVuZGVudCwgYWx0aG91Z2ggbm8gVU4gbWVtYmVyIGhhcyByZWNvZ25pemVkIGl0cyBpbmRlcGVuZGVuY2Uu]]
hasOperation: [[hasOperation::46B0DDA330CB057434586A52435CE43232;Delete;(108558917756701573695:26a70380f78f203e27ed3db9322b2f78) ;VGhlIGNvdW50cnkgaXMgYSBbW3BhcmxpYW1lbnRhcnkgZGVtb2NyYWN5XV0gd2l0aCBhIFtbUHJlc2lkZW50IG9mIE1vbGRvdmF8cHJlc2lkZW50XV0gYXMgW1toZWFkIG9mIHN0YXRlXV0gYW5kIGEgW1tMaXN0IG9mIFByaW1lIE1pbmlzdGVycyBvZiBNb2xkb3ZhfHByaW1lIG1pbmlzdGVyXV0gYXMgW1toZWFkIG9mIGdvdmVybm1lbnRdXS4gTW9sZG92YSBpcyBhIG1lbWJlciBzdGF0ZSBvZiB0aGUgW1tVbml0ZWQgTmF0aW9uc11dLCBbW0NvdW5jaWwgb2YgRXVyb3BlXV0sIFtbV29ybGQgVHJhZGUgT3JnYW5pemF0aW9ufFdUT11dLCBbW09yZ2FuaXphdGlvbiBmb3IgU2VjdXJpdHkgYW5kIENvb3BlcmF0aW9uIGluIEV1cm9wZXxPU0NFXV0sIFtbR1VBTV1dLCBbW0NvbW1vbndlYWx0aCBvZiBJbmRlcGVuZGVudCBTdGF0ZXN8Q0lTXV0sIFtbT3JnYW5pemF0aW9uIG9mIHRoZSBCbGFjayBTZWEgRWNvbm9taWMgQ29vcGVyYXRpb258QlNFQ11dIGFuZCBvdGhlciBbW2ludGVybmF0aW9uYWwgb3JnYW5pemF0aW9uXV1zLiBNb2xkb3ZhIGN1cnJlbnRseSBhc3BpcmVzIHRvIGpvaW4gdGhlIFtbRXVyb3BlYW4gVW5pb25dXSw8cmVmPltodHRwOi8vd3d3Lm1vbGRwcmVzLm1kL2RlZmF1bHQuYXNwP0xhbmc9ZW4mSUQ9Njg3MTUgIk1vbGRvdmEgd2lsbCBwcm92ZSB0aGF0IGl0IGNhbiBhbmQgaGFzIGNoYW5jZXMgdG8gYmVjb21lIEVVIG1lbWJlciwiXSBNb2xkcHJlc3MgTmV3cyBBZ2VuY3ksIEp1bmUgMTksIDIwMDc8L3JlZj4gYW5kIGhhcyBpbXBsZW1lbnRlZCB0aGUgZmlyc3QgdGhyZWUteWVhciBBY3Rpb24gUGxhbiB3aXRoaW4gdGhlIGZyYW1ld29yayBvZiB0aGUgW1tFdXJvcGVhbiBOZWlnaGJvdXJob29kIFBvbGljeV1dIChFTlApLjxyZWY+W2h0dHA6Ly9zb2NpYWwubW9sZG92YS5vcmcvbmV3cy80MC1lbmcuaHRtbCAiTW9sZG92YS1FVSBBY3Rpb24gUGxhbiBBcHByb3ZlZCBieSBFdXJvcGVhbiBDb21taXNzaW9uIl0sIG1vbGRvdmEub3JnLCBEZWNlbWJlciAxNCwgMjAwNCwgcmV0cmlldmVkIEp1bHkgMiwgMjAwNzwvcmVmPiBBYm91dCBhIHF1YXJ0ZXIgb2YgdGhlIHBvcHVsYXRpb24gbGl2ZXMgb24gbGVzcyB0aGFuIFVTJCAyIGEgZGF5LiA8cmVmPiBodHRwOi8vaGRyLnVuZHAub3JnL2VuL21lZGlhL0hESV8yMDA4X0VOX1RhYmxlcy5wZGYgPC9yZWY+]]
hasOperation: [[hasOperation::46B0DDA330CB057434586A52435CE43233;Insert;(107378964033062743085:26a70380f78f203e27ed3db9322b2f78) ;VGhlIGNvdW50cnkgaXMgYSBwYXJsaWFtZW50YXJ5IGRlbW9jcmFjeSB3aXRoIGEgW1tQcmVzaWRlbnQgb2YgTW9sZG92YXxwcmVzaWRlbnRdXSBhcyBoZWFkIG9mIHN0YXRlIGFuZCBhIFtbTGlzdCBvZiBQcmltZSBNaW5pc3RlcnMgb2YgTW9sZG92YXxwcmltZSBtaW5pc3Rlcl1dIGFzIFtbaGVhZCBvZiBnb3Zlcm5tZW50XV0uIE1vbGRvdmEgaXMgYSBtZW1iZXIgc3RhdGUgb2YgdGhlIFtbVW5pdGVkIE5hdGlvbnNdXSwgW1tDb3VuY2lsIG9mIEV1cm9wZV1dLCBbW1dvcmxkIFRyYWRlIE9yZ2FuaXphdGlvbnxXVE9dXSwgW1tPcmdhbml6YXRpb24gZm9yIFNlY3VyaXR5IGFuZCBDb29wZXJhdGlvbiBpbiBFdXJvcGV8T1NDRV1dLCBbW0dVQU1dXSwgW1tDb21tb253ZWFsdGggb2YgSW5kZXBlbmRlbnQgU3RhdGVzfENJU11dLCBbW09yZ2FuaXphdGlvbiBvZiB0aGUgQmxhY2sgU2VhIEVjb25vbWljIENvb3BlcmF0aW9ufEJTRUNdXSBhbmQgb3RoZXIgW1tpbnRlcm5hdGlvbmFsIG9yZ2FuaXphdGlvbl1dcy4gTW9sZG92YSBjdXJyZW50bHkgYXNwaXJlcyB0byBqb2luIHRoZSBbW0V1cm9wZWFuIFVuaW9uXV0sPHJlZj5baHR0cDovL3d3dy5tb2xkcHJlcy5tZC9kZWZhdWx0LmFzcD9MYW5nPWVuJklEPTY4NzE1ICJNb2xkb3ZhIHdpbGwgcHJvdmUgdGhhdCBpdCBjYW4gYW5kIGhhcyBjaGFuY2VzIHRvIGJlY29tZSBFVSBtZW1iZXIsIl0gTW9sZHByZXNzIE5ld3MgQWdlbmN5LCBKdW5lIDE5LCAyMDA3PC9yZWY+IGFuZCBoYXMgaW1wbGVtZW50ZWQgdGhlIGZpcnN0IHRocmVlLXllYXIgQWN0aW9uIFBsYW4gd2l0aGluIHRoZSBmcmFtZXdvcmsgb2YgdGhlIFtbRXVyb3BlYW4gTmVpZ2hib3VyaG9vZCBQb2xpY3ldXSAoRU5QKS48cmVmPltodHRwOi8vc29jaWFsLm1vbGRvdmEub3JnL25ld3MvNDAtZW5nLmh0bWwgIk1vbGRvdmEtRVUgQWN0aW9uIFBsYW4gQXBwcm92ZWQgYnkgRXVyb3BlYW4gQ29tbWlzc2lvbiJdLCBtb2xkb3ZhLm9yZywgRGVjZW1iZXIgMTQsIDIwMDQsIHJldHJpZXZlZCBKdWx5IDIsIDIwMDc8L3JlZj4gQWJvdXQgYSBxdWFydGVyIG9mIHRoZSBwb3B1bGF0aW9uIGxpdmVzIG9uIGxlc3MgdGhhbiBVUyQgMiBhIGRheS4gPHJlZj4gaHR0cDovL2hkci51bmRwLm9yZy9lbi9tZWRpYS9IRElfMjAwOF9FTl9UYWJsZXMucGRmIDwvcmVmPg==]]
previous: [[previous::Patch:46B0DDA330CB057434586A52435CE43222]]' );

        $this->p2pBot1->createPage( 'Patch:46B0DDA330CB057434586A52435CE43234', 'Patch: patchID: [[patchID::Patch:46B0DDA330CB057434586A52435CE43234]]
 onPage: [[onPage::Moldova]]  hasOperation: [[hasOperation::46B0DDA330CB057434586A52435CE43235;Delete;(107378964033062743085:26a70380f78f203e27ed3db9322b2f78) ;VGhlIGNvdW50cnkgaXMgYSBwYXJsaWFtZW50YXJ5IGRlbW9jcmFjeSB3aXRoIGEgW1tQcmVzaWRlbnQgb2YgTW9sZG92YXxwcmVzaWRlbnRdXSBhcyBoZWFkIG9mIHN0YXRlIGFuZCBhIFtbTGlzdCBvZiBQcmltZSBNaW5pc3RlcnMgb2YgTW9sZG92YXxwcmltZSBtaW5pc3Rlcl1dIGFzIFtbaGVhZCBvZiBnb3Zlcm5tZW50XV0uIE1vbGRvdmEgaXMgYSBtZW1iZXIgc3RhdGUgb2YgdGhlIFtbVW5pdGVkIE5hdGlvbnNdXSwgW1tDb3VuY2lsIG9mIEV1cm9wZV1dLCBbW1dvcmxkIFRyYWRlIE9yZ2FuaXphdGlvbnxXVE9dXSwgW1tPcmdhbml6YXRpb24gZm9yIFNlY3VyaXR5IGFuZCBDb29wZXJhdGlvbiBpbiBFdXJvcGV8T1NDRV1dLCBbW0dVQU1dXSwgW1tDb21tb253ZWFsdGggb2YgSW5kZXBlbmRlbnQgU3RhdGVzfENJU11dLCBbW09yZ2FuaXphdGlvbiBvZiB0aGUgQmxhY2sgU2VhIEVjb25vbWljIENvb3BlcmF0aW9ufEJTRUNdXSBhbmQgb3RoZXIgW1tpbnRlcm5hdGlvbmFsIG9yZ2FuaXphdGlvbl1dcy4gTW9sZG92YSBjdXJyZW50bHkgYXNwaXJlcyB0byBqb2luIHRoZSBbW0V1cm9wZWFuIFVuaW9uXV0sPHJlZj5baHR0cDovL3d3dy5tb2xkcHJlcy5tZC9kZWZhdWx0LmFzcD9MYW5nPWVuJklEPTY4NzE1ICJNb2xkb3ZhIHdpbGwgcHJvdmUgdGhhdCBpdCBjYW4gYW5kIGhhcyBjaGFuY2VzIHRvIGJlY29tZSBFVSBtZW1iZXIsIl0gTW9sZHByZXNzIE5ld3MgQWdlbmN5LCBKdW5lIDE5LCAyMDA3PC9yZWY+IGFuZCBoYXMgaW1wbGVtZW50ZWQgdGhlIGZpcnN0IHRocmVlLXllYXIgQWN0aW9uIFBsYW4gd2l0aGluIHRoZSBmcmFtZXdvcmsgb2YgdGhlIFtbRXVyb3BlYW4gTmVpZ2hib3VyaG9vZCBQb2xpY3ldXSAoRU5QKS48cmVmPltodHRwOi8vc29jaWFsLm1vbGRvdmEub3JnL25ld3MvNDAtZW5nLmh0bWwgIk1vbGRvdmEtRVUgQWN0aW9uIFBsYW4gQXBwcm92ZWQgYnkgRXVyb3BlYW4gQ29tbWlzc2lvbiJdLCBtb2xkb3ZhLm9yZywgRGVjZW1iZXIgMTQsIDIwMDQsIHJldHJpZXZlZCBKdWx5IDIsIDIwMDc8L3JlZj4gQWJvdXQgYSBxdWFydGVyIG9mIHRoZSBwb3B1bGF0aW9uIGxpdmVzIG9uIGxlc3MgdGhhbiBVUyQgMiBhIGRheS4gPHJlZj4gaHR0cDovL2hkci51bmRwLm9yZy9lbi9tZWRpYS9IRElfMjAwOF9FTl9UYWJsZXMucGRmIDwvcmVmPg==]]
hasOperation: [[hasOperation::46B0DDA330CB057434586A52435CE43236;Insert;(92704084275855495480:26a70380f78f203e27ed3db9322b2f78) ;VGhlIGNvdW50cnkgaXMgYSBwYXJsaWFtZW50YXJ5IGRlbW9jcmFjeSB3aXRoIGEgW1tQcmVzaWRlbnQgb2YgTW9sZG92YXxwcmVzaWRlbnRdXSBhcyBoZWFkIG9mIHN0YXRlIGFuZCBhIFtbTGlzdCBvZiBQcmltZSBNaW5pc3RlcnMgb2YgTW9sZG92YXxwcmltZSBtaW5pc3Rlcl1dIGFzIFtbaGVhZCBvZiBnb3Zlcm5tZW50XV0uIE1vbGRvdmEgaXMgYSBtZW1iZXIgc3RhdGUgb2YgdGhlIFtbVW5pdGVkIE5hdGlvbnNdXSwgW1tDb3VuY2lsIG9mIEV1cm9wZV1dLCBbW1dvcmxkIFRyYWRlIE9yZ2FuaXphdGlvbnxXVE9dXSwgW1tPcmdhbml6YXRpb24gZm9yIFNlY3VyaXR5IGFuZCBDb29wZXJhdGlvbiBpbiBFdXJvcGV8T1NDRV1dLCBbW0dVQU1dXSwgW1tDb21tb253ZWFsdGggb2YgSW5kZXBlbmRlbnQgU3RhdGVzfENJU11dLCBbW09yZ2FuaXphdGlvbiBvZiB0aGUgQmxhY2sgU2VhIEVjb25vbWljIENvb3BlcmF0aW9ufEJTRUNdXSBhbmQgb3RoZXIgW1tpbnRlcm5hdGlvbmFsIG9yZ2FuaXphdGlvbl1dcy4gTW9sZG92YSBjdXJyZW50bHkgYXNwaXJlcyB0byBqb2luIHRoZSBbW0V1cm9wZWFuIFVuaW9uXV0u]]
previous: [[previous::Patch:46B0DDA330CB057434586A52435CE43225]]' );

        $this->p2pBot1->createPage( 'Patch:46B0DDA330CB057434586A52435CE4329', 'Patch: patchID: [[patchID::Patch:46B0DDA330CB057434586A52435CE4329]]
 onPage: [[onPage::Moldova]]  hasOperation: [[hasOperation::46B0DDA330CB057434586A52435CE43210;Insert;(6394517056216502886:26a70380f78f203e27ed3db9322b2f78) ;JycnTW9sZG92YScnJyB7e0F1ZGlvLUlQQXxlbi11cy1Nb2xkb3ZhLm9nZ3wvbcmSbMuIZG/KinbJmS99fSwgb2ZmaWNpYWxseSB0aGUgJycnUmVwdWJsaWMgb2YgTW9sZG92YScnJyAoJydSZXB1YmxpY2EgTW9sZG92YScnKSBpcyBhIFtbbGFuZGxvY2tlZF1dIGNvdW50cnkgaW4gW1tsb2NhdGVkX2luOjpFdXJvcF1dLCBsb2NhdGVkIGJldHdlZW4gW1tSb21hbmlhXV0gdG8gdGhlIHdlc3QgYW5kIFtbVWtyYWluZV1dIHRvIHRoZSBub3J0aCwgZWFzdCBhbmQgc291dGgu]]
hasOperation: [[hasOperation::46B0DDA330CB057434586A52435CE43211;Insert;(16519919050962384105:26a70380f78f203e27ed3db9322b2f78) ;]]  hasOperation: [[hasOperation::46B0DDA330CB057434586A52435CE43212;Insert;(29158425422724464787:26a70380f78f203e27ed3db9322b2f78) ;SW4gdGhlIFtbTWlkZGxlIEFnZXNdXSwgbW9zdCBvZiB0aGUgcHJlc2VudCB0ZXJyaXRvcnkgb2YgTW9sZG92YSB3YXMgcGFydCBvZiB0aGUgW1tQcmluY2lwYWxpdHkgb2YgTW9sZGF2aWFdXS4gSW4gMTgxMiwgaXQgd2FzIFtbQmVzc2FyYWJpYSBHb3Zlcm5vcmF0ZXxhbm5leGVkXV0gYnkgdGhlIFtbUnVzc2lhbiBFbXBpcmVdXSwgYW5kIGJlY2FtZSBrbm93biBhcyBbW0Jlc3NhcmFiaWFdXS4gQmV0d2VlbiAxODU2IGFuZCAxODc4LCB0aGUgc291dGhlcm4gcGFydCB3YXMgcmV0dXJuZWQgdG8gTW9sZGF2aWEuICBJbiAxODU5IGl0IHVuaXRlZCB3aXRoIFtbV2FsbGFjaGlhXV0gdG8gZm9ybSBtb2Rlcm4gUm9tYW5pYS4g]]
hasOperation: [[hasOperation::46B0DDA330CB057434586A52435CE43213;Insert;(30279692777881271362:26a70380f78f203e27ed3db9322b2f78) ;]]  hasOperation: [[hasOperation::46B0DDA330CB057434586A52435CE43214;Insert;(35367798116518511556:26a70380f78f203e27ed3db9322b2f78) ;VXBvbiB0aGUgZGlzc29sdXRpb24gb2YgdGhlIFJ1c3NpYW4gRW1waXJlIGluIDE5MTcsIGFuIGF1dG9ub21vdXMsIHRoZW4taW5kZXBlbmRlbnQgW1tNb2xkYXZpYW4gRGVtb2NyYXRpYyBSZXB1YmxpY11dIHdhcyBmb3JtZWQsIHdoaWNoIFtbVW5pb24gb2YgQmVzc2FyYWJpYSB3aXRoIFJvbWFuaWF8am9pbmVkXV0gW1tHcmVhdGVyIFJvbWFuaWF8Um9tYW5pYV1dIGluIDE5MTguIEluIDE5NDAsIEJlc3NhcmFiaWEgW1tTb3ZpZXQgb2NjdXBhdGlvbiBvZiBCZXNzYXJhYmlhIGFuZCBOb3J0aGVybiBCdWtvdmluYXx3YXMgb2NjdXBpZWRdXSBieSB0aGUgW1tTb3ZpZXQgVW5pb25dXSBhbmQgd2FzIHNwbGl0IGJldHdlZW4gdGhlIFVrcmFpbmlhbiBTU1JdXSBhbmQgdGhlIG5ld2x5IGNyZWF0ZWQgW1tNb2xkYXZpYW4gU1NSXV0uIA==]]
hasOperation: [[hasOperation::46B0DDA330CB057434586A52435CE43215;Insert;(43164450452102032160:26a70380f78f203e27ed3db9322b2f78) ;]]  hasOperation: [[hasOperation::46B0DDA330CB057434586A52435CE43216;Insert;(45985308014614916088:26a70380f78f203e27ed3db9322b2f78) ;QWZ0ZXIgY2hhbmdpbmcgaGFuZHMgaW4gMTk0MSBhbmQgMTk0NCBkdXJpbmcgV29ybGQgV2FyIElJLCB0aGUgdGVycml0b3J5IG9mIHRoZSBtb2Rlcm4gY291bnRyeSB3YXMgc3Vic3VtZWQgYnkgdGhlIFNvdmlldCBVbmlvbiB1bnRpbCBpdHMgZGVjbGFyYXRpb24gb2YgaW5kZXBlbmRlbmNlIG9uIEF1Z3VzdCAyNywgMTk5MS4gTW9sZG92YSB3YXMgYWRtaXR0ZWQgdG8gdGhlIFtbVW5pdGVkIE5hdGlvbnN8VU5dXSBpbiBNYXJjaCAxOTkyLiA=]]
hasOperation: [[hasOperation::46B0DDA330CB057434586A52435CE43217;Insert;(62978203392892544763:26a70380f78f203e27ed3db9322b2f78) ;]]  hasOperation: [[hasOperation::46B0DDA330CB057434586A52435CE43218;Insert;(78211748375579569933:26a70380f78f203e27ed3db9322b2f78) ;SW4gU2VwdGVtYmVyIDE5OTAsIGEgYnJlYWthd2F5IGdvdmVybm1lbnQgd2FzIGZvcm1lZCBpbiBbW1RyYW5zbmlzdHJpYV1dLCBhIHN0cmlwIG9mIE1vbGRhdmlhbiBTU1Igb24gdGhlIGVhc3QgYmFuayBvZiB0aGUgcml2ZXIgW1tEbmllc3Rlcl1dLiAgQWZ0ZXIgYSBicmllZiBbW1dhciBvZiBUcmFuc25pc3RyaWF8d2FyIGluIDE5OTJdXSwgaXQgYmVjYW1lICcnZGUgZmFjdG8nJyBpbmRlcGVuZGVudCwgYWx0aG91Z2ggbm8gVU4gbWVtYmVyIGhhcyByZWNvZ25pemVkIGl0cyBpbmRlcGVuZGVuY2Uu]]
hasOperation: [[hasOperation::46B0DDA330CB057434586A52435CE43219;Insert;(91206000681005520803:26a70380f78f203e27ed3db9322b2f78) ;]]  hasOperation: [[hasOperation::46B0DDA330CB057434586A52435CE43220;Insert;(108558917756701573695:26a70380f78f203e27ed3db9322b2f78) ;VGhlIGNvdW50cnkgaXMgYSBbW3BhcmxpYW1lbnRhcnkgZGVtb2NyYWN5XV0gd2l0aCBhIFtbUHJlc2lkZW50IG9mIE1vbGRvdmF8cHJlc2lkZW50XV0gYXMgW1toZWFkIG9mIHN0YXRlXV0gYW5kIGEgW1tMaXN0IG9mIFByaW1lIE1pbmlzdGVycyBvZiBNb2xkb3ZhfHByaW1lIG1pbmlzdGVyXV0gYXMgW1toZWFkIG9mIGdvdmVybm1lbnRdXS4gTW9sZG92YSBpcyBhIG1lbWJlciBzdGF0ZSBvZiB0aGUgW1tVbml0ZWQgTmF0aW9uc11dLCBbW0NvdW5jaWwgb2YgRXVyb3BlXV0sIFtbV29ybGQgVHJhZGUgT3JnYW5pemF0aW9ufFdUT11dLCBbW09yZ2FuaXphdGlvbiBmb3IgU2VjdXJpdHkgYW5kIENvb3BlcmF0aW9uIGluIEV1cm9wZXxPU0NFXV0sIFtbR1VBTV1dLCBbW0NvbW1vbndlYWx0aCBvZiBJbmRlcGVuZGVudCBTdGF0ZXN8Q0lTXV0sIFtbT3JnYW5pemF0aW9uIG9mIHRoZSBCbGFjayBTZWEgRWNvbm9taWMgQ29vcGVyYXRpb258QlNFQ11dIGFuZCBvdGhlciBbW2ludGVybmF0aW9uYWwgb3JnYW5pemF0aW9uXV1zLiBNb2xkb3ZhIGN1cnJlbnRseSBhc3BpcmVzIHRvIGpvaW4gdGhlIFtbRXVyb3BlYW4gVW5pb25dXSw8cmVmPltodHRwOi8vd3d3Lm1vbGRwcmVzLm1kL2RlZmF1bHQuYXNwP0xhbmc9ZW4mSUQ9Njg3MTUgIk1vbGRvdmEgd2lsbCBwcm92ZSB0aGF0IGl0IGNhbiBhbmQgaGFzIGNoYW5jZXMgdG8gYmVjb21lIEVVIG1lbWJlciwiXSBNb2xkcHJlc3MgTmV3cyBBZ2VuY3ksIEp1bmUgMTksIDIwMDc8L3JlZj4gYW5kIGhhcyBpbXBsZW1lbnRlZCB0aGUgZmlyc3QgdGhyZWUteWVhciBBY3Rpb24gUGxhbiB3aXRoaW4gdGhlIGZyYW1ld29yayBvZiB0aGUgW1tFdXJvcGVhbiBOZWlnaGJvdXJob29kIFBvbGljeV1dIChFTlApLjxyZWY+W2h0dHA6Ly9zb2NpYWwubW9sZG92YS5vcmcvbmV3cy80MC1lbmcuaHRtbCAiTW9sZG92YS1FVSBBY3Rpb24gUGxhbiBBcHByb3ZlZCBieSBFdXJvcGVhbiBDb21taXNzaW9uIl0sIG1vbGRvdmEub3JnLCBEZWNlbWJlciAxNCwgMjAwNCwgcmV0cmlldmVkIEp1bHkgMiwgMjAwNzwvcmVmPiBBYm91dCBhIHF1YXJ0ZXIgb2YgdGhlIHBvcHVsYXRpb24gbGl2ZXMgb24gbGVzcyB0aGFuIFVTJCAyIGEgZGF5LiA8cmVmPiBodHRwOi8vaGRyLnVuZHAub3JnL2VuL21lZGlhL0hESV8yMDA4X0VOX1RhYmxlcy5wZGYgPC9yZWY+]]
hasOperation: [[hasOperation::46B0DDA330CB057434586A52435CE43221;Insert;(110478039804140508346:26a70380f78f203e27ed3db9322b2f78) ;W1tDYXRlZ29yeTpDb3VudHJ5XV0=]]
previous: [[previous::none]]' );

        $this->assertTrue( $this->p2pBot1->createPush( 'PushPage_Moldova', '[[Moldova]]' ),
            'failed to create push PushPage_Moldova : (' . $this->p2pBot1->bot->results . ')' );
        $this->assertTrue( $this->p2pBot1->push( 'PushFeed:PushPage_Moldova' ),
            'failed to push PushPage_Moldova : (' . $this->p2pBot1->bot->results . ')' );

        $CS = getSemanticRequest( $this->p2pBot1->bot->wikiServer, '[[name::PushFeed:PushPage_Moldova]]', '-3FhasPushHead' );
        $CS = $CS[0];

        $patchs = getSemanticRequest( $this->p2pBot1->bot->wikiServer, '[[changeSetID::' . $CS . ']]', '-3FhasPatch' );
        $patchs = explode( ',', $patchs[0] );

        $this->assertTrue( count( $patchs ) == 4 );

        $this->assertEquals( $patchs[0], 'Patch:46B0DDA330CB057434586A52435CE4329', 'failed in changeSet, patchs are not ordered' );
        $this->assertEquals( $patchs[1], 'Patch:46B0DDA330CB057434586A52435CE43222', 'failed in changeSet, patchs are not ordered' );
        $this->assertEquals( $patchs[2], 'Patch:46B0DDA330CB057434586A52435CE43225', 'failed in changeSet, patchs are not ordered' );
        $this->assertEquals( $patchs[3], 'Patch:46B0DDA330CB057434586A52435CE43234', 'failed in changeSet, patchs are not ordered' );
    }

    public function testPushWithChangeSet1() {
        $this->testCreatePush();

        $this->assertTrue( $this->p2pBot1->createPage( 'Arches', "content arches [[Category:titi]]",
            'failed to create page Arches (' . $this->p2pBot1->bot->results . ')' ) );
        $this->assertTrue( $this->p2pBot1->createPage( 'Paris11', 'content Paris11 [[Category:titi]]',
            'failed to create page Paris11 (' . $this->p2pBot1->bot->results . ')' ) );

        $this->assertTrue( $this->p2pBot1->push( 'PushFeed:PushCity11' ),
            'failed to push ' . $pushName . ' (' . $this->p2pBot1->bot->results . ')' );

        // assert that pushHead attribute is not null and the changeSet page exist
        $pushFound = getSemanticRequest( $this->p2pBot1->bot->wikiServer, '[[name::PushFeed:PushCity11]]', '-3FhasPushHead' );
        $this->assertNotEquals( '', $pushFound[0] );

        $CSIDFound = $pushFound[0];
        assertPageExist( $this->p2pBot1->bot->wikiServer, $CSIDFound );

        // assert the changeSet created is ok
        $CSFound = getSemanticRequest( $this->p2pBot1->bot->wikiServer, '[[changeSetID::' . $CSIDFound . ']]', '-3FchangeSetID/-3FinPushFeed/-3FpreviousChangeSet/-3FhasPatch' );
        // assert inPushFeed
        $this->assertEquals( strtolower( 'PushFeed:PushCity11' ), strtolower( $CSFound[1] ),
            'failed to push PushCity11, ChangeSet push name must be PushFeed:' . $pushName . ' but ' . $CSFound[1] . ' was found' );
        // assert previousChangeSet
        $this->assertEquals( 'none', strtolower( $CSFound[2] ),
            'failed to push PushCity11, ChangeSet previous must be None but ' . $CSFound[2] . ' was found' );

        $patchCS = explode( ',', $CSFound[3] );
        $this->assertTrue( count( $patchCS ) == 2,
            'failed to push PushCity11, ChangeSet must contains 2 patchs but ' . count( $patchCS ) . ' patchs were found' );

        // assert patchs contains in the changeSet is ok
        $lastPatchNancy = utils::getLastPatchId( 'Arches', $this->p2pBot1->bot->wikiServer );
        $lastPatchParis = utils::getLastPatchId( 'Paris11', $this->p2pBot1->bot->wikiServer );
        $assert1 = strtolower( $lastPatchNancy ) == strtolower( $patchCS[0] ) || strtolower( $lastPatchNancy ) == strtolower( $patchCS[1] );
        $assert2 = strtolower( $lastPatchParis ) == strtolower( $patchCS[0] ) || strtolower( $lastPatchParis ) == strtolower( $patchCS[1] );
        $this->assertTrue( $assert1 && $assert2,
            'failed to push ' . $pushName . ', wrong patch in changeSet' );
    }

    public function testPushWithChangeSet2() {
        $this->testPushWithChangeSet1();

        $allCS = getSemanticRequest( $this->p2pBot1->bot->wikiServer, '[[ChangeSet:+]][[inPushFeed::PushFeed:PushCity11]]', '-3FchangeSetID' );
        $previousCS = $allCS[0];
        $this->p2pBot1->editPage( Arches, 'content added on the page' );

        $this->p2pBot1->push( 'PushFeed:PushCity11' );

        $pushFound = getSemanticRequest( $this->p2pBot1->bot->wikiServer, '[[name::PushFeed:PushCity11]]', '-3FhasPushHead' );
        $CSIDFound = $pushFound[0];

        $this->assertNotEquals( $previousCS, $CSIDFound );

        // assert that previousChangeSet is ok
        $CSFound = getSemanticRequest( $this->p2pBot1->bot->wikiServer, '[[changeSetID::' . $CSIDFound . ']]', '-3FpreviousChangeSet' );
        $this->assertEquals( strtolower( $previousCS ), strtolower( $CSFound[0] ) );
    }

    public function testMultiPush() {
        $this->assertTrue( $this->p2pBot1->createPage( 'Toto12', '[[Category:toto]]' ) );
        $this->assertTrue( $this->p2pBot1->createPage( 'Titi12', '[[Category:titi]]' ) );
        $this->assertTrue( $this->p2pBot1->createPage( 'Tata12', '[[Category:tata]]' ) );

        $this->assertTrue( $this->p2pBot1->createPush( 'PushToto12', '[[Category:toto]]' ) );
        $this->assertTrue( $this->p2pBot1->createPush( 'PushTiti12', '[[Category:titi]]' ) );
        $this->assertTrue( $this->p2pBot1->createPush( 'PushTata12', '[[Category:tata]]' ) );

        $array = array( 'PushFeed:PushToto12', 'PushFeed:PushTiti12', 'PushFeed:PushTata12' );
        $this->assertTrue( $this->p2pBot1->push( $array ) );

        // assert that allchange set were created
        $countCS = count( getSemanticRequest( $this->p2pBot1->bot->wikiServer, '[[inPushFeed::PushFeed:PushToto12]]', '-3FchangeSetID' ) );
        $this->assertTrue( $countCS == 1 );

        $countCS = count( getSemanticRequest( $this->p2pBot1->bot->wikiServer, '[[inPushFeed::PushFeed:PushTiti12]]', '-3FchangeSetID' ) );
        $this->assertTrue( $countCS == 1 );

        $countCS = count( getSemanticRequest( $this->p2pBot1->bot->wikiServer, '[[inPushFeed::PushFeed:PushTata12]]', '-3FchangeSetID' ) );
        $this->assertTrue( $countCS == 1 );
    }

}
?>
