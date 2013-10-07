<?php

class WikiaAppControllerTest extends PHPUnit_Framework_TestCase {
	
	public function test_hideNonCommercialContent() {
		$requestMock = $this->getMock('WikiaRequest', array('getScriptUrl'), array(), '', false);
		$requestMock->expects($this->any())->method('getScriptUrl')->will($this->returnValue('/api/v1...'));
		$controller = new WikiaApiController();
		$controller->setRequest($requestMock);
		$this->assertTrue($controller->hideNonCommercialContent(), "This request should allowed only content".
											" that may be used commercially");	

		$requestMock = $this->getMock('WikiaRequest', array('getScriptUrl'), array(), '', false);
		$requestMock->expects($this->any())->method('getScriptUrl')->will($this->returnValue('/wikia.php?...'));
		$controller = new WikiaApiController();
		$controller->setRequest($requestMock);
		$this->assertFalse($controller->hideNonCommercialContent(), "This request should have allowed all content");											
	}

	public function test_getApiVersion() {
		$requestMock = $this->getMock('WikiaRequest', array('getScriptUrl'), array(), '', false);
		$requestMock->expects($this->any())->method('getScriptUrl')->will($this->returnValue('/api/v1...'));
		$controller = new WikiaApiController();
		$controller->setRequest($requestMock);
		$this->assertEquals($controller->getApiVersion(), 1);

		$requestMock = $this->getMock('WikiaRequest', array('getScriptUrl'), array(), '', false);
		$requestMock->expects($this->any())->method('getScriptUrl')->will($this->returnValue('/wikia.php?...'));
		$controller = new WikiaApiController();
		$controller->setRequest($requestMock);
		$this->assertEquals($controller->getApiVersion(), 'internal');

		$requestMock = $this->getMock('WikiaRequest', array('getScriptUrl'), array(), '', false);
		$requestMock->expects($this->any())->method('getScriptUrl')->will($this->returnValue('/api/test...'));
		$controller = new WikiaApiController();
		$controller->setRequest($requestMock);
		$this->assertEquals($controller->getApiVersion(), 'test');
	}


}
