<?php
require_once 'PHPUnit/Extensions/SeleniumTestCase.php';

class AdSS_PublisherTest extends PHPUnit_Extensions_SeleniumTestCase {

	protected function setUp() {
		$this->setBrowser('*pifirefox');
		$this->setBrowserUrl('http://www.wowwiki.com/');
	}

	public function testSelfAd() {
		$this->open('/Special:Random');
		$this->assertElementPresent('css=div.sponsormsg > ul > li');
	}
}
