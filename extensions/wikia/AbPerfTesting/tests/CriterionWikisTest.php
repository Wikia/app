<?php

use Wikia\AbPerfTesting\Criteria\Wikis;

class CriterionWikisTest extends WikiaBaseTest {

	public function setUp() {
		$this->setupFile = __DIR__ . "/../AbPerfTesting.setup.php";
		parent::setUp();
	}

	function testWikisCriterion() {
		$this->mockGlobalVariable( 'wgCityId', 5123 );
		$this->assertTrue( ( new Wikis() )->applies(123) );

		$this->mockGlobalVariable( 'wgCityId', 1 );
		$this->assertTrue( ( new Wikis() )->applies(1) );

		$this->mockGlobalVariable( 'wgCityId', 1000 );
		$this->assertTrue( ( new Wikis() )->applies(0) );

		$this->mockGlobalVariable( 'wgCityId', 5123 );
		$this->assertFalse( ( new Wikis() )->applies(23) );
	}
}
