<?php
require_once dirname(__FILE__) . '/../WikiaQuiz.class.php';
wfLoadAllExtensions();

class WikiaQuizTest extends PHPUnit_Framework_TestCase {
	protected function setUp() {

	}

	protected function tearDown() {
		F::unsetInstance('Category');
	}

}

