<?php
class MetaCSVServiceTest extends WikiaBaseTest {
	public function setUp() {
		$dir = dirname( __FILE__ ) . '/../';
		$this->setupFile = $dir . 'POI.setup.php';
		$this->tmpFile = tempnam('/tmp', __CLASS__);
		parent::setUp();
	}

	public function tearDown(){
		@unlink($this->tmpFile);
		parent::tearDown();

	}
	public function testFileReadOK(){
		$fileContents =<<<CSV
	"Gameplay Walkthrough: Intro of Ratbag";"f1,f1a";"q1";"a1"
	"Shadow Strike";"f2";"q2";"a2"
CSV;
		$expect = [
			['title' => 'Gameplay Walkthrough: Intro of Ratbag', "fingerprints" => [ "f1", "f1a" ], "quest_id" => "q1", "ability_id" => "a1" ],
			['title' => 'Shadow Strike', "fingerprints" => [ "f2" ], "quest_id" => "q2", "ability_id" => "a2" ]
		];
		file_put_contents($this->tmpFile, $fileContents);
		$service = new MetaCSVService();
		$this->assertEquals($expect, $service->LoadDataFromFile($this->tmpFile));

	}

	/**
	 * @expectedException MetaException
	 */
	public function testFileReadFail(){

		$service = new MetaCSVService();
		$service->LoadDataFromFile('/tmp/hdasfjhagsdijhfagsdiu');

	}
}