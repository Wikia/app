<?php

use Wikia\PortableInfobox\Helpers\PortableInfoboxImagesHelper;

class PortableInfoboxImagesHelperTest extends WikiaBaseTest {
	private $helper;

	protected function setUp() {
		$this->setupFile = dirname( __FILE__ ) . '/../PortableInfobox.setup.php';
		parent::setUp();

		$this->helper = new PortableInfoboxImagesHelper();
	}

	/**
	 * @desc mocks WikiaFileHelper methods
	 * @param array $input
	 * @return \PHPUnit_Framework_MockObject_MockObject
	 */
	public function createWikiaFileHelperMock( $input ) {
		$fileWidth = isset( $input[ 'fileWidth' ] ) ? $input[ 'fileWidth' ] : null;
		$fileHeight = isset( $input[ 'fileHeight' ] ) ? $input[ 'fileHeight' ] : null;

		$fileMock = $this->getMockBuilder( 'File' )
			->setConstructorArgs( [ 'TestFile', false ] )
			->setMethods( [ 'getWidth', 'getHeight' ] )
			->getMock();
		$fileMock->expects( $this->any() )
			->method( 'getWidth' )
			->will( $this->returnValue( $fileWidth ) );
		$fileMock->expects( $this->any() )
			->method( 'getHeight' )
			->will( $this->returnValue( $fileHeight ) );

		$this->mockStaticMethod( 'WikiaFileHelper', 'getFileFromTitle', $fileMock );

		return $fileMock;
	}

	/**
	 * @param $width
	 * @param $max
	 * @param $imageWidth
	 * @param $imageHeight
	 * @param $expected
	 * @dataProvider thumbnailSizesDataProvider
	 */
	public function testGetThumbnailSizes( $width, $max, $imageWidth, $imageHeight, $expected ) {
		$helper = new PortableInfoboxImagesHelper();
		$result = $helper->getThumbnailSizes( $width, $max, $imageWidth, $imageHeight );

		$this->assertEquals( $expected, $result );
	}

	public function thumbnailSizesDataProvider() {
		return [
			[
				'preferredWidth' => 270,
				'maxHeight' => 500,
				'originalWidth' => 270,
				'originalHeight' => 250,
				'expected' => [ 'width' => 270, 'height' => 250 ]
			],
			[
				'preferredWidth' => 300,
				'maxHeight' => 500,
				'originalWidth' => 350,
				'originalHeight' => 250,
				'expected' => [ 'width' => 300, 'height' => 214 ]
			],
			[
				'preferredWidth' => 300,
				'maxHeight' => 500,
				'originalWidth' => 300,
				'originalHeight' => 550,
				'expected' => [ 'width' => 273, 'height' => 500 ]
			],
			[
				'preferredWidth' => 200,
				'maxHeight' => 500,
				'originalWidth' => 300,
				'originalHeight' => 400,
				'expected' => [ 'width' => 200, 'height' => 267 ]
			],
			[
				'preferredWidth' => 270,
				'maxHeight' => 500,
				'originalWidth' => 100,
				'originalHeight' => 300,
				'expected' => [ 'width' => 100, 'height' => 300 ]
			],
			[
				'preferredWidth' => 270,
				'maxHeight' => 500,
				'originalWidth' => 800,
				'originalHeight' => 600,
				'expected' => [ 'width' => 270, 'height' => 203 ]
			],
		];
	}


	/**
	 * @param $customWidth
	 * @param $preferredWidth
	 * @param $resultDimensions
	 * @param $thumbnailDimensions
	 * @param $thumbnail2xDimensions
	 * @param $originalDimension
	 * @dataProvider customWidthProvider
	 */
	public function testCustomWidthLogic( $customWidth, $preferredWidth, $resultDimensions, $thumbnailDimensions, $thumbnail2xDimensions, $originalDimension ) {
		$expected = [
			'name' => 'test',
			'ref' => null,
			'thumbnail' => null,
			'thumbnail2x' => null,
			'key' => '',
			'media-type' => 'image',
			'width' => $resultDimensions[ 'width' ],
			'height' => $resultDimensions[ 'height' ],
			'originalHeight' => '',
			'originalWidth' => '',
			'fileName' => '',
			'dataAttrs' => '[]'
		];
		$thumb = $this->getMockBuilder( 'ThumbnailImage' )
			->disableOriginalConstructor()
			->setMethods( [ 'isError', 'getUrl' ] )
			->getMock();
		$file = $this->getMockBuilder( 'File' )
			->disableOriginalConstructor()
			->setMethods( [ 'exists', 'transform', 'getWidth', 'getHeight', 'getMediaType' ] )
			->getMock();
		$file->expects( $this->once() )->method( 'exists' )->will( $this->returnValue( true ) );
		$file->expects( $this->once() )->method( 'getWidth' )->will( $this->returnValue( $originalDimension[ 'width' ] ) );
		$file->expects( $this->once() )->method( 'getHeight' )->will( $this->returnValue( $originalDimension[ 'height' ] ) );
		$file->expects( $this->once() )->method( 'getMediaType' )->will( $this->returnValue( MEDIATYPE_BITMAP ) );

		$file->expects( $this->any() )
			->method( 'transform' )
			->with( $this->logicalOr ( $this->equalTo( $thumbnailDimensions ), $this->equalTo( $thumbnail2xDimensions ) ) )
			->will( $this->returnValue( $thumb ) );
		$this->mockStaticMethod( 'WikiaFileHelper', 'getFileFromTitle', $file );
		$this->mockStaticMethod( 'Hooks', 'run', true );

		$globals = new \Wikia\Util\GlobalStateWrapper( [
			'wgPortableInfoboxCustomImageWidth' => $customWidth
		] );

		$helper = new PortableInfoboxImagesHelper();
		$result = $globals->wrap( function () use ( $helper, $preferredWidth ) {
			return $helper->extendImageData( [ 'name' => 'test' ], $preferredWidth );
		} );

		$this->assertEquals( $expected, $result );
	}

	public function customWidthProvider() {
		return [
			[
				'custom' => false,
				'preferred' => 300,
				'result' => [ 'width' => 300, 'height' => 200 ],
				'thumbnail' => [ 'width' => 300, 'height' => 200 ],
				'thumbnail2x' => [ 'width' => 600, 'height' => 400 ],
				'original' => [ 'width' => 300, 'height' => 200 ]
			],
			[
				'custom' => 400,
				'preferred' => 300,
				'result' => [ 'width' => 300, 'height' => 200 ],
				'thumbnail' => [ 'width' => 300, 'height' => 200 ],
				'thumbnail2x' => [ 'width' => 600, 'height' => 400 ],
				'original' => [ 'width' => 300, 'height' => 200 ]
			],
			[
				'custom' => 400,
				'preferred' => 300,
				'result' => [ 'width' => 300, 'height' => 180 ],
				'thumbnail' => [ 'width' => 400, 'height' => 240 ],
				'thumbnail2x' => [ 'width' => 800, 'height' => 480 ],
				'original' => [ 'width' => 500, 'height' => 300 ]
			],
			[
				'custom' => 600,
				'preferred' => 300,
				'result' => [ 'width' => 300, 'height' => 500 ],
				'thumbnail' => [ 'width' => 300, 'height' => 500 ],
				'thumbnail2x' => [ 'width' => 600, 'height' => 1000 ],
				'original' => [ 'width' => 300, 'height' => 500 ]
			],
			[
				'custom' => 600,
				'preferred' => 300,
				'result' => [ 'width' => 188, 'height' => 500 ],
				'thumbnail' => [ 'width' => 188, 'height' => 500 ],
				'thumbnail2x' => [ 'width' => 376, 'height' => 1000 ],
				'original' => [ 'width' => 300, 'height' => 800 ]
			],
			[
				'custom' => 600,
				'preferred' => 300,
				'result' => [ 'width' => 300, 'height' => 375 ],
				'thumbnail' => [ 'width' => 600, 'height' => 750 ],
				'thumbnail2x' => [ 'width' => 1200, 'height' => 1500 ],
				'original' => [ 'width' => 1200, 'height' => 1500 ]
			],
		];
	}

}
