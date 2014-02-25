<?php

if ( !defined( 'MEDIAWIKI' ) ) { define( 'MEDIAWIKI', true ); }
if ( defined( 'MW_INSTALL_PATH' ) ) {
    $IP = MW_INSTALL_PATH;
} else {
    $IP = dirname( '../../../../.' );
}

require_once '../p2pBot.php';
require_once '../BasicBot.php';
require_once '../../logootComponent/LogootId.php';
require_once '../../logootComponent/LogootPosition.php';
require_once '../../logootComponent/LogootIns.php';
require_once '../../logootComponent/LogootDel.php';
// require_once '../../DSMW.php';
require_once '../../patch/Patch.php';
require_once '../../files/utils.php';
include_once '../p2pAssert.php';
require_once '../settings.php';


/**
 * apiQueryChangeSet, apiQueryPatch and apiPatchPush tests
 *
 * @author hantz
 */
class apiTest extends PHPUnit_Framework_TestCase {
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
        $this->p2pBot1->updateProperies();

        $basicbot2 = new BasicBot();
        $basicbot2->wikiServer = $this->wiki2;
        $this->p2pBot2 = new p2pBot( $basicbot2 );
        $this->p2pBot2->updateProperies();

        $basicbot3 = new BasicBot();
        $basicbot3->wikiServer = $this->wiki3;
        $this->p2pBot3 = new p2pBot( $basicbot3 );
        $this->p2pBot3->updateProperies();
    }

    /**
     * @access protected
     */
    protected function tearDown() {

    }

    /**
     * test ApiQueryPatch
     */
    function testGetPatch() {
        $patchName = 'patch:localhost/wiki1';
        $content = '[[patchID::' . $patchName . ']] [[onPage::Berlin]] [[previous::localhost/wiki0]] [[siteID::id1]]
        [[hasOperation::Localhost/wiki111;Insert;(15555995255933583146:900c17ebee311fb6dd00970d26727577) ;content page berlin]]';
        $this->assertTrue( $this->p2pBot1->createPage( $patchName, $content ),
            'failed to create page ' . $patchName . ' (' . $this->p2pBot1->bot->results . ')' );

        $this->assertTrue( $this->p2pBot1->createPage( $patchName, $content ),
            'failed to create page ' . $patchName . ' (' . $this->p2pBot1->bot->results . ')' );
        $patchName = 'Patch:localhost/wiki2';
        $content = '[[patchID::' . $patchName . ']] [[onPage::Paris]] [[previous::none]] [[siteID::id1]]
        [[hasOperation::Localhost/wiki121;Insert;(15555995255933583146:900c17ebee311fb6dd00970d26727577) ;content page Paris]]';

        $this->assertTrue( $this->p2pBot1->createPage( $patchName, $content ),
            'failed to create page ' . $patchName . ' (' . $this->p2pBot1->bot->results . ')' );


        // ApiQueryPatch call
        $patchXML = file_get_contents( $this->p2pBot1->bot->wikiServer . '/api.php?action=query&meta=patch&papatchId=Patch:localhost/wiki2&format=xml' );

        $dom = new DOMDocument();
        $dom->loadXML( $patchXML );
        $patchs = $dom->getElementsByTagName( 'patch' );

        foreach ( $patchs as $p ) {
            $this->assertEquals( 'patch:localhost/wiki2', strtolower( $p->getAttribute( 'id' ) ) );
            $this->assertEquals( 'paris', strtolower( $p->getAttribute( 'onPage' ) ) );
            $t = $p->getAttribute( 'previous' );
            $this->assertEquals( 'none', strtolower( $p->getAttribute( 'previous' ) ) );
        }

        $listeOp = $dom->getElementsByTagName( 'operation' );

        $op = null;
        foreach ( $listeOp as $o )
            $op[] = $o->firstChild->nodeValue;

        $this->assertTrue( count( $op ) == 1, 'failed to count operation, ' . count( $op ) . ' were found, but 1 operation is required' );

        $contentOp = str_replace( " ", "", 'Localhost/wiki121; Insert; (15555995255933583146:900c17ebee311fb6dd00970d26727577); content page Paris' );
        $this->assertEquals( $contentOp, str_replace( " ", "", $op[0] ) );
    }

    /**
     * test apiQueryPatch with a long content operation
     */
    public function testGetPatchWithLongOp() {
        $this->assertTrue( $this->p2pBot1->createPage( 'Patch:46B0DDA330CB057434586A52435CE43222', 'Patch: patchID: [[patchID::Patch:46B0DDA330CB057434586A52435CE43222]]
 onPage: [[onPage::Moldova]]
[[hasOperation::46B0DDA330CB057434586A52435CE43223;Delete;(6394517056216502886:26a70380f78f203e27ed3db9322b2f78) ;JycnTW9sZG92YScnJyB7e0F1ZGlvLUlQQXxlbi11cy1Nb2xkb3ZhLm9nZ3wvbcmSbMuIZG/KinbJmS99fSwgb2ZmaWNpYWxseSB0aGUgJycnUmVwdWJsaWMgb2YgTW9sZG92YScnJyAoJydSZXB1YmxpY2EgTW9sZG92YScnKSBpcyBhIFtbbGFuZGxvY2tlZF1dIGNvdW50cnkgaW4gW1tsb2NhdGVkX2luOjpFdXJvcF1dLCBsb2NhdGVkIGJldHdlZW4gW1tSb21hbmlhXV0gdG8gdGhlIHdlc3QgYW5kIFtbVWtyYWluZV1dIHRvIHRoZSBub3J0aCwgZWFzdCBhbmQgc291dGgu]]
hasOperation: [[hasOperation::46B0DDA330CB057434586A52435CE43224;Insert;(587539302497374424:26a70380f78f203e27ed3db9322b2f78) ;JycnTW9sZG92YScnJywgb2ZmaWNpYWxseSB0aGUgJycnUmVwdWJsaWMgb2YgTW9sZG92YScnJyAoJydSZXB1YmxpY2EgTW9sZG92YScnKSBpcyBhIFtbbGFuZGxvY2tlZF1dIGNvdW50cnkgaW4gW1tsb2NhdGVkX2luOjpFdXJvcF1dLCBsb2NhdGVkIGJldHdlZW4gW1tSb21hbmlhXV0gdG8gdGhlIHdlc3QgYW5kIFtbVWtyYWluZV1dIHRvIHRoZSBub3J0aCwgZWFzdCBhbmQgc291dGgus]]
previous: [[previous::Patch:46B0DDA330CB057434586A52435CE4329]] [[siteID::id1]]' ), 'failed to create page Patch : (' . $this->p2pBot1->bot->results . ')' );

       /* $this->p2pBot1->createPage('Toto','Moldova en-us-Moldova.ogg /mɒlˈdoʊvə/ (help·info), officially the Republic of Moldova (Republica Moldova) is a landlocked country in Eastern Europe, located between Romania to the west and Ukraine to the north, east and south.

In the Middle Ages, most of the present territory of Moldova was part of the Principality of Moldavia. In 1812, it was annexed by the Russian Empire, and became known as Bessarabia. Between 1856 and 1878, the southern part was returned to Moldavia. In 1859 it united with Wallachia to form modern Romania.

Upon the dissolution of the Russian Empire in 1917, an autonomous, then-independent Moldavian Democratic Republic was formed, which joined Romania in 1918. In 1940, Bessarabia was occupied by the Soviet Union and was split between the Ukrainian SSR and the newly created Moldavian SSR.

After changing hands in 1941 and 1944 during World War II, the territory of the modern country was subsumed by the Soviet Union until its declaration of independence on August 27, 1991. Moldova was admitted to the UN in March 1992.

In September 1990, a breakaway government was formed in Transnistria, a strip of Moldavian SSR on the east bank of the river Dniester. After a brief war in 1992, it became de facto independent, although no UN member has recognized its independence.

The country is a parliamentary democracy with a president as head of state and a prime minister as head of government. Moldova is a member state of the United Nations, Council of Europe, WTO, OSCE, GUAM, CIS, BSEC and other international organizations. Moldova currently aspires to join the European Union,[4] and has implemented the first three-year Action Plan within the framework of the European Neighbourhood Policy (ENP).[5] About a quarter of the population lives on less than US$ 2 a day.');*/

      //  $patchId = getSemanticRequest($this->p2pBot1->bot->wikiServer, '[[Patch:+]][[onPage::Toto', '-3FpatchID');

        $patchXML = file_get_contents( $this->p2pBot1->bot->wikiServer . '/api.php?action=query&meta=patch&papatchId=Patch:46B0DDA330CB057434586A52435CE43222&format=xml' );

        $dom = new DOMDocument();
        $dom->loadXML( $patchXML );

        $listeOp = $dom->getElementsByTagName( 'operation' );

        $op = null;
        foreach ( $listeOp as $o )
            $op[] = $o->firstChild->nodeValue;

      $this->assertTrue( count( $op ) == 2 );
      $this->assertEquals( str_replace( ' ', '', $op[0] ), '46B0DDA330CB057434586A52435CE43223;Delete;(6394517056216502886:26a70380f78f203e27ed3db9322b2f78);JycnTW9sZG92YScnJyB7e0F1ZGlvLUlQQXxlbi11cy1Nb2xkb3ZhLm9nZ3wvbcmSbMuIZG/KinbJmS99fSwgb2ZmaWNpYWxseSB0aGUgJycnUmVwdWJsaWMgb2YgTW9sZG92YScnJyAoJydSZXB1YmxpY2EgTW9sZG92YScnKSBpcyBhIFtbbGFuZGxvY2tlZF1dIGNvdW50cnkgaW4gW1tsb2NhdGVkX2luOjpFdXJvcF1dLCBsb2NhdGVkIGJldHdlZW4gW1tSb21hbmlhXV0gdG8gdGhlIHdlc3QgYW5kIFtbVWtyYWluZV1dIHRvIHRoZSBub3J0aCwgZWFzdCBhbmQgc291dGgu' );
      $this->assertEquals( str_replace( ' ', '', $op[1] ), '46B0DDA330CB057434586A52435CE43224;Insert;(587539302497374424:26a70380f78f203e27ed3db9322b2f78);JycnTW9sZG92YScnJywgb2ZmaWNpYWxseSB0aGUgJycnUmVwdWJsaWMgb2YgTW9sZG92YScnJyAoJydSZXB1YmxpY2EgTW9sZG92YScnKSBpcyBhIFtbbGFuZGxvY2tlZF1dIGNvdW50cnkgaW4gW1tsb2NhdGVkX2luOjpFdXJvcF1dLCBsb2NhdGVkIGJldHdlZW4gW1tSb21hbmlhXV0gdG8gdGhlIHdlc3QgYW5kIFtbVWtyYWluZV1dIHRvIHRoZSBub3J0aCwgZWFzdCBhbmQgc291dGgus' );

    }

    /**
     * test ApiQueryChangeSet whithout previous changeSet
     */
    public function testGetChangeSetWhithoutPreviousCS() {
    // test with no previousChangeSet
        $pageName = "ChangeSet:localhost/wiki12";
        $content = 'ChangeSet:
changeSetID: [[changeSetID::localhost/wiki12]]
inPushFeed: [[inPushFeed::PushFeed:PushCity11]]
previousChangeSet: [[previousChangeSet::none]]
 hasPatch: [[hasPatch::Patch:Berlin1]] hasPatch: [[hasPatch::Patch:Paris0]]';
        $this->p2pBot1->createPage( $pageName, $content );

        $pageName = 'PushFeed:PushCity11';
        $content = 'PushFeed:
Name: [[name::CityPush2]]
hasSemanticQuery: [[hasSemanticQuery::-5B-5BCategory:city-5D-5D]]
Pages concerned:
{{#ask: [[Category:city]]}} hasPushHead: [[hasPushHead::ChangeSet:localhost/mediawiki12]]';
        $this->p2pBot1->createPage( $pageName, $content );

        // apiQueryChangeSet call
        $cs = file_get_contents( $this->p2pBot1->bot->wikiServer . '/api.php?action=query&meta=changeSet&cspushName=PushCity11&cschangeSet=none&format=xml' );

        $dom = new DOMDocument();
        $dom->loadXML( $cs );
        $changeSet = $dom->getElementsByTagName( 'changeSet' );
        foreach ( $changeSet as $cs ) {
            if ( $cs->hasAttribute( "id" ) ) {
                $CSID = $cs->getAttribute( 'id' );
            }
        }

        $this->assertEquals( 'localhost/wiki12', strtolower( $CSID ) );

        $listePatch = $dom->getElementsByTagName( 'patch' );

        foreach ( $listePatch as $pays )
            $patch[] = $pays->firstChild->nodeValue;

        $this->assertTrue( count( $patch ) == 2 );
        $this->assertEquals( 'Patch:Berlin1', $patch[0] );
        $this->assertEquals( 'Patch:Paris0', $patch[1] );
    }

    /**
     * test apiQueryChangeSet with a previous changeSet
     */
    public function testGetChangeSetWhithPreviousCS() {
        $pageName = "ChangeSet:localhost/wiki13";
        $content = 'ChangeSet:
changeSetID: [[changeSetID::localhost/wiki13]]
inPushFeed: [[inPushFeed::PushFeed:PushCity]]
previousChangeSet: [[previousChangeSet::ChangeSet:localhost/wiki12]]
 hasPatch: [[hasPatch::Patch:Berlin2]]';
        $this->p2pBot1->createPage( $pageName, $content );

        // apiQueryChangeSet call
        $cs = file_get_contents( $this->p2pBot1->bot->wikiServer . '/api.php?action=query&meta=changeSet&cspushName=PushCity&cschangeSet=ChangeSet:localhost/wiki12&format=xml' );

        $dom = new DOMDocument();
        $dom->loadXML( $cs );

        $changeSet = $dom->getElementsByTagName( 'changeSet' );
        foreach ( $changeSet as $cs ) {
            if ( $cs->hasAttribute( "id" ) ) {
                $CSID = $cs->getAttribute( 'id' );
            }
        }

        $this->assertEquals( 'localhost/wiki13', strtolower( $CSID ) );

        $listePatch = $dom->getElementsByTagName( 'patch' );

        $patch = null;
        foreach ( $listePatch as $pays )
            $patch[] = $pays->firstChild->nodeValue;

        $this->assertTrue( count( $patch ) == 1 );
        $this->assertEquals( 'Patch:Berlin2', $patch[0] );
    }

    /**
     * test apiQueryChangeSet with an unexist changeSet
     */
    public function testGetChangeSetWhithUnexistCS() {
        $this->p2pBot1->createPage( 'toto', 'titi' );
        $cs = file_get_contents( $this->p2pBot1->bot->wikiServer . '/api.php?action=query&meta=changeSet&cspushName=PushCity&cschangeSet=ChangeSet:localhost/wiki13&format=xml' );

        $dom = new DOMDocument();
        $dom->loadXML( $cs );
        $changeSet = $dom->getElementsByTagName( 'changeSet' );
        $CSID = null;
        foreach ( $changeSet as $cs1 ) {
            if ( $cs1->hasAttribute( "id" ) ) {
                $CSID = $cs1->getAttribute( 'id' );
            }
        }

        $this->assertEquals( null, $CSID, 'failed, changeSetId must be null but ' . $CSID . ' was found' );

        $patch = null;
        $listePatch = $dom->getElementsByTagName( 'patch' );
        foreach ( $listePatch as $pays )
            $patch[] = $pays->firstChild->nodeValue;
        $this->assertEquals( null, $patch );
    }

    /**
     * test apiPatchPush with no push
     */
    public function testPatchPushed1() {
        $pageName = 'Pouxeux';

        $pushName = 'PushFeed:PushCity11';
        $content = 'PushFeed:
Name: [[name::PushFeed:PushCity11]]
hasSemanticQuery: [[hasSemanticQuery::-5B-5BCategory-3Acity-5D-5D]]
Pages concerned:
{{#ask: [[Category:city]]}}';
        $this->assertTrue( $this->p2pBot1->createPage( $pushName, $content ), 'failed to create page PushFeed:PushCity11' );

        $published = $this->getListPatchPushed( $pushName, $pageName );
        $this->assertNull( $published );

        $this->assertTrue( $this->p2pBot1->push( $pushName ), 'failed to push ' . $pushName . ' ( ' . $this->p2pBot1->bot->results . ' )' );

        $published = $this->getListPatchPushed( $pushName, $pageName );
        $this->assertNull( $published );

        $this->assertTrue( $this->p2pBot1->createPage( 'Toto', 'toto [[Category:city]]' ) );

        $this->assertTrue( $this->p2pBot1->push( $pushName ), 'failed to push ' . $pushName . ' ( ' . $this->p2pBot1->bot->results . ' )' );

        $published = $this->getListPatchPushed( $pushName, $pageName );
        $this->assertNull( $published );
    }

    /**
     *
     */
    public function testPatchPushed2() {
        $this->testPatchPushed1();

        $pageName = 'Pouxeux';
        $pushName = 'PushFeed:PushCity11';
        $this->assertTrue( $this->p2pBot1->createPage( $pageName, 'Pouxeux [[Category:city]]' ) );
        $this->assertTrue( $this->p2pBot1->push( $pushName ) );

        $published = $this->getListPatchPushed( 'PushFeed:PushCity11', $pageName );
        $this->assertTrue( count( $published ) == 1 );

        $onPage = getSemanticRequest( $this->p2pBot1->bot->wikiServer, '[[patchID::' . $published[0] . ']]', '-3FonPage' );
        $this->assertEquals( $pageName, $onPage[0], 'failed into apiPatchPush, the patch found must be on page ' . $pageName . ' but is on ' . $onPage[0] );

        $this->p2pBot1->editPage( $pageName, '....' );

        $published = $this->getListPatchPushed( $pushName, $pageName );
        $this->assertTrue( count( $published ) == 1 );

        $onPage = getSemanticRequest( $this->p2pBot1->bot->wikiServer, '[[patchID::' . $published[0] . ']]', '-3FonPage' );
        $this->assertEquals( $pageName, $onPage[0], 'failed into apiPatchPush, the patch found must be on page ' . $pageName . ' but is on ' . $onPage[0] );

        $this->assertTrue( $this->p2pBot1->push( 'PushFeed:PushCity11' ) );
        $published = $this->getListPatchPushed( $pushName, $pageName );
        $this->assertTrue( count( $published ) == 2 );

        $onPage = getSemanticRequest( $this->p2pBot1->bot->wikiServer, '[[patchID::' . $published[0] . ']]', '-3FonPage' );
        $this->assertEquals( $pageName, $onPage[0], 'failed into apiPatchPush, the patch found must be on page ' . $pageName . ' but is on ' . $onPage[0] );

        $onPage = getSemanticRequest( $this->p2pBot1->bot->wikiServer, '[[patchID::' . $published[1] . ']]', '-3FonPage' );
        $this->assertEquals( $pageName, $onPage[0], 'failed into apiPatchPush, the patch found must be on page ' . $pageName . ' but is on ' . $onPage[1] );
    }

    private function getListPatchPushed( $pushName, $pageName ) {
        $patchXML = file_get_contents( $this->p2pBot1->bot->wikiServer . '/api.php?action=query&meta=patchPushed&pppushName=' . $pushName . '&pppageName=' . $pageName . '&format=xml' );
        $dom = new DOMDocument();
        $dom->loadXML( $patchXML );
        $patchPublished = $dom->getElementsByTagName( 'patch' );
        $published = null;
        foreach ( $patchPublished as $p ) {
            $published[] = $p->firstChild->nodeValue;
        }
        return $published;
    }
}
?>
