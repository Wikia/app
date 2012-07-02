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
 * Description of p2pTest2
 *
 * @author hantz
 */
class p2pTest2 extends PHPUnit_Framework_TestCase {

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

    public function testSimple() {
    // wiki1 = prof1
    // wiki2 = prof2
    // wiki3 = student

    // create page on wiki1
        $pageNameLesson1 = 'Lesson1';
        $this->assertTrue( $this->p2pBot1->createPage( $pageNameLesson1, 'Intro.... [[type::Lesson]][[forYear::2009]]' ),
            'Failed to create page Exercises1 (' . $this->p2pBot1->bot->results . ')' );
        $contentWiki1 = "test wiki1";
        echo sleep( 10 );

        $this->p2pBot1->editPage( $pageNameLesson1, $contentWiki1 );
        $this->assertTrue( $this->p2pBot1->createPage( 'Exercises1', 'content exercises1 [[forYear::2009]] [[type::Exercise]]' ),
            'Failed to create page Exercises1 (' . $this->p2pBot1->bot->results . ')' );
        $this->assertTrue( $this->p2pBot1->createPage( 'Exam1', 'content exam1 [[forYear::2009]] [[type::Exam]]' ),
            'Failed to create page Exercises1 (' . $this->p2pBot1->bot->results . ')' );

        $pageContentLesson1 = getContentPage( $this->p2pBot1->bot->wikiServer, $pageNameLesson1 );
        // push on wiki1 for prof2, only the lesson
        $this->assertTrue( $this->p2pBot1->createPush( 'Course1', '[[type::Lesson]][[forYear::2009]]' ),
            'Failed to create push : Course1 (' . $this->p2pBot1->bot->results . ')' );
        $this->assertTrue( $this->p2pBot1->push( 'PushFeed:Course1' ),
            'failed to push ' . 'Course1' . ' (' . $this->p2pBot1->bot->results . ')' );

        // pull on wiki2 from prof1 push
        $this->assertTrue( $this->p2pBot2->createPull( 'Prof1Course1', $this->p2pBot1->bot->wikiServer, 'Course1' ),
            'failed to create pull Prof1Course1 (' . $this->p2pBot2->bot->results . ')' );
        // sleep(10);
        $this->assertTrue( $this->p2pBot2->Pull( 'PullFeed:Prof1Course1' ),
            'failed to pull Prof1Course1 (' . $this->p2pBot2->bot->results . ')' );

        assertPageExist( $this->p2pBot2->bot->wikiServer, 'Lesson1' );
        assertContentEquals( $this->p2pBot2->bot->wikiServer, $this->p2pBot1->bot->wikiServer, $pageNameLesson1 );

        // edit page lesson1 on wiki2
        $addContent1 = 'edition on wiki2';
        $this->p2pBot2->editPage( $pageNameLesson1, $addContent1 );
        $pageContentLesson1 = getContentPage( $this->p2pBot2->bot->wikiServer, $pageNameLesson1 );

        // push on wiki2 for prof1 only the lesson
        $this->assertTrue( $this->p2pBot2->createPush( 'Course1', '[[type::Lesson]][[forYear::2009]]' ),
            'Failed to create push : Course1 (' . $this->p2pBot2->bot->results . ')' );
        $this->assertTrue( $this->p2pBot2->push( 'PushFeed:Course1' ),
            'failed to push S1Course1 (' . $this->p2pBot2->bot->results . ')' );

        // pull on wiki1 from prof2 push
        $this->assertTrue( $this->p2pBot1->createPull( 'Prof2Course1', $this->p2pBot2->bot->wikiServer, 'Course1' ),
            'failed to create pull Prof2Course1 (' . $this->p2pBot1->bot->results . ')' );
        $this->assertTrue( $this->p2pBot1->Pull( 'PullFeed:Prof2Course1' ),
            'failed to pull Prof2Course1 (' . $this->p2pBot1->bot->results . ')' );

        assertPageExist( $this->p2pBot1->bot->wikiServer, 'Lesson1' );
        assertContentEquals( $this->p2pBot1->bot->wikiServer, $this->p2pBot2->bot->wikiServer, $pageNameLesson1 );

        // push on wiki1 for student, lessons and exercises
        $this->assertTrue( $this->p2pBot1->createPush( 'S1Course1', '[[type::!Exam]][[forYear::2009]]' ),
            'Failed to create push : S1Course1 (' . $this->p2pBot1->bot->results . ')' );
        $this->assertTrue( $this->p2pBot1->push( 'PushFeed:S1Course1' ),
            'failed to push S1Course1 (' . $this->p2pBot2->bot->results . ')' );

        // pull on wiki3 from prof1
        $this->assertTrue( $this->p2pBot3->createPull( 'Prof1Course1', $this->p2pBot1->bot->wikiServer, 'S1Course1' ),
            'failed to create pull Prof1Course1 (' . $this->p2pBot3->bot->results . ')' );
        $this->assertTrue( $this->p2pBot3->Pull( 'PullFeed:Prof1Course1' ),
            'failed to pull Prof2Course1 (' . $this->p2pBot3->bot->results . ')' );

        assertPageExist( $this->p2pBot3->bot->wikiServer, 'Lesson1' );
        assertContentEquals( $this->p2pBot3->bot->wikiServer, $this->p2pBot1->bot->wikiServer, $pageNameLesson1 );

        assertPageExist( $this->p2pBot3->bot->wikiServer, 'Exercises1' );
        assertContentEquals( $this->p2pBot3->bot->wikiServer, $this->p2pBot1->bot->wikiServer, 'Exercises1' );

        // edit page lesson1 on wiki3
        // $this->p2pBot3->bot->wikiLogin();
        $addContent = 'content from student';
        $this->assertTrue( $this->p2pBot3->editPage( 'Lesson1', $addContent ),
            'failed to edit page Lesson1' );
        $pageContentLesson1 = getContentPage( $this->p2pBot3->bot->wikiServer, $pageNameLesson1 );

        // push on wiki3 for prof1, lessons and exercises
        $this->assertTrue( $this->p2pBot3->createPush( 'StudCourse1', '[[type::!Exam]][[forYear::2009]]' ),
            'failed to create push : StudCourse1 (' . $this->p2pBot3->bot->results . ')' );
        $this->assertTrue( $this->p2pBot3->push( 'PushFeed:StudCourse1' ),
            'failed to push StudCourse1 (' . $this->p2pBot3->bot->results . ')' );

        // pull on wiki1 from student
        $this->assertTrue( $this->p2pBot1->createPull( 'StudCourse1', $this->p2pBot3->bot->wikiServer, 'StudCourse1' ),
            'failed to create pull StudCourse1 (' . $this->p2pBot1->bot->results . ')' );
        $this->assertTrue( $this->p2pBot1->Pull( 'PullFeed:StudCourse1' ),
            'failed to pull StudCourse1 (' . $this->p2pBot1->bot->results . ')' );

        assertContentEquals( $this->p2pBot1->bot->wikiServer, $this->p2pBot3->bot->wikiServer, $pageNameLesson1 );

    }

//    public function testTemp() {
//    //wiki1 = prof1
//    //wiki2 = prof2
//    //wiki3 = student
//
//    //create page on wiki1
//        $pageNameLesson1 = 'Lesson1';
//        $this->assertTrue($this->p2pBot1->createPage($pageNameLesson1,'Intro.... [[type::Lesson]][[forYear::2009]]'),
//            'Failed to create page Exercises1 ('.$this->p2pBot1->bot->results.')');
//        $this->assertTrue($this->p2pBot1->createPage('Exercises1','content exercises1 [[forYear::2009]] [[type::Exercise]]'),
//            'Failed to create page Exercises1 ('.$this->p2pBot1->bot->results.')');
//        $this->assertTrue($this->p2pBot1->createPage('Exam1','content exam1 [[forYear::2009]] [[type::Exam]]'),
//            'Failed to create page Exercises1 ('.$this->p2pBot1->bot->results.')');
//
//        $pageContentLesson1 = getContentPage($this->p2pBot1->bot->wikiServer, $pageNameLesson1);
//        //push on wiki1 for prof2, only the lesson
//        $this->assertTrue($this->p2pBot1->createPush('Course1', '[[type::Lesson]][[forYear::2009]]'),
//            'Failed to create push : Course1 ('.$this->p2pBot1->bot->results.')');
//        $this->assertTrue($this->p2pBot1->push('PushFeed:Course1'),
//            'failed to push '.$pushName.' ('.$this->p2pBot1->bot->results.')');
//
//        //pull on wiki2 from prof1 push
//        $this->assertTrue($this->p2pBot2->createPull('Prof1Course1',$this->p2pBot1->bot->wikiServer, 'Course1'),
//            'failed to create pull Prof1Course1 ('.$this->p2pBot2->bot->results.')');
//        $this->assertTrue($this->p2pBot2->Pull('PullFeed:Prof1Course1'),
//            'failed to pull Prof1Course1 ('.$this->p2pBot2->bot->results.')');
//
//        assertPageExist($this->p2pBot2->bot->wikiServer, 'Lesson1');
//        assertContentEquals($this->p2pBot2->bot->wikiServer,$this->p2pBot1->bot->wikiServer, $pageNameLesson1);
//
//        //edit page lesson1 on wiki2
//        $addContent = '
// This mode is based on divergence......';
//        $this->p2pBot2->editPage($pageNameLesson1, $addContent);
//        $pageContentLesson1 = getContentPage($this->p2pBot2->bot->wikiServer, $pageNameLesson1);
//
//        //push on wiki2 for prof1 only the lesson
//        $this->assertTrue($this->p2pBot2->createPush('Course1', '[[type::Lesson]][[forYear::2009]]'),
//            'Failed to create push : Course1 ('.$this->p2pBot2->bot->results.')');
//        $this->assertTrue($this->p2pBot2->push('PushFeed:Course1'),
//            'failed to push S1Course1 ('.$this->p2pBot2->bot->results.')');
//
/// /        //pull on wiki1 from prof2 push
/// /        $this->assertTrue($this->p2pBot1->createPull('Prof2Course1',$this->p2pBot2->bot->wikiServer, 'Course1'),
/// /            'failed to create pull Prof2Course1 ('.$this->p2pBot1->bot->results.')');
/// /        $this->assertTrue($this->p2pBot1->Pull('PullFeed:Prof2Course1'),
/// /            'failed to pull Prof2Course1 ('.$this->p2pBot1->bot->results.')');
/// /
/// /        assertPageExist($this->p2pBot1->bot->wikiServer, 'Lesson1');
/// /        assertContentEquals($this->p2pBot1->bot->wikiServer,$this->p2pBot2->bot->wikiServer, $pageNameLesson1);
/// /
/// /        //push on wiki1 for student, lessons and exercises
/// /        $this->assertTrue($this->p2pBot1->createPush('S1Course1', '[[type::!Exam]][[forYear::2009]]'),
/// /            'Failed to create push : S1Course1 ('.$this->p2pBot1->bot->results.')');
/// /        $this->assertTrue($this->p2pBot1->push('PushFeed:S1Course1'),
/// /            'failed to push S1Course1 ('.$this->p2pBot2->bot->results.')');
//
//        //pull on wiki3 from prof1
//        $this->assertTrue($this->p2pBot3->createPull('Prof1Course1',$this->p2pBot2->bot->wikiServer, 'Course1'),
//            'failed to create pull Prof1Course1 ('.$this->p2pBot3->bot->results.')');
//        $this->assertTrue($this->p2pBot3->Pull('PullFeed:Prof1Course1'),
//            'failed to pull Prof2Course1 ('.$this->p2pBot3->bot->results.')');
//
/// /        assertPageExist($this->p2pBot3->bot->wikiServer, 'Lesson1');
/// /        assertContentEquals($this->p2pBot3->bot->wikiServer, $this->p2pBot1->bot->wikiServer, $pageNameLesson1);
/// /
/// /        assertPageExist($this->p2pBot3->bot->wikiServer, 'Exercises1');
/// /        assertContentEquals($this->p2pBot3->bot->wikiServer, $this->p2pBot1->bot->wikiServer, 'Exercises1');
/// /
/// /        //edit page lesson1 on wiki3
/// /        $this->p2pBot3->bot->wikiLogin();
/// /        $addContent = 'content from student';
/// /        $this->assertTrue($this->p2pBot3->editPage('Lesson1', $addContent),
/// /            'failed to edit page Lesson1');
/// /        $pageContentLesson1 = getContentPage($this->p2pBot3->bot->wikiServer, $pageNameLesson1);
/// /
/// /        //push on wiki3 for prof1, lessons and exercises
/// /        $this->assertTrue($this->p2pBot3->createPush('StudCourse1', '[[type::!Exam]][[forYear::2009]]'),
/// /            'failed to create push : StudCourse1 ('.$this->p2pBot3->bot->results.')');
/// /        $this->assertTrue($this->p2pBot3->push('PushFeed:StudCourse1'),
/// /            'failed to push StudCourse1 ('.$this->p2pBot3->bot->results.')');
/// /
/// /        //pull on wiki1 from student
/// /        $this->assertTrue($this->p2pBot1->createPull('StudCourse1',$this->p2pBot3->bot->wikiServer, 'StudCourse1'),
/// /            'failed to create pull StudCourse1 ('.$this->p2pBot1->bot->results.')');
/// /        $this->assertTrue($this->p2pBot1->Pull('PullFeed:StudCourse1'),
/// /            'failed to pull StudCourse1 ('.$this->p2pBot1->bot->results.')');
/// /
/// /        assertContentEquals($this->p2pBot1->bot->wikiServer, $this->p2pBot3->bot->wikiServer, $pageNameLesson1);
//
//    }
}
?>
