<?php

class TaskRunnerTest extends WikiaBaseTest
{

	public function setUp()
	{
		$this->setupFile = dirname(__FILE__) . '/../CreateNewWiki_setup.php';
		parent::setUp();
	}

	public function tearDown()
	{
		parent::tearDown();
	}
}
