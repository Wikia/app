<?php

use Wikia\AbPerfTesting\Criterion;
use Wikia\AbPerfTesting\Criteria\Traffic;
use Wikia\AbPerfTesting\Criteria\Wikis;

class CriterionTest extends WikiaBaseTest {

	public function setUp() {
		$this->setupFile = __DIR__ . "/../AbPerfTesting.setup.php";
		parent::setUp();
	}

	function testCriterionFactory() {
		$this->assertInstanceOf( 'Wikia\AbPerfTesting\Criteria\Traffic', Criterion::factory('traffic') );
		$this->assertInstanceOf( 'Wikia\AbPerfTesting\Criteria\Traffic', Criterion::factory('Traffic') );
		$this->assertInstanceOf( 'Wikia\AbPerfTesting\Criteria\Traffic', Criterion::factory('TRAFFIC') );
	}

	/**
	 * @expectedException Wikia\AbPerfTesting\UnknownCriterionException
	 */
	function testCriterionFactoryErrorHandling() {
		Criterion::factory('foobar');
	}

	function testTrafficCriterion() {
		$this->mockGlobalFunction( 'wfGetBeaconId', '' );
		$this->assertFalse( ( new Traffic() )->applies(0) );

		$this->mockGlobalFunction( 'wfGetBeaconId', '8gQHS-Q4_c' );
		$this->assertTrue( ( new Traffic() )->applies(87) );

		$this->mockGlobalFunction( 'wfGetBeaconId', '3j-YqSr9BQ' );
		$this->assertFalse( ( new Traffic() )->applies(87) );

		$this->mockGlobalFunction( 'wfGetBeaconId', '3j-YqSr9BQ' );
		$this->assertTrue( ( new Traffic() )->applies(158) );
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
