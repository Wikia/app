<?php

class WikiaQuizModuleTest extends WikiaBaseTest {
	
	public function __construct() {
		parent::__construct();

		$this->setupFile = __DIR__ . '/../WikiaQuiz_setup.php';
	}
	
	public function testExecuteGetQuizElement() {
		$wgRequest = $this->getMock('WebRequest', array('getVal'), array(), '', false);
		$wgRequest->expects($this->any())
			->method('getVal')
			->will($this->returnValue('10001'));

		$this->mockGlobalVariable('wgRequest', $wgRequest);

		$quizElement = $this->getMock('WikiaQuizElement', array('getData'), array(), '', false);
		$quizElement->expects($this->any())
			->method('getData')
			->will($this->returnValue(array('foo'=>'bar', 'baz'=>'asdf')));
		$this->mockClass('WikiaQuizElement', $quizElement);

		$response = $this->app->sendRequest('WikiaQuiz', 'executeGetQuizElement');
		$this->assertNotNull($response->getData());
	}

	public function testExecuteGetQuizElementInvalidRequest() {
		$wgRequest = $this->getMock('WebRequest', array('getVal'), array(), '', false);
		$wgRequest->expects($this->any())
			->method('getVal')
			->will($this->returnValue(null));
		
		$this->mockGlobalVariable('wgRequest', $wgRequest);

		$response = $this->app->sendRequest('WikiaQuiz', 'executeGetQuizElement');
		$this->assertNull($response->getVal('data'));

	}

}

