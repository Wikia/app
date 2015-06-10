<?php

use Wikia\AbPerfTesting\Experiment;

class ExperimentTest extends WikiaBaseTest {

	public function setUp() {
		$this->setupFile = __DIR__ . "/../AbPerfTesting.setup.php";
		parent::setUp();

		$this->mockGlobalVariable( 'wgCityId', 5123 );
		$this->mockGlobalFunction( 'wfGetBeaconId', '8gQHS-Q4_c' );
	}

	function testExperimentIsEnabled() {
		$this->assertFalse( Experiment::isEnabled( [] ) );
		$this->assertFalse( Experiment::isEnabled( [ 'criteria' => [] ] ) );
	}

	function testPerWikiExperimentIsEnabled() {
		$this->assertTrue( Experiment::isEnabled( [ 'criteria' => [ 'wikis' => 123 ] ] ) );
		$this->assertFalse( Experiment::isEnabled( [ 'criteria' => [ 'wikis' => 23 ] ] ) );
	}

	function testTrafficExperimentIsEnabled() {
		$this->assertTrue( Experiment::isEnabled( ['criteria' => ['traffic' => 87]] ) );
		$this->assertTrue( Experiment::isEnabled( ['criteria' => ['traffic' => 87, 'wikis' => 23]] ) );
	}

	function testComplexExperimentIsEnabled() {
		$this->assertTrue( Experiment::isEnabled( [ 'criteria' => [ 'traffic' => 87, 'wikis' => 123 ] ] ) );
		$this->assertTrue( Experiment::isEnabled( [ 'criteria' => [ 'traffic' => 87, 'wikis' => 23 ] ] ) );
		$this->assertTrue( Experiment::isEnabled( [ 'criteria' => [ 'traffic' => 7, 'wikis' => 123 ] ] ) );

		$this->assertFalse( Experiment::isEnabled( [ 'criteria' => [ 'traffic' => 7, 'wikis' => 23 ] ] ) );
	}
}
