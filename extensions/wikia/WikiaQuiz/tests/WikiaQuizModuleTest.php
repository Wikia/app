<?php

class WikiaQuizModuleTest extends PHPUnit_Framework_TestCase {
	protected function setUp() {
		$this->app = F::app();
	}

	protected function tearDown() {
		F::unsetInstance('WebRequest');
		F::unsetInstance('WikiaQuizElement');
		F::setInstance('App', $this->app);
	}

	public function testExecuteGetQuizElement() {
		$wgRequest = $this->getMock('WebRequest', array('getVal'), array(), '', false);
		$wgRequest->expects($this->any())
			->method('getVal')
			->will($this->returnValue('10001'));

		$app = $this->getMock('WikiaApp', array('getGlobal'), array(), '', false);
		$app->expects($this->any())
			->method('getGlobal')
			->will($this->returnValue($wgRequest));

		F::setInstance('App', $app);

		$quizElement = $this->getMock('WikiaQuizElement', array('getData'), array(), '', false);
		$quizElement->expects($this->once())
			->method('getData')
			->will($this->returnValue(array('foo'=>'bar', 'baz'=>'asdf')));

		F::setInstance('WikiaQuizElement', $quizElement);

		$quizModule = new WikiaQuizModule();
		$quizModule->executeGetQuizElement();
		$this->assertNotNull($quizModule->data);
	}

	public function testExecuteGetQuizElementInvalidRequest() {
		$wgRequest = $this->getMock('WebRequest', array('getVal'), array(), '', false);
		$wgRequest->expects($this->once())
			->method('getVal')
			->will($this->returnValue(null));
		$app = $this->getMock('WikiaApp', array('getGlobal'), array(), '', false);
		$app->expects($this->once())
			->method('getGlobal')
			->will($this->returnValue($wgRequest));
		F::setInstance('App', $app);

		$quizModule = new WikiaQuizModule();
		$quizModule->executeGetQuizElement();
		$this->assertNull($quizModule->data);

	}

}

