<?php

if ( !defined( 'MEDIAWIKI' ) ) { define( 'MEDIAWIKI', true ); }
require_once 'p2pBot.php';
require_once 'BasicBot.php';
include_once 'p2pAssert.php';
require_once 'settings.php';

 /*
 * Description of p2pTest5
 *
 * @author jean-philippe muller
 * @copyright INRIA-LORIA-SCORE Team
 */
class p2pTest5 extends PHPUnit_Framework_TestCase {

    var $p2pBot1;
    var $wiki1 = WIKI1;

    /**
     *
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
    }

/**
 * Main_Page and UNTITLED pages are created before the installation of DSMW
 * so this test focuses on these pages.
 * First we test that these articles aren't editable (they should not)
 * Than we execute the "Articles update" feature
 * And we test if these articles are now editable (they should)
 */

    public function testDSMWPagesUpdateFunction() {


       // edit Main_Page on wiki1
        $this->assertFalse( $this->p2pBot1->editPage( 'Main_Page', 'edition test' ),
            'succeeded to edit page Main_Page ( ' . $this->p2pBot1->bot->results . ' )' );

        // edit UNTITLED on wiki1
        $this->assertFalse( $this->p2pBot1->editPage( 'UNTITLED', 'edition test' ),
            'succeeded to edit page UNTITLED ( ' . $this->p2pBot1->bot->results . ' )' );

        // perform the "articles update" feature
        $this->assertTrue( $this->p2pBot1->articlesUpdate() );


        // edit Main_Page on wiki1
        $this->assertTrue( $this->p2pBot1->editPage( 'Main_Page', 'another edition test' ),
            'failed to edit page Main_Page ( ' . $this->p2pBot1->bot->results . ' )' );

        // edit UNTITLED on wiki1
        $this->assertTrue( $this->p2pBot1->editPage( 'UNTITLED', 'another edition test' ),
            'failed to edit page UNTITLED ( ' . $this->p2pBot1->bot->results . ' )' );

    }

    /**
     * On this test we import articles (with the mediawiki import procedure)
     * exported from Wikipedia (9 articles). The Mediawiki import procedure
     * creates pages locally without passing through the DSMW algorithm, so they
     * aren't immediatly editable.
     * First we test that these articles aren't editable (they should not)
     * Than we execute the "Articles update" feature
     * And we test if these articles are now editable (they should)
     */
    public function testDSMWPagesUpdateFunction1() {
        // import procedure
        $this->assertTrue( $this->p2pBot1->importXML( 'Import/Wikipedia-20091119095555.xml' ) );

        // edit Server_push on wiki1
        // $this->assertFalse($this->p2pBot1->editPage('Server_push', 'edition test'),
        //    'succeeded to edit page Server_push ( '.$this->p2pBot1->bot->results.' )');

        // edit WAI-ARIA on wiki1
        $this->assertFalse( $this->p2pBot1->editPage( 'WAI-ARIA', 'edition test' ),
            'succeeded to edit page WAI-ARIA ( ' . $this->p2pBot1->bot->results . ' )' );

        // edit AxsJAX on wiki1
        $this->assertFalse( $this->p2pBot1->editPage( 'AxsJAX', 'edition test' ),
            'succeeded to edit page AxsJAX ( ' . $this->p2pBot1->bot->results . ' )' );

        // edit Asynchronous_JavaScript_and_XML on wiki1
        $this->assertFalse( $this->p2pBot1->editPage( 'Asynchronous_JavaScript_and_XML', 'edition test' ),
            'succeeded to edit page Asynchronous_JavaScript_and_XML ( ' . $this->p2pBot1->bot->results . ' )' );

        // edit Archetype_JavaScript_Framework on wiki1
        $this->assertFalse( $this->p2pBot1->editPage( 'Archetype_JavaScript_Framework', 'edition test' ),
            'succeeded to edit page Archetype_JavaScript_Framework ( ' . $this->p2pBot1->bot->results . ' )' );

        // edit XMLHttpRequest on wiki1
        $this->assertFalse( $this->p2pBot1->editPage( 'XMLHttpRequest', 'edition test' ),
            'succeeded to edit page XMLHttpRequest ( ' . $this->p2pBot1->bot->results . ' )' );

        // edit ZK_(informatique) on wiki1
        $this->assertFalse( $this->p2pBot1->editPage( 'ZK_(informatique)', 'edition test' ),
            'succeeded to edit page ZK_(informatique) ( ' . $this->p2pBot1->bot->results . ' )' );

        // edit JMaki on wiki1
        $this->assertFalse( $this->p2pBot1->editPage( 'JMaki', 'edition test' ),
            'succeeded to edit page JMaki ( ' . $this->p2pBot1->bot->results . ' )' );

        // edit Google_Web_Toolkit on wiki1
        // $this->assertFalse($this->p2pBot1->editPage('Google_Web_Toolkit', 'edition test'),
        //    'succeeded to edit page Google_Web_Toolkit ( '.$this->p2pBot1->bot->results.' )');

        // perform the "articles update" feature
        $this->assertTrue( $this->p2pBot1->articlesUpdate() );


        // edit Server_push on wiki1
        // $this->assertTrue($this->p2pBot1->editPage('Server_push', 'another edition test'),
        //   'failed to edit page Server_push ( '.$this->p2pBot1->bot->results.' )');

        // edit WAI-ARIA on wiki1
        $this->assertTrue( $this->p2pBot1->editPage( 'WAI-ARIA', 'another edition test' ),
            'failed to edit page WAI-ARIA ( ' . $this->p2pBot1->bot->results . ' )' );

        // edit AxsJAX on wiki1
        $this->assertTrue( $this->p2pBot1->editPage( 'AxsJAX', 'another edition test' ),
            'failed to edit page AxsJAX ( ' . $this->p2pBot1->bot->results . ' )' );

        // edit Asynchronous_JavaScript_and_XML on wiki1
        $this->assertTrue( $this->p2pBot1->editPage( 'Asynchronous_JavaScript_and_XML', 'another edition test' ),
            'failed to edit page Asynchronous_JavaScript_and_XML ( ' . $this->p2pBot1->bot->results . ' )' );

        // edit Archetype_JavaScript_Framework on wiki1
        $this->assertTrue( $this->p2pBot1->editPage( 'Archetype_JavaScript_Framework', 'another edition test' ),
            'failed to edit page Archetype_JavaScript_Framework ( ' . $this->p2pBot1->bot->results . ' )' );

        // edit XMLHttpRequest on wiki1
        $this->assertTrue( $this->p2pBot1->editPage( 'XMLHttpRequest', 'another edition test' ),
            'failed to edit page XMLHttpRequest ( ' . $this->p2pBot1->bot->results . ' )' );

        // edit ZK_(informatique) on wiki1
        $this->assertTrue( $this->p2pBot1->editPage( 'ZK_(informatique)', 'another edition test' ),
            'failed to edit page ZK_(informatique) ( ' . $this->p2pBot1->bot->results . ' )' );

        // edit JMaki on wiki1
        $this->assertTrue( $this->p2pBot1->editPage( 'JMaki', 'another edition test' ),
            'failed to edit page JMaki ( ' . $this->p2pBot1->bot->results . ' )' );

        // edit Google_Web_Toolkit on wiki1
        // $this->assertTrue($this->p2pBot1->editPage('Google_Web_Toolkit', 'another edition test'),
        //    'failed to edit page Google_Web_Toolkit ( '.$this->p2pBot1->bot->results.' )');

    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     *
     * @access protected
     */
    protected function tearDown() {

    }
}
?>
