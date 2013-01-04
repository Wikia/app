<?php

class WikiaValidatorFileTitleTest extends PHPUnit_Framework_TestCase {

	/* @var $validator WikiaValidatorUrl */
	private $validator;

	protected function setUp() {
		$this->validator = new WikiaValidatorFileTitle();
	}

	/**
	 * @dataProvider testUrlsDataProvider
	 */
	public function testFiles($fileString, $isValid, $exists, $namespace) {

		$titleMock = $this->getMock('Title', array('makeTitle', 'exists', 'getNamespace'));

		$titleMock->staticExpects($this->once())
			->method('makeTitle')
			->will($this->returnValue($titleMock));

		$titleMock->expects($this->any())
			->method('exists')
			->will($this->returnValue($exists));

		$titleMock->expects($this->any())
			->method('getNamespace')
			->will($this->returnValue($namespace));

		$this->validator->setTitleClass($titleMock);

		$result = $this->validator->isValid($fileString);
		$this->assertEquals($isValid, $result);
	}

	public function testUrlsDataProvider() {
		return array(
			array('Skyfall (2012) - Theatrical Trailer 2 for Skyfall', true, true, NS_FILE),
			array('Skyfall (2012) - Theatrical Trailer 2 for Skyfall', false, false, NS_FILE),
			array('Skyfall (2012) - Theatrical Trailer 2 for Skyfall', false, true, NS_MAIN),
			array('James Bond', true, true, NS_FILE),
			array('Skyfall (2012) - Theatrical Trailer 2 for Skyfall', false, false, NS_CATEGORY),
		);
	}
}
