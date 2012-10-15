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
 *
 * Description of p2pTest2
 * test tue push pull execution with a long page contain
 *
 * @author hantz
 */
class p2pTest3 extends PHPUnit_Framework_TestCase {

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
        $this->p2pBot1->updateProperies();

        $basicbot2 = new BasicBot();
        $basicbot2->wikiServer = $this->wiki2;
        $this->p2pBot2 = new p2pBot( $basicbot2 );
        $this->p2pBot2->updateProperies();
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

    public function testSimple() {

        $this->p2pBot1->createPage( 'Moldova',
            'Moldova en-us-Moldova.ogg /mɒlˈdoʊvə/ (help·info), officially the Republic of Moldova (Republica Moldova) is a landlocked country in Eastern Europe, located between Romania to the west and Ukraine to the north, east and south.

In the Middle Ages, most of the present territory of Moldova was part of the Principality of Moldavia. In 1812, it was annexed by the Russian Empire, and became known as Bessarabia. Between 1856 and 1878, the southern part was returned to Moldavia. In 1859 it united with Wallachia to form modern Romania.

Upon the dissolution of the Russian Empire in 1917, an autonomous, then-independent Moldavian Democratic Republic was formed, which joined Romania in 1918. In 1940, Bessarabia was occupied by the Soviet Union and was split between the Ukrainian SSR and the newly created Moldavian SSR.

After changing hands in 1941 and 1944 during World War II, the territory of the modern country was subsumed by the Soviet Union until its declaration of independence on August 27, 1991. Moldova was admitted to the UN in March 1992.

In September 1990, a breakaway government was formed in Transnistria, a strip of Moldavian SSR on the east bank of the river Dniester. After a brief war in 1992, it became de facto independent, although no UN member has recognized its independence.

The country is a parliamentary democracy with a president as head of state and a prime minister as head of government. Moldova is a member state of the United Nations, Council of Europe, WTO, OSCE, GUAM, CIS, BSEC and other international organizations. Moldova currently aspires to join the European Union,[4] and has implemented the first three-year Action Plan within the framework of the European Neighbourhood Policy (ENP).[5] About a quarter of the population lives on less than US$ 2 a day.' );

        $this->p2pBot1->createPush( 'PushPage_Moldova', '[[Moldova]]' );
        $this->p2pBot1->push( 'PushFeed:PushPage_Moldova' );

        $this->p2pBot2->createPull( 'PullMoldova', $this->p2pBot1->bot->wikiServer, 'PushPage_Moldova' );
        $this->p2pBot2->pull( 'PullFeed:PullMoldova' );

        // assert that there is the same changeSet on the 2 wikis
         $CSonWiki1 = getSemanticRequest( $this->p2pBot1->bot->wikiServer, '[[ChangeSet:+]][[inPushFeed::PushFeed:PushPage_Moldova]]', '-3FchangeSetID' );
        $CSonWiki2 = getSemanticRequest( $this->p2pBot2->bot->wikiServer, '[[ChangeSet:+]][[inPullFeed::PullFeed:PullMoldova]]', '-3FchangeSetID' );
        $this->assertEquals( $CSonWiki1, $CSonWiki2, 'changeSet are not equals on the 2 wikis' );

        // assert that there is the same patch on the 2 wikis
        $PatchonWiki1 = getSemanticRequest( $this->p2pBot1->bot->wikiServer, '[[Patch:+]][[onPage::Moldova]]', '-3FpatchID' );
        $PatchonWiki2 = getSemanticRequest( $this->p2pBot2->bot->wikiServer, '[[Patch:+]][[onPage::Moldova]]', '-3FpatchID' );
        $PatchonWiki1 = arraytolower( $PatchonWiki1 );
        $PatchonWiki2 = arraytolower( $PatchonWiki2 );
        $this->assertEquals( $PatchonWiki1, $PatchonWiki2, 'patch are not equals on the 2 wikis' );
        // assert that wiki1/Moldova == wiki2/Moldova
        assertContentEquals( $this->p2pBot1->bot->wikiServer, $this->p2pBot2->bot->wikiServer, 'Moldova' );
    }

    public function testSimple2() {
        $text = "DSMW implements the Logoot algorithm (see [[Presentation_and_Papers|Papers and presentations]]).
This algorithm allows automatic resolution of edition conflicts.

What we call \"conflict\" is when there is a concurrent editing on an article i.e. the same article has been modified by many users. For instance, this is the case when a user  edits her local copy of a page and pulls remote modifications on this page.

==Summary==


In the following table, we summarize the different cases of concurrent editing and the result produced by the merge algorithm.
The first column presents the content of the  '''initial state''' of the page.
'''DSMW server1''' and '''DSMW server2''' represent two concurrent modifications on the same initial state.
'''Results''' is the convergent state i.e. the state that will reached on all servers after complete propagation of concurrent changes...


{|  border='1' cellpadding='5' cellspacing='0'
|   valign='top' |  Scenario
|   valign='top' |  Initial state
|   valign='top' |  DSMW server1
|   valign='top' |  DSMW server2
|   valign='top' |  Results
|   valign='top' |  Comments
<div class='vspace'></div>
|-
|   valign='top' |   Insert/Insert at different lines
|   valign='top' |  initial_line
|   valign='top' | <span  style='color: red;'>inserted_line1 <br clear='all' /></span><span  style='color: black;'>initial_line </span>
|   valign='top' | <span  style='color: black;'>initial_line <br clear='all' /></span><span  style='color: green;'>inserted_line2 </span>
|   valign='top' | <span  style='color: red;'>inserted_line1 <br clear='all' /></span><span  style='color: black;'>initial_line <br clear='all' /></span><span  style='color: green;'>inserted_line2 </span>
|   valign='top' | <ul><li>DSMW server1 inserts a line before the initial line and DSMW server2 inserts a line after the initial line
</li></ul><div class='vspace'></div>
|-
|   valign='top' |  Ins/ins the same line
|   valign='top' |  initial_line1 <br clear='all' /> initial_line2
|   valign='top' |  initial_line1 <br clear='all' /><span  style='color: red;'>inserted_line1 <br clear='all' /></span><span  style='color: black;'>initial_line2 </span>
|   valign='top' |  initial_line1 <br clear='all' /><span  style='color: green;'>inserted_line2 <br clear='all' /></span><span  style='color: black;'>initial_line2 </span>
|   valign='top' | <ul><li>initial_line1 <br clear='all' /><span  style='color: red;'>inserted_line1 <br clear='all' /></span><span  style='color: green;'>inserted_line2 <br clear='all' /></span><span  style='color: black;'>initial_line2 </span></li></ul><p>or
</p><ul><li>initial_line1 <br clear='all' /><span  style='color: green;'>inserted_line2  <br clear='all' /></span><span  style='color: red;'>inserted_line1 <br clear='all' /></span><span  style='color: black;'>initial_line2 </span></li></ul>
|   valign='top' | <ul><li>DSMW server1 and 2 insert a different line between the initial lines
</li></ul><div class='vspace'></div>
|-
|   valign='top' | update/update the same line
|   valign='top' |  XXX
|   valign='top' |  XX<span  style='color: red;'>Y </span>
|   valign='top' |  XX<span  style='color: green;'>Z </span>
|   valign='top' | <ul><li>XX<span  style='color: red;'>Y <br clear='all' /></span><span  style='color: black;'>XX</span><span  style='color: green;'>Z </span></li></ul><p>or
</p><ul><li><span  style='color: black;'>XX</span><span  style='color: green;'>Z <br clear='all' /></span><span  style='color: black;'>XX</span><span  style='color: red;'>Y </span></li></ul>
|   valign='top' | <ul><li>DSMW server1 and 2 update the initial line with a different letter
</li><li>There is no update operation in DSMW, update is equivalent to delete old line and insert a new one with the new content
</li><li>The *or* does not means that we can have one value in one site and another in another site. Logoot will decide the convergent state by choosing one solution
</li></ul><div class='vspace'></div>
|-
|   valign='top' |  update/delete same line
|   valign='top' |  XXX
|   valign='top' |  XX<span  style='color: red;'>Y </span>
|   valign='top' | <span  style='color: red;'><em><del>line deleted</del></em></span>
|   valign='top' |  XX<span  style='color: red;'>Y </span>
|   valign='top' | <ul><li>DSMW server1 updates the initial line and DSMW server2 deletes the initial line
</li></ul><div class='vspace'></div>
|-
|   valign='top' |  Del/Del the same line
|   valign='top' |  initial_line
|   valign='top' | <span  style='color: red;'><em><del>line deleted</del></em></span>
|   valign='top' | <span  style='c/home/mullejea/Bureau/www/mediawiki-1.14.0/extensions/DSMW/tests/p2pTest3.php:258olor: red;'><em><del>line deleted</del></em></span>
|   valign='top' | <span  style='color: red;'><em><del>line deleted</del></em></span>
|   valign='top' | <ul><li>DSMW server1 and server2 delete the “initial_line”
</li></ul>
|}

[[Category:DSMWDocumentation]]
";
        $text1 = "* DSMW2 will subscribe to the DSMW1 push feed. Go to the and tp '''DSMW Admin functions'''  on the '''special pages''' and click on '''[ADD]''' beside   PULL. This leads to the following form:


[[Image:2-1addpull1.png]]


* Complete this form with the Server URL, the PushFeed name (informations received from DSMW1 user) and the PullFeed name. In this tutorial, the server URL is: \"http://localhost/wiki1\", the PushFeed Name is: \"PushTutorial\" and the  PullFeedName is \"PullTutorial\" as showing below:

Note that the PullFeed name is free, we use this one only for the example.


[[Image:2-2addpull1.png]]
----
'''''Since DSMW-0.6, this page has been modified and has the layout represented by the image below'''''

[[Image:pullpagecreation.png]]
----


'''Important:''' the PushFeed name is case sensitive, if you do not respect that  (and you will not get the expected informations).

* Click on the '''ADD''' button to create  the PullFeed \"PullTutorial\".


[[Image:pulltutorial2.png]]


Note that we could \"pull\" the informations directly in this page, but we will use Administration page, so follow the link '''Special:ArticleAdminPage''' under the \"PULL\" button.

Remark: We pull from the DSMW Administration page because we wanted to show you that you can see more informations on this page (and that you could pull more than one pullFeed, if they were more than one...).


[[Image:2-4adminpage.png]]


If you want to see how many patches are available on remote server  click on \"'''[Display]'''\" and the pullfeed table will appear like this:


[[Image:2-4-1adminpage.png]]


* Select the PullFeed you have just created by check the checkbox and click on the '''PULL''' button. A ChangeSet page that  recapitulates the \"pulled\" informations (including the identifier of patches) is created.


[[Image:changeset2.png]]


* Now the \"pull\" procedure is completed on DSMW2, you should have the 2 articles \"Hello\" and \"World\" on DSMW2. Let's check it...

Write \"Hello\" in the search box and click on the button \"go\".


[[Image:2-6hellopage.png]]


...and...


[[Image:2-8worldpage.png]]


* Let us take a look to the Administration tab informations:


[[Image:DSMWonHello2b.png]]


...and...


[[Image:DSMWonWorld2.png]]


'''Remark: '''we have  the right informations, a  grey tinted patch means that a remote patch has been locally integrated.

We have the right informations because we made one modifications on Hello that are 2 insertions and one modification with 4 inserts.

* Let us take a look to the \"DSMW Admin functions\" page informations:


[[Image:2-10adminpage.png]]


The informations are updated!  You can  display remote patches:


[[Image:2-10-1adminpage.png]]


''Congratulations, you finished the first execution scenario with DSMW. Now you can enjoy playing with DSMW. If you want to learn more about the using of DSMW see the different [[DSMW User Manual|documentations]]''.

[[Category:DSMWDocumentation]]
";

        $this->assertTrue( $this->p2pBot1->createPage( 'Conflict_Management1', $text ) );
        $this->p2pBot1->createPage( 'Subscription_Procedure1', $text1 );
        $this->p2pBot1->createPush( 'PushDSMWDoc1', '[[Category:DSMWDocumentation]]' );
        $this->p2pBot1->push( 'PushFeed:PushDSMWDoc1' );

        $this->p2pBot2->createPull( 'PullDSMWDoc1', $this->p2pBot1->bot->wikiServer, 'PushDSMWDoc1' );
        $this->p2pBot2->pull( 'PullFeed:PullDSMWDoc1' );

        // assert that there is the same changeSet on the 2 wikis
         $CSonWiki1 = getSemanticRequest( $this->p2pBot1->bot->wikiServer, '[[ChangeSet:+]][[inPushFeed::PushFeed:PushDSMWDoc1]]', '-3FchangeSetID' );
        $CSonWiki2 = getSemanticRequest( $this->p2pBot2->bot->wikiServer, '[[ChangeSet:+]][[inPullFeed::PullFeed:PullDSMWDoc1]]', '-3FchangeSetID' );
        $this->assertEquals( $CSonWiki1, $CSonWiki2, 'changeSet are not equals on the 2 wikis' );

        // assert that there is the same patch on the 2 wikis
        $PatchonWiki1 = getSemanticRequest( $this->p2pBot1->bot->wikiServer, '[[Patch:+]][[onPage::Conflict_Management1]]', '-3FpatchID' );
        $PatchonWiki2 = getSemanticRequest( $this->p2pBot2->bot->wikiServer, '[[Patch:+]][[onPage::Conflict_Management1]]', '-3FpatchID' );
        $PatchonWiki1 = arraytolower( $PatchonWiki1 );
        $PatchonWiki2 = arraytolower( $PatchonWiki2 );
        $this->assertEquals( $PatchonWiki1, $PatchonWiki2, 'patch are not equals on the 2 wikis' );
        $PatchonWiki3 = getSemanticRequest( $this->p2pBot1->bot->wikiServer, '[[Patch:+]][[onPage::Subscription_Procedure1]]', '-3FpatchID' );
        $PatchonWiki4 = getSemanticRequest( $this->p2pBot2->bot->wikiServer, '[[Patch:+]][[onPage::Subscription_Procedure1]]', '-3FpatchID' );
        $PatchonWiki3 = arraytolower( $PatchonWiki3 );
        $PatchonWiki4 = arraytolower( $PatchonWiki4 );
        $this->assertEquals( $PatchonWiki3, $PatchonWiki4, 'patch are not equals on the 2 wikis' );

        assertContentEquals( $this->p2pBot1->bot->wikiServer, $this->p2pBot2->bot->wikiServer, 'Conflict_Management1' );
        assertContentEquals( $this->p2pBot1->bot->wikiServer, $this->p2pBot2->bot->wikiServer, 'Subscription_Procedure1' );
    }
}
?>
