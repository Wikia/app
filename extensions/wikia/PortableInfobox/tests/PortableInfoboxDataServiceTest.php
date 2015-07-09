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
				  'data' => [
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
				  ]
				],
				[ // INFOBOX 2
				  'data' => [
					  [
						  "type" => "image",
						  "data" => [
							  "key" => "Test2.jpg",
							  "alt" => null,
							  "caption" => null
						  ]
					  ]
				  ]
				]
			];

		return $data;
	}

	public function testImageListRemoveDuplicates() {
		$mock = $this->getMockBuilder( 'PortableInfoboxDataService' )
			->disableOriginalConstructor()
			->setMethods( [ 'getData' ] )
			->getMock();
		$mock->expects( $this->any() )->method( 'getData' )->will( $this->returnValue( $this->getInfoboxData() ) );

		$images = $mock->getImages();
		$this->assertTrue( count( $images ) === 2 );
	}

	public function testImageListFetchImages() {
		$mock = $this->getMockBuilder( 'PortableInfoboxDataService' )
			->disableOriginalConstructor()
			->setMethods( [ 'getData' ] )
			->getMock();
		$mock->expects( $this->any() )->method( 'getData' )->will( $this->returnValue( $this->getInfoboxData() ) );

		$images = $mock->getImages();
		$this->assertTrue( in_array( "Test.jpg", $images ), "Test.jpg should be in images array" );
		$this->assertTrue( in_array( "Test2.jpg", $images ), "Test2.jpg should be in images array" );
	}

	public function testTitleNullConstructor() {
		$service = PortableInfoboxDataService::newFromTitle(null);
		$result = $service->getData();
		$this->assertEquals( [], $result );
	}

	public function testConstructor() {
		$service = PortableInfoboxDataService::newFromPageID(null);
		$result = $service->getData();
		$this->assertEquals( [], $result );
	}

}
