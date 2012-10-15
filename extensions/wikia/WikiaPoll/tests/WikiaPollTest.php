<?php
class WikiaPollTest extends WikiaBaseTest {

	public function setUp() {
		$this->setupFile =  dirname(__FILE__) . '/../WikiaPoll_setup.php';
		parent::setUp();
	}

	// Create a poll for all the other functions to use
	public static function setUpBeforeClass() {
		$user = User::newFromName('WikiaStaff');
		F::setInstance( 'User', $user);

		// Really bad style, but this test currently depends on the global title object
		global $wgTitle;
		$wgTitle = Title::newFromText ("Unit Testing", NS_WIKIA_POLL) ;
	}

	public static function tearDownAfterClass() {
		F::unsetInstance( 'User');
		F::unsetInstance( 'WebRequest' );
		F::unsetInstance( 'Title' );
		global $wgTitle;
		unset($wgTitle);
	}

	/* These are all part of one giant test call because the $pollId variable is shared */

	public function testWikiaPollAjax() {
		$this->markTestSkipped('Randomly failing due to master/slave lag'); // FIXME

		$poll = WF::build('WikiaPollAjax'); /* @var $poll WikiaPollAjax */

		// Sometimes the tear down doesn't execute?  Delete any old data before running create...
		$title = Title::newFromText ("Unit Testing", NS_WIKIA_POLL) ;
		$article = new Article($title, NS_WIKIA_POLL); /* @var $article WikiPage */
		if ($article->exists()) {
			$article->doDelete("Unit Testing", true);
		}

		/* TODO: mock these objects more agressively
		 * for now, just use a "real" title and article, as an integration test
		 */
		$title = Title::newFromText("Unit Testing", NS_WIKIA_POLL);
		F::setInstance('Title', $title);
		$this->mockGlobalVariable("wgTitle", $title);

		$wgRequest = $this->getMock('WebRequest', array('getVal', 'getArray'));
		$wgRequest->expects($this->at(0))
				->method('getVal')
				->with($this->equalTo('question'))
				->will($this->returnValue("Unit Testing"));
		$wgRequest->expects($this->any())
				->method('getArray')
				->with($this->equalTo('answer'))
				->will($this->returnValue(array("One", "Two", "Three")));
		$wgRequest->expects($this->any())
				->method('getIP')
				->will($this->returnValue('127.0.0.1'));
		$this->mockGlobalVariable('wgRequest', $wgRequest);

		$this->mockApp();

		$result = $poll->create();

		$this->assertType("array", $result, "Create result is array");
		$this->assertEquals(true, $result["success"], "Create result is not success, error: " . (isset($result['error']) ? $result['error'] : 'unknown - error message not set'));
		$this->assertEquals('Poll:Unit Testing', $result['question'], 'Create Question matches input');
		$this->assertType("int",  $result['pollId'], "Create returned a valid pollId");

		$title = Title::newFromText("Unit Testing", NS_WIKIA_POLL);
		$this->assertNotNull($title);
		$this->assertEquals($title->getText(), 'Unit Testing');

		// Second part of test is to see if we can "get" the same poll we created
		$pollId = $result['pollId'];

		$wgRequest = $this->getMock('WebRequest', array('getVal'));
		$wgRequest->expects($this->at(0))
				->method('getVal')
				->with($this->equalTo('pollId'))
				->will($this->returnValue($pollId));

		$this->mockGlobalVariable('wgRequest', $wgRequest);

		$result = $poll->get();

		$this->assertType("array", $result, "Get result is an array");
		$this->assertEquals(true, $result["exists"], "Get a poll that exists");
		$this->assertEquals('Poll:Unit Testing', $result['question'], 'Get Question matches original');
		$this->assertStringStartsWith('*One', $result['answer'], "Get answer was transformed correctly");

		// Third part of test is to update the poll we've got and see if that works too

		$wgRequest = $this->getMock('WebRequest', array('getVal', 'getArray'));
		$wgRequest->expects($this->at(0))
				->method('getVal')
				->with($this->equalTo('pollId'))
				->will($this->returnValue($pollId));
		$wgRequest->expects($this->any())
				->method('getArray')
				->with($this->equalTo('answer'))
				->will($this->returnValue(array("Three", "Two", "One")));
		$this->mockGlobalVariable('wgRequest', $wgRequest);

		$result = $poll->update();

		$this->assertType("array", $result, "Update result is array");
		$this->assertEquals(true, $result["success"], "Update result is success");
		$this->assertEquals('Poll:Unit Testing', $result['question'], 'Update Question matches input');

		// Fourth part of test is to register a vote for an item

		$wgRequest = $this->getMock('WebRequest', array('getVal'));
		$wgRequest->expects($this->at(0))
				->method('getVal')
				->with($this->equalTo('pollId'))
				->will($this->returnValue($pollId));
		$wgRequest->expects($this->at(1))
				->method('getVal')
				->with($this->equalTo('answer'))
				->will($this->returnValue(2));
		$this->mockGlobalVariable('wgRequest', $wgRequest);

		$result = $poll->vote();
		$this->assertType("array", $result, "Vote result is array");
		$this->assertType("string", $result["html"], "Vote result[html] is a block of HTML");
		$this->assertRegExp('/1 person voted/', $result["html"], "Vote result[html] says someone voted");

		// Fifth part of test is for checking to see if the user has voted
		$wgRequest = $this->getMock('WebRequest', array('getVal'));
		$wgRequest->expects($this->at(0))
				->method('getVal')
				->with($this->equalTo('pollId'))
				->will($this->returnValue($pollId));
		$this->mockGlobalVariable('wgRequest', $wgRequest);

		$result = $poll->hasVoted();
		$this->assertType("array", $result, "HasVoted result is array");
		$this->assertEquals(true, $result['hasVoted'], "HasVoted result is true");

		// clean up
		if ($article->exists()) {
			$article->doDelete("Unit Testing", true);
		}
	}

	function testDuplicateCreate() {
		$this->markTestSkipped('Randomly failing due to master/slave lag'); // FIXME

		/**  @var $poll WikiaPollAjax */
		$poll = WF::build('WikiaPollAjax');

		$wgRequest = $this->getMock('WebRequest', array('getVal', 'getArray'));
		$wgRequest->expects($this->at(0))
				->method('getVal')
				->with($this->equalTo('question'))
				->will($this->returnValue("Unit Testing"));
		$wgRequest->expects($this->any())
				->method('getArray')
				->with($this->equalTo('answer'))
				->will($this->returnValue(array("One", "Two", "Three")));
		$wgRequest->expects($this->any())
				->method('getIP')
				->will($this->returnValue('127.0.0.1'));

		$this->mockGlobalVariable('wgRequest', $wgRequest);
		$this->mockApp();

		// Create the same poll twice
		$result = $poll->create();

		$this->assertType("array", $result, "Create duplicate result is array");
		$this->assertEquals(false, $result["success"], "Create duplicate Poll success flag is false");
		$this->assertType("string", $result["error"], "Create duplicate Poll results in an error");

		// clean up
		$title = Title::newFromText ("Unit Testing", NS_WIKIA_POLL) ;
		$article = new Article($title, NS_WIKIA_POLL); /* @var $article WikiPage */
		if ($article->exists()) {
			$article->doDelete("Unit Testing", true);
		}
	}
}
