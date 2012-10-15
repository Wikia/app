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
 * Description of p2pAttachmentTest1
 *
 * @author Émile Morel
 */


class p2pTest10 extends PHPUnit_Framework_TestCase {

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
    var $content = "Les ours (ou ursinés, du latin ŭrsus, de même sens) sont de grands
mammifères plantigrades appartenant à la famille des ursidés. Il
n'existe que huit espèces d'ours vivants, mais ils sont largement
répandus et apparaissent dans une grande variété d'habitats, aussi
bien dans l'hémisphère nord qu'une partie de l'hémisphère sud. Les
ours vivent dans les continents d'Europe, d'Amérique du Nord,
d'Amérique du Sud, et en Asie.
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

        // je ne sais pas pourquoi mais il faut initialiser les 3 wiki sinon
        // on a un "Unable to connect" (en tous cas chez moi)
        $this->p2pBot1->createPage( "init", "test" );
        $this->p2pBot2->createPage( "init", "test" );
        $this->p2pBot3->createPage( "init", "test" );
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
     * Create one page, push it
     */
    public function testSimple1() {
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
    }

    /**
     * Create one page, push it
     * pull it on wiki2 and on wiki3
     * modify the page on wiki2 and wiki3
     * pull both on wiki1
     * wiki1 must have the good page on local
     */
     public function testSimple2() {
        $this->testSimple1();

        // create pull on wiki2
        $this->assertTrue( $this->p2pBot2->createPull( $this->pullName, $this->wiki1, $this->pushName ),
                'failed to create pull ' . $this->pullName . ' (' . $this->p2pBot2->bot->results . ')' );

        // pull
        $this->assertTrue( $this->p2pBot2->Pull( $this->pullFeed ),
                'failed to pull ' . $this->pullFeed . ' (' . $this->p2pBot2->bot->results . ')' );

        // assert page Ours exist on wiki2
        assertPageExist( $this->p2pBot2->bot->wikiServer, $this->pageName );

        // create pull on wiki3
        $this->assertTrue( $this->p2pBot3->createPull( $this->pullName, $this->wiki1, $this->pushName ),
                'failed to create pull ' . $this->pullName . ' (' . $this->p2pBot3->bot->results . ')' );

        // pull
        $this->assertTrue( $this->p2pBot3->Pull( $this->pullFeed ),
                'failed to pull ' . $this->pullFeed . ' (' . $this->p2pBot3->bot->results . ')' );

        // assert page Ours exist on wiki3
        assertPageExist( $this->p2pBot3->bot->wikiServer, $this->pageName );




        $addContent2 = "Les caractéristiques communes des ours modernes
sont un grand corps trapu et massif, un long museau,
un pelage hirsutes, des pattes plantigrades à cinq griffes
non rétractiles, et une queue courte.";

        $this->assertTrue( $this->p2pBot2->editPage( $this->pageName, $addContent2 ),
                'failed to edit page ' . $this->pageName );

        // create push on wiki2
        $this->assertTrue( $this->p2pBot2->createPush( $this->pushName, $this->pushRequest ),
                'Failed to create push : ' . $this->pushName . ' (' . $this->p2pBot2->bot->results . ')' );

        // push
        $this->assertTrue( $this->p2pBot2->push( $this->pushFeed ),
                'failed to push ' . $this->pushFeed . ' (' . $this->p2pBot2->bot->results . ')' );

        $addContent3 = "L'ours polaire est principalement carnivore
et le panda géant se nourrit presque exclusivement de bambou,
les six autres espèces sont omnivores, leur alimentation variée
comprend essentiellement des plantes et des animaux.";

        $this->assertTrue( $this->p2pBot3->editPage( $this->pageName, $addContent3 ),
                'failed to edit page ' . $this->pageName );

        // create push on wiki3
        $this->assertTrue( $this->p2pBot3->createPush( $this->pushName, $this->pushRequest ),
                'Failed to create push : ' . $this->pushName . ' (' . $this->p2pBot3->bot->results . ')' );

        // push
        $this->assertTrue( $this->p2pBot3->push( $this->pushFeed ),
                'failed to push ' . $this->pushFeed . ' (' . $this->p2pBot3->bot->results . ')' );




        // create pull on wiki1 from wiki2
        $this->assertTrue( $this->p2pBot1->createPull( $this->pullName . '2', $this->wiki2, $this->pushName ),
                'failed to create pull ' . $this->pullName . ' (' . $this->p2pBot1->bot->results . ')' );

        // pull
        $this->assertTrue( $this->p2pBot1->Pull( $this->pullFeed . '2' ),
                'failed to pull ' . $this->pullFeed . ' (' . $this->p2pBot1->bot->results . ')' );

        // create pull on wiki1 from wiki3
        $this->assertTrue( $this->p2pBot1->createPull( $this->pullName . '3', $this->wiki3, $this->pushName ),
                'failed to create pull ' . $this->pullName . ' (' . $this->p2pBot1->bot->results . ')' );

        // pull
        $this->assertTrue( $this->p2pBot1->Pull( $this->pullFeed . '3' ),
                'failed to pull ' . $this->pullFeed . ' (' . $this->p2pBot1->bot->results . ')' );

        $PatchonWiki1 = getSemanticRequest( $this->p2pBot1->bot->wikiServer, '[[Patch:+]][[onPage::' . $this->pageName . ']]', '-3FpatchID' );
        $PatchonWiki1 = arraytolower( $PatchonWiki1 );
        $this->assertEquals( count( $PatchonWiki1 ), 3 );
    }
}

?>
