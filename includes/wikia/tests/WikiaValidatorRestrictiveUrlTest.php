<?php

class WikiaValidatorRestrictiveUrlTest extends PHPUnit_Framework_TestCase {

	/* @var $validator WikiaValidatorRestrictiveUrl */
	private $validator;

	protected function setUp () {
		$this->validator = new WikiaValidatorRestrictiveUrl();
	}

	/**
	 * @dataProvider testUrlsDataProvider
	 */
	public function testUrls ($string, $isUrl) {
		$result = $this->validator->isValid($string);
		$this->assertEquals($isUrl, $result);
	}

	public function testUrlsDataProvider () {
		return array(
			array('http://www.wikia.com', true),
			array('www.wikia.com', true),
			array('wikia.com', true),
			array('http://www.wikia.com/?action=purge', true),
			array('http://www.wikia.com/#wiki', true),
			array('http://pl.callofduty.wikia.com/wiki/Call_of_Duty:_Black_Ops', true),
			array('https://www.wikia.com/Wikia', true),
			array('www.aol', true), // this is ok for regexp validation
			array('lordoftherings.aol', true), // this is ok for regexp validation
			array('lordoftherings.museum', true), // this is theoretically an acceptable URL
			array('lordoftherings.info', true),
			array('wikia', false),
			array('http://wikia', false),
			array('http://www.wikia.xxx', false), // .xxx is a not a valid domain for the toolbox
		);
	}
}
