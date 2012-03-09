<?php
require_once dirname(__FILE__) . '/../WikiaPoll_setup.php';
wfLoadAllExtensions();

class WikiaPollTest extends WikiaBaseTest {

	// Create a poll for all the other functions to use
	public static function setUpBeforeClass() {
		$wgUser = User::newFromName('WikiaStaff');
		F::setInstance( 'User', $wgUser);
	}

	public static function tearDownAfterClass() {
		global $wgTitle;
		$wgTitle = Title::newFromText ("Unit Testing", NS_WIKIA_POLL) ;
		$article = new Article($wgTitle, NS_WIKIA_POLL);
		$article->doDelete("Unit Testing", true);

		F::unsetInstance( 'User');
	}

	/* These are all part of one giant test call because the $pollId variable is shared */

	public function testWikiaPollAjax() {
		global $wgUser, $wgTitle;

		$poll = WF::build('WikiaPollAjax');

		// Sometimes the tear down doesn't execute?  Delete any old data before running create...
		$wgTitle = Title::newFromText ("Unit Testing", NS_WIKIA_POLL) ;
		$article = new Article($wgTitle, NS_WIKIA_POLL);
		$article->doDelete("Unit Testing", true);

		/* TODO: mock these objects more agressively
		 * for now, just use a "real" title and article, as an integration test
		 *
		$title = Title::newFromText("Unit Testing", NS_WIKIA_POLL);
		F::setInstance( 'Title', $title);

		$wgArticle = $this->getMock('Article', array('doEdit'), array($title, NS_WIKIA_POLL));
		$wgArticle->expects($this->once())
				->method('doEdit')
				->will($this->returnValue(true));
		F::setInstance( 'Article', $wgArticle );
		 */

		$wgRequest = $this->getMock('WebRequest', array('getVal', 'getArray'));
		$wgRequest->expects($this->at(0))
				->method('getVal')
				->with($this->equalTo('question'))
				->will($this->returnValue("Unit Testing"));
		$wgRequest->expects($this->any())
				->method('getArray')
				->with($this->equalTo('answer'))
				->will($this->returnValue(array("One", "Two", "Three")));
		F::app()->setGlobal('wgRequest', $wgRequest );

		$result = $poll->create();

		$this->assertType("array", $result, "Create result is array");
		$this->assertEquals(true, $result["success"], "Create result is not success, error: " . (isset($result['error']) ? $result['error'] : 'unknown - error message not set'));
		$this->assertEquals('Poll:Unit Testing', $result['question'], 'Create Question matches input');
		$this->assertType("int",  $result['pollId'], "Create returned a valid pollId");

		// Second part of test is to see if we can "get" the same poll we created
		$pollId = $result['pollId'];

		$wgRequest = $this->getMock('WebRequest', array('getVal'));
		$wgRequest->expects($this->at(0))
				->method('getVal')
				->with($this->equalTo('pollId'))
				->will($this->returnValue($pollId));

		//F::setInstance( 'WebRequest', $wgRequest );
		F::app()->setGlobal('wgRequest', $wgRequest );

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

		//F::setInstance( 'WebRequest', $wgRequest );
		F::app()->setGlobal('wgRequest', $wgRequest );

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
		$wgRequest->expects($this->at(2))
				->method('getVal')
				->with($this->equalTo('answer'))
				->will($this->returnValue(2));
		F::app()->setGlobal('wgRequest', $wgRequest );

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
		F::app()->setGlobal('wgRequest', $wgRequest );

		$result = $poll->hasVoted();
		$this->assertType("array", $result, "HasVoted result is array");
		$this->assertEquals(true, $result['hasVoted'], "HasVoted result is true");

	}

	function testDuplicateCreate() {

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
		F::app()->setGlobal('wgRequest', $wgRequest );

		// Create the same poll twice
		$result = $poll->create();
		$result = $poll->create();

		$this->assertType("array", $result, "Create duplicate result is array");
		$this->assertEquals(false, $result["success"], "Create duplicate Poll success flag is false");
		$this->assertType("string", $result["error"], "Create duplicate Poll results in an error");

	}

}
