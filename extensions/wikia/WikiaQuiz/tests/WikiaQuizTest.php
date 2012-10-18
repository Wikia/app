<?php

class WikiaQuizTest extends WikiaBaseTest {
	protected function setUp() {
		$this->setupFile = dirname(__FILE__) . '/../WikiaQuiz.class.php';
		parent::setUp();
	}

	protected function tearDown() {
		F::unsetInstance('Category');
	}

	public function testFoo() {
		$this->markTestIncomplete('Test class without tests always fails');
	}

}
