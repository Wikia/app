<?php

class PortableInfoboxDataServiceTest extends PHPUnit_Framework_TestCase {

	protected function setUp() {
		$this->setupFile = dirname( __FILE__ ) . '/../PortableInfobox.setup.php';
		parent::setUp();
	}

	protected function getInfoboxData() {
		$data =
			[
				[ // INFOBOX 1
					[
						"type" => "data",
						"data" => [
							"value" => "AAAA",
							"label" => "BBBB"
						]
					],
					[
						"type" => "image",
						"data" => [
							"key" => "Test.jpg",
							"alt" => null,
							"caption" => null,
						]
					],
					[
						"type" => "image",
						"data" => [
							"key" => "Test2.jpg",
							"alt" => null,
							"caption" => null
						]
					]
				],
				[ // INFOBOX 2
					[
						"type" => "image",
						"data" => [
							"key" => "Test2.jpg",
							"alt" => null,
							"caption" => null
						]
					]
				]
			];
		return $data;
	}

	public function testImageListRemoveDuplicates() {
		$dataService = new PortableInfoboxDataService();
		$images = $dataService->getImageListFromInfoboxesData( $this->getInfoboxData() );
		$this->assertTrue( count( $images ) === 2 );
	}

	public function testImageListFetchImages() {
		$dataService = new PortableInfoboxDataService();
		$images = $dataService->getImageListFromInfoboxesData( $this->getInfoboxData() );
		$this->assertTrue( in_array( "Test.jpg", $images ), "Test.jpg should be in images array" );
		$this->assertTrue( in_array( "Test2.jpg", $images ), "Test2.jpg should be in images array");
	}

}
