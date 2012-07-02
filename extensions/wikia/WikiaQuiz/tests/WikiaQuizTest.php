<?php
require_once dirname(__FILE__) . '/../WikiaQuiz.class.php';

class WikiaQuizTest extends PHPUnit_Framework_TestCase {
	protected function setUp() {

	}

	protected function tearDown() {
		F::unsetInstance('Category');
	}
	
	public function testFoo() {
		$this->markTestIncomplete('Test class without tests always fails');
	}

}

