<?php
require_once 'PHPUnit/Extensions/SeleniumTestCase.php';

class AdSS_AdFormTest extends PHPUnit_Extensions_SeleniumTestCase {

	protected function setUp() {
		$this->setBrowser('*pifirefox');
		$this->setBrowserUrl('http://www.wowwiki.com/');
	}

	public function testForm() {
		$this->open('/index.php?title=Special:AdSS&page=Race');

		$this->assertEquals("Race", $this->getValue("wpPage"));

		$this->clickAndWait( "wpSubmit" );
		/*
		$this->click( 'wpSelectSite' );
		$this->waitForElementNotVisible( 'wpPage' );
		$this->waitForElementVisible( 'wpWeight' );

		$this->click( 'wpSelectPage' );
		$this->waitForElementVisible( 'wpPage' );
		$this->waitForElementNotVisible( 'wpWeight' );
		*/
	}

}
