<?php

class WikiaQuizTest extends PHPUnit_Framework_TestCase {
	protected function setUp() {
		
	}

	protected function tearDown() {
		F::unsetInstance('Category');
	}

	public function testNewFromName() {
		$cat = $this->getMock('Category', array('getName', 'getId'), array(), '', false);
		$cat->expects($this->once())
		    ->method('getName')
			->will($this->returnValue('Quiz_foobar'));
		$cat->expects($this->once())
		    ->method('getId')
			->will($this->returnValue(5));

		F::setInstance('Category', $cat);

		$quiz = WikiaQuiz::newFromName('foobar');
		$this->assertInstanceOf('WikiaQuiz', $quiz);
		$this->assertEquals('foobar', $quiz->getName());

		F::unsetInstance('Category');
		F::setInstance('Category', null);
		$quiz = WikiaQuiz::newFromName('foobar2');
		$this->assertFalse($quiz);

	}
}

