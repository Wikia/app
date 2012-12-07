<?php

class WikiaValidatorUrlTest extends PHPUnit_Framework_TestCase {

	/* @var $validator WikiaValidatorUrl */
	private $validator;

	protected function setUp() {
		$this->validator = new WikiaValidatorUrl();
	}

	/**
	 * @dataProvider testUrlsDataProvider
	 */
	public function testUrls($string, $isUrl) {
		$result = $this->validator->isValid($string);
		$this->assertEquals($result, $isUrl);
	}

	public function testUrlsDataProvider() {
		return array(
			array('http://www.wikia.com',true),
			array('www.wikia.com',true),
			array('wikia.com',true),
			array('wikia',false),
			array('http://www.wikia.com/?action=purge',true),
			array('http://www.wikia.com/#wiki',true),
		);
	}
}
