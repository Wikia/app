<?php

if ( !defined( 'MEDIAWIKI' ) ) { define( 'MEDIAWIKI', true ); }
require_once 'p2pBot.php';
require_once 'BasicBot.php';
include_once 'p2pAssert.php';
require_once '../patch/Patch.php';
require_once '../files/utils.php';
require_once 'settings.php';

/**
 * Push-Pull functionnal test
 *
 * @author jean-philippe muller
 * @copyright INRIA-LORIA-SCORE Team
 */
class p2pTest6 extends PHPUnit_Framework_TestCase {

    var $p2pBot1;
    var $p2pBot2;
    var $wiki1 = WIKI1;
    var $wiki2 = WIKI2;

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

    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     *
     * @access protected
     */
    protected function tearDown() {
    }

    public function test1() {
        // pages creation
        // Form:author
        $pageName = 'Form:Author';
        $formauthor = '<noinclude>
This is the &quot;Author&quot; form.
To add a page with this form, enter the page name below;
if a page with that name already exists, you will be sent to a form to edit that page.


{{#forminput:Author}}

</noinclude><includeonly>
<div id=&quot;wikiPreview&quot; style=&quot;display: none; border-bottom: 1px solid #AAAAAA;&quot;></div>
{{{for template|Author}}}
{| class=&quot;formtable&quot;
! Country:
| {{{field|Country}}}
|}
{{{end template}}}

\'\'\'Free text:\'\'\'

{{{standard input|free text|rows=10}}}


{{{standard input|summary}}}

{{{standard input|minor edit}}} {{{standard input|watch}}}

{{{standard input|save}}} {{{standard input|preview}}} {{{standard input|changes}}} {{{standard input|cancel}}}
</includeonly>
[[Category:package]]';

$this->assertTrue( $this->p2pBot1->createPage( $pageName, $formauthor ),
            'Failed to create page ' . $pageName . ' (' . $this->p2pBot1->bot->results . ')' );

        // Form:book
        $pageName1 = 'Form:Book';
        $formbook = '<noinclude>
This is the &quot;Book&quot; form.
To add a page with this form, enter the page name below;
if a page with that name already exists, you will be sent to a form to edit that page.


{{#forminput:Book}}

</noinclude><includeonly>
<div id=&quot;wikiPreview&quot; style=&quot;display: none; border-bottom: 1px solid #AAAAAA;&quot;></div>
{{{for template|Book}}}
{| class=&quot;formtable&quot;
! Authors:
| {{{field|Authors}}}
|-
! Genres:
| {{{field|Genres}}}
|-
! Year:
| {{{field|Year}}}
|-
! Number of pages:
| {{{field|Number of pages}}}
|}
{{{end template}}}

\'\'\'Free text:\'\'\'

{{{standard input|free text|rows=10}}}


{{{standard input|summary}}}

{{{standard input|minor edit}}} {{{standard input|watch}}}

{{{standard input|save}}} {{{standard input|preview}}} {{{standard input|changes}}} {{{standard input|cancel}}}
</includeonly>
[[Category:package]]';

$this->assertTrue( $this->p2pBot1->createPage( $pageName1, $formbook ),
            'Failed to create page ' . $pageName1 . ' (' . $this->p2pBot1->bot->results . ')' );

        // Property:Has genre
        $pageName2 = 'Property:Has_genre';
        $hasgenre = 'This is a property of type [[Has type::String]].

The allowed values for this property are:
* [[Allows value::Art]]
* [[Allows value::Cookbook]]
* [[Allows value::Fiction]]
* [[Allows value::History]]
* [[Allows value::Poetry]]
* [[Allows value::Science]]
[[Category:package]]';

$this->assertTrue( $this->p2pBot1->createPage( $pageName2, $hasgenre ),
            'Failed to create page ' . $pageName2 . ' (' . $this->p2pBot1->bot->results . ')' );

        // Property:Has number of pages
        $pageName3 = 'Property:Has_number_of_pages';
        $nbpages = 'This is a property of type [[Has type::Number]].
[[Category:package]]';

$this->assertTrue( $this->p2pBot1->createPage( $pageName3, $nbpages ),
            'Failed to create page ' . $pageName3 . ' (' . $this->p2pBot1->bot->results . ')' );

        // Property:Is from country
        $pageName4 = 'Property:Is_from_country';
        $isfromcountry = 'This is a property of type [[Has type::String]].
[[Category:package]]';

$this->assertTrue( $this->p2pBot1->createPage( $pageName4, $isfromcountry ),
            'Failed to create page ' . $pageName4 . ' (' . $this->p2pBot1->bot->results . ')' );

        // Property:Was published in year
        $pageName5 = 'Property:Was_published_in_year';
        $pubyear = 'This is a property of type [[Has type::Number]].
[[Category:package]]';

$this->assertTrue( $this->p2pBot1->createPage( $pageName5, $pubyear ),
            'Failed to create page ' . $pageName5 . ' (' . $this->p2pBot1->bot->results . ')' );

        // Property:Was written by
        $pageName6 = 'Property:Was_written_by';
        $written = 'This is a property of type [[Has type::Page]].
[[Category:package]]
This property uses the form [[Has default form::Form:Author]].';

$this->assertTrue( $this->p2pBot1->createPage( $pageName6, $written ),
            'Failed to create page ' . $pageName6 . ' (' . $this->p2pBot1->bot->results . ')' );

        // Template:Book
//        $pageName7 = 'Template:Book';
//        $tampBook = '<noinclude>
// This is the &quot;Book&quot; template.
// It should be called in the following format:
// <pre>
// {{Book
// |Authors=
// |Genres=
// |Year=
// |Number of pages=
// }}
// </pre>
// Edit the page to see the template text.
// </noinclude><includeonly>
// {| class=&quot;wikitable&quot;
// ! Author(s)
// | {{#arraymap:{{{Authors|}}}|,|x|[[Was written by::x]]}}
// |-
// ! Genre(s)
// | {{#arraymap:{{{Genres|}}}|,|x|[[Has genre::x]]}}
// |-
// ! Year of publication
// | [[Was published in year::{{{Year|}}}]]
// |-
// ! Number of pages
// | [[Has number of pages::{{{Number of pages|}}}]]
// |}
//
// [[Category:Books]]
// </includeonly>
// [[Category:package]]
// ';
//        $this->assertTrue($this->p2pBot1->createPage($pageName7,$tampBook),
//            'Failed to create page '.$pageName7.' ('.$this->p2pBot1->bot->results.')');
//
//        //Template:Author
//        $pageName8 = 'Template:Author';
//        $tampAuthor = '<noinclude>
// This is the &quot;Author&quot; template.
// It should be called in the following format:
// <pre>
// {{Author
// |Country=
// }}
// </pre>
// Edit the page to see the template text.
// </noinclude><includeonly>
// {| class=&quot;wikitable&quot;
// ! Country of origin
// | [[Is from country::{{{Country|}}}]]
// |-
// ! Books by this author
// | {{#ask:[[Was written by::{{SUBJECTPAGENAME}}]]|format=list}}
// |}
//
// [[Category:Authors]]
// </includeonly>
// [[Category:package]]';
//
// $this->assertTrue($this->p2pBot1->createPage($pageName8,$tampAuthor),
//            'Failed to create page '.$pageName8.' ('.$this->p2pBot1->bot->results.')');


        // create push on wiki1
        $pushName = 'PushPackage';
        $pushRequest = '[[Category:package]]';
        $this->assertTrue( $this->p2pBot1->createPush( $pushName, $pushRequest ),
            'Failed to create push : ' . $pushName . ' (' . $this->p2pBot1->bot->results . ')' );

        // push on wiki1
        $this->assertTrue( $this->p2pBot1->push( 'PushFeed:' . $pushName ),
            'failed to push ' . $pushName . ' (' . $this->p2pBot2->bot->results . ')' );

        // create pull on wiki2
        $pullName = 'PullPackage';
        $this->assertTrue( $this->p2pBot2->createPull( $pullName, $this->wiki1, $pushName ),
            'failed to create pull ' . $pullName . ' (' . $this->p2pBot2->bot->results . ')' );

        // pull
        $this->assertTrue( $this->p2pBot2->Pull( 'PullFeed:' . $pullName ),
            'failed to pull ' . $pullName . ' (' . $this->p2pBot2->bot->results . ')' );

        // assert pages exist
        assertPageExist( $this->p2pBot2->bot->wikiServer, $pageName );
        assertPageExist( $this->p2pBot2->bot->wikiServer, $pageName1 );
        assertPageExist( $this->p2pBot2->bot->wikiServer, $pageName2 );
        assertPageExist( $this->p2pBot2->bot->wikiServer, $pageName3 );
        assertPageExist( $this->p2pBot2->bot->wikiServer, $pageName4 );
        assertPageExist( $this->p2pBot2->bot->wikiServer, $pageName5 );
        assertPageExist( $this->p2pBot2->bot->wikiServer, $pageName6 );
//        assertPageExist($this->p2pBot2->bot->wikiServer, $pageName7);
//        assertPageExist($this->p2pBot2->bot->wikiServer, $pageName8);


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

        // assert that wiki1/page == wiki2/page
        assertContentEquals( $this->p2pBot1->bot->wikiServer, $this->p2pBot2->bot->wikiServer, $pageName );
        assertContentEquals( $this->p2pBot1->bot->wikiServer, $this->p2pBot2->bot->wikiServer, $pageName1 );
        assertContentEquals( $this->p2pBot1->bot->wikiServer, $this->p2pBot2->bot->wikiServer, $pageName2 );
        assertContentEquals( $this->p2pBot1->bot->wikiServer, $this->p2pBot2->bot->wikiServer, $pageName3 );
        assertContentEquals( $this->p2pBot1->bot->wikiServer, $this->p2pBot2->bot->wikiServer, $pageName4 );
        assertContentEquals( $this->p2pBot1->bot->wikiServer, $this->p2pBot2->bot->wikiServer, $pageName5 );
        assertContentEquals( $this->p2pBot1->bot->wikiServer, $this->p2pBot2->bot->wikiServer, $pageName6 );
    }
}
?>
