<?php

use Wikia\AbPerformanceTesting\Experiment;

class ExperimentTest extends WikiaBaseTest {

	public function setUp() {
		$this->setupFile = __DIR__ . "/../AbPerformanceTesting.setup.php";
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
	}

	/**
	 * @expectedException Wikia\AbPerformanceTesting\UnknownCriterionException
	 */
	function testNotExistingCriteriaHandling() {
		Experiment::isEnabled( ['criteria' => ['foo' => 87]] );
	}

	function testComplexExperimentIsEnabled() {
		// all criteria need to me meet in order to make the expirement enabled
		$this->assertTrue( Experiment::isEnabled( [ 'criteria' => [ 'traffic' => 87, 'wikis' => 123 ] ] ) );

		$this->assertFalse( Experiment::isEnabled( [ 'criteria' => [ 'traffic' => 7, 'wikis' => 123 ] ] ) );
		$this->assertFalse( Experiment::isEnabled( [ 'criteria' => [ 'traffic' => 87, 'wikis' => 23 ] ] ) );
		$this->assertFalse( Experiment::isEnabled( [ 'criteria' => [ 'traffic' => 7, 'wikis' => 23 ] ] ) );
	}
}
