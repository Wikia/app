<?php

class ImageServingDriverMainNSTest extends WikiaBaseTest {

	/** @var PHPUnit_Framework_MockObject_MockObject */
	protected $driver;

	public function setUp() {
		parent::setUp();
	}

	public function testMainNSDriver() {
		$imgName = 'test.jpg';
		$id = 300;

		$driver = $this->setUpMock()
			->setUpImageIndex( [ $id => [ $imgName ] ] )
			->setUpImagesPopularity( [ $imgName => 1 ] )
			->setUpLoadImageMetadata( [ [ [ $imgName ], [ $imgName => $this->getDetails( $imgName ) ] ] ] )
			->setUpInfoboxImages( [] )
			->setUpGetRevId( 0 )
			->getDriver();

		$driver->setArticles( [ $id => null ] );
		$result = $driver->execute();

		$this->assertEquals( $this->getExpected( $id, [ $imgName ] ), $result );
	}

	public function testInfoboxImagesAlone() {
		$imgName = 'infobox_image.jpg';
		$id = 301;

		$driver = $this->setUpMock()
			->setUpImageIndex( [ ] )
			->setUpLoadImageMetadata( [ [ [ $imgName ], [ $imgName => $this->getDetails( $imgName ) ] ] ] )
			->setUpImagesPopularity( [] )
			->setUpInfoboxImages( [ $imgName ] )
			->setUpGetRevId( 0 )
			->getDriver();

		$driver->setArticles( [ $id => null ] );
		$result = $driver->execute();

		$this->assertEquals( $this->getExpected( $id, [ $imgName ] ), $result );
	}

	public function testMixedResults() {
		$infoboxImage = 'should_be_first.jpg';
		$other = 'other.png';
		$id = 302;

		$driver = $this->setUpMock()
			->setUpImageIndex( [ $id => [ $other ] ] )
			->setUpImagesPopularity( [ $other => 1 ] )
			->setUpLoadImageMetadata( [ [ [ $infoboxImage ], [ $infoboxImage => $this->getDetails( $infoboxImage ) ] ],
										[ [ $other ], [ $other => $this->getDetails( $other ) ] ] ] )
			->setUpInfoboxImages( [ $infoboxImage ] )
			->setUpGetRevId( 0 )
			->getDriver();

		$driver->setArticles( [ $id => null ] );
		$result = $driver->execute();

		$this->assertEquals( $this->getExpected( $id, [ $infoboxImage, $other ] ), $result );
	}

	/**
	 * @return ImageServingDriverMainNS
	 */
	protected function getDriver() {
		return $this->driver;
	}

	protected function setUpMock() {
		$isMock = $this->getMockBuilder( 'imageServing' )
			->disableOriginalConstructor()
			->setMethods( [ 'getUrl', 'getRequestedHeight', 'getRequestedWidth' ] )
			->getMock();

		$this->driver = $this->getMockBuilder( 'ImageServingDriverMainNS' )
			->setConstructorArgs( [ null, $isMock ] )
			->setMethods( [ 'getImageIndex', 'getImagesPopularity', 'loadImagesMetadata', 'getInfoboxImagesForId', 'getRevId' ] )
			->getMock();

		return $this;
	}

	protected function setUpInfoboxImages( $returns ) {
		$this->driver->expects( $this->any() )
			->method( 'getInfoboxImagesForId' )
			->will( $this->returnValue( $returns ) );

		return $this;
	}

	protected function setUpImageIndex( $returns ) {
		$this->driver->expects( $this->any() )
			->method( 'getImageIndex' )
			->will( $this->returnValue( $returns ) );

		return $this;
	}

	protected function setUpImagesPopularity( $returns ) {
		$this->driver->expects( $this->any() )
			->method( 'getImagesPopularity' )
			->will( $this->returnValue( $returns ) );

		return $this;
	}

	protected function setUpLoadImageMetadata( $returns ) {
		$this->driver->expects( $this->any() )
			->method( 'loadImagesMetadata' )
			->will( $this->returnValueMap( $returns ) );

		return $this;
	}

	protected function setUpGetRevId( $returns ) {
		$this->driver->expects( $this->any() )
			->method( 'getRevId' )
			->will( $this->returnValue( $returns ) );

		return $this;
	}

	protected function getExpected( $id, $images ) {

		return [ $id => array_map( function ( $image ) {
			return [ 'name' => $image, 'original_dimensions' => [ 'width' => 0, 'height' => 0 ], 'url' => null ];
		}, $images ) ];
	}

	protected function getDetails( $image ) {
		$details = new stdClass();
		$details->img_name = $image;
		$details->img_height = 1000;
		$details->img_width = 1000;
		$details->img_minor_mime = 'image/jpeg';

		return $details;
	}
}
