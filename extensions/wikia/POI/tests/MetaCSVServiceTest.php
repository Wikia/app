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
	"Gameplay Walkthrough: Intro of Ratbag";"GP_Orc_1";"firebird_2"
	"Shadow Strike";"PS_Shadow_Attack"
CSV;
		$expect = [
			['Title' => 'Gameplay Walkthrough: Intro of Ratbag', "wb_alias" => "GP_Orc_1", "Fingerprint_ID" => "firebird_2"],
			['Title' => 'Shadow Strike', "wb_alias" => "PS_Shadow_Attack","Fingerprint_ID" => null]
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