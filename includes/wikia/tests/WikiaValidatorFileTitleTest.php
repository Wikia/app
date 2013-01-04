<?php

class WikiaValidatorFileTitleTest extends PHPUnit_Framework_TestCase {

	/**
	 * @dataProvider filesDataProvider
	 */
	public function testFiles($fileString, $isValid, $exists) {

		$fileMock = $this->getMock('WikiaLocalFile', array('exists'), array(), '', false);
		$fileMock->expects($this->once())
			->method('exists')
			->will($this->returnValue($exists));

		$appMock = new stdClass();
		$appMock->wf = $this->getMock('stdClass', array('findFile'));
		$appMock->wf->expects($this->once())
			->method('findFile')
			->will($this->returnValue($fileMock));

		$validator = $this->getMock('WikiaValidatorFileTitle', array('getApp'));
		$validator->expects($this->once())
			->method('getApp')
			->will($this->returnValue($appMock));

		$titleMock = $this->getMock('Title', array('newFromText'));

		$titleMock->staticExpects($this->any())
			->method('newFromText')
			->with($this->equalTo(NS_FILE), $this->equalTo($fileString))
			->will($this->returnValue($titleMock));

		$titleMock->expects($this->any())
			->method('exists')
			->will($this->returnValue($exists));

		$validator->setTitleClass($titleMock);

		$result = $validator->isValid($fileString);
		$this->assertEquals($isValid, $result);
	}

	public function filesDataProvider() {
		return array(
			array('Skyfall (2012) - Theatrical Trailer 2 for Skyfall', true, true),
			array('Skyfall (2012) - Theatrical Trailer 2 for Skyfall', false, false),
			array('Skyfall (2012) - Theatrical Trailer 2 for Skyfall', false, false),
			array('James Bond', true, true),
			array('Skyfall (2012) - Theatrical Trailer 2 for Skyfall', false, false),
		);
	}
}
