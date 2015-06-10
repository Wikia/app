<?php

use Wikia\AbPerfTesting\Experiment;

class ExperimentTest extends WikiaBaseTest {

	public function setUp() {
		$this->setupFile = __DIR__ . "/../AbPerfTesting.setup.php";
		parent::setUp();
	}

	function testExperimentIsEnabled() {
		$this->assertFalse(Experiment::isEnabled([]));
		$this->assertFalse(Experiment::isEnabled([ 'criteria' => [] ]));
	}

	function testPerWikiExperimentIsEnabled() {
		$this->mockGlobalVariable( 'wgCityId', 5123 );
		$this->assertTrue( Experiment::isEnabled( [ 'criteria' => [ 'wikis' => 123 ] ]) );

		$this->mockGlobalVariable( 'wgCityId', 5123 );
		$this->assertFalse( Experiment::isEnabled( [ 'criteria' => [ 'wikis' => 23 ] ]) );
	}
}
