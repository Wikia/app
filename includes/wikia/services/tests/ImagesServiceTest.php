<?php

class ImagesServiceTest extends WikiaBaseTest {

	/**
	 * @dataProvider calculateScaledImageSizesDataProvider
	 */
	public function testCalculateScaledImageSizes( $desiredImageSize, $originalSizes, $results ) {
		$expected = new stdClass();
		$expected->width = $results['width'];
		$expected->height = $results['height'];

		$result = ImagesService::calculateScaledImageSizes( $desiredImageSize, $originalSizes['width'], $originalSizes['height'] );

		$this->assertEquals( $result, $expected );
	}

	public function calculateScaledImageSizesDataProvider() {
		return array(
			//edge case #1
			array(
				'desiredImageSize' => 0,
				'orginalSize' => array(
					'width' => 0,
					'height' => 0,
				),
				'results' => array(
					'width' => 0,
					'height' => 0,
				),
			),
			//edge case #2
			array(
				'desiredImageSize' => 0,
				'orginalSize' => array(
					'width' => 150,
					'height' => 150,
				),
				'results' => array(
					'width' => 0,
					'height' => 0,
				),
			),
			//desired size equals both dimensions of original image
			array(
				'desiredImageSize' => 150,
				'orginalSize' => array(
					'width' => 150,
					'height' => 150,
				),
				'results' => array(
					'width' => 150,
					'height' => 150,
				),
			),
			//desired size is smaller than both dimensions of original image (width is the higher one)
			array(
				'desiredImageSize' => 180,
				'orginalSize' => array(
					'width' => 560,
					'height' => 280,
				),
				'results' => array(
					'width' => 180,
					'height' => 90,
				),
			),
			//desired size is smaller than both dimensions of original image (height is the higher one)
			array(
				'desiredImageSize' => 180,
				'orginalSize' => array(
					'width' => 280,
					'height' => 560,
				),
				'results' => array(
					'width' => 90,
					'height' => 180,
				),
			),
			//desired size is smaller than both dimensions of original image (width is the higher one and desired size is odd)
			array(
				'desiredImageSize' => 133,
				'orginalSize' => array(
					'width' => 600,
					'height' => 480,
				),
				'results' => array(
					'width' => 133,
					'height' => 106,
				),
			),
			//desired size is smaller than one original dimensions of original image (height is the higher one and desired size is odd)
			array(
				'desiredImageSize' => 155,
				'orginalSize' => array(
					'width' => 123,
					'height' => 654,
				),
				'results' => array(
					'width' => 29,
					'height' => 155,
				),
			),
		);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.03929 ms
	 * @dataProvider getLocalFileThumbUrlAndSizesDataProvider
	 */
	public function testGetLocalFileThumbUrlAndSizes( $destImageWidth, $image, $results ) {
		$titleGetTextResult = 'TEST TEXT';
		$fileGetThumbUrlResult = 'TEST_URL';

		$titleMock = $this->getMock( 'Title', array( 'getText' ), array(), '', false );
		$titleMock->expects( $this->any() )
			->method( 'getText' )
			->will( $this->returnValue( $titleGetTextResult ) );

		$fileMock = $this->getMock( 'WikiaLocalFile', array( 'getWidth', 'getHeight', 'createThumb' ), array(), '', false );
		$fileMock->expects( $this->once() )
			->method( 'getWidth' )
			->will( $this->returnValue( $image['width'] ) );
		$fileMock->expects( $this->once() )
			->method( 'getHeight' )
			->will( $this->returnValue( $image['height'] ) );
		$fileMock->expects( $this->once() )
			->method( 'createThumb' )
			->will( $this->returnValue( $fileGetThumbUrlResult ) );

		$this->mockGlobalFunction( 'wfFindFile', $fileMock );

		$expected = new stdClass();
		$expected->width = $results['width'];
		$expected->height = $results['height'];
		$expected->title = $titleGetTextResult;
		$expected->url = $fileGetThumbUrlResult;

		$result = ImagesService::getLocalFileThumbUrlAndSizes( $titleGetTextResult, $destImageWidth );

		$this->assertEquals( $result, $expected );
	}

	public function getLocalFileThumbUrlAndSizesDataProvider() {
		return array(
			//destination image width given, so the result will be different than original
			array(
				'destImageWidth' => 85,
				'image' => array(
					'width' => 60,
					'height' => 10,
				),
				'results' => array(
					'width' => 85,
					'height' => 14,
				),
			),
			//destination image width not given, so the result will be the same as original
			array(
				'destImageWidth' => 0,
				'image' => array(
					'width' => 60,
					'height' => 10,
				),
				'results' => array(
					'width' => 60,
					'height' => 10,
				),
			),
		);
	}

	/**
	 * @dataProvider getFileUrlFromThumbUrlDataProvider
	 */
	public function getFileUrlFromThumbUrl( $imageUrl, $thumbUrl ) {
		$this->assertEquals(
			$imageUrl,
			ImagesService::getFileUrlFromThumbUrl( $thumbUrl )
		);
	}

	public function getFileUrlFromThumbUrlDataProvider() {
		return [
			[
				'imageUrl' => 'http://images4.wikia.nocookie.net/__cb62277/wikiaglobal/images/f/f3/Wikia-Visualization-Main%2Cenanimanga.png',
				'thumbUrl' => 'http://images4.wikia.nocookie.net/__cb62277/wikiaglobal/images/thumb/f/f3/Wikia-Visualization-Main%2Cenanimanga.png/50px-Wikia-Visualization-Main%2Cenanimanga.png'
			],
			[
				'imageUrl' => 'http://images.damian.wikia-dev.com/__cb1378818316/wikiaglobal/images/8/8b/Wikia-Visualization-Main%2Crunescape.png',
				'thumbUrl' => 'http://images.damian.wikia-dev.com/__cb1378818316/wikiaglobal/images/thumb/8/8b/Wikia-Visualization-Main%2Crunescape.png/50px-Wikia-Visualization-Main%2Crunescape.png'
			],
			[
				'imageUrl' => 'http://images.damian.wikia-dev.com/__cb1378818316/wikiaglobal/images/8/8b/Wikia-Visualization-Main%2Crunescape.png/100px-Wikia-Visualization-Main%2Crunescape.png',
				'thumbUrl' => 'http://images.damian.wikia-dev.com/__cb1378818316/wikiaglobal/images/8/8b/Wikia-Visualization-Main%2Crunescape.png/100px-Wikia-Visualization-Main%2Crunescape.png'
			]
		];
	}

	public function testGetCut() {
		$sampleData = [ [ 100, 100, 100, 100, '100px-0,101,0,100' ], [ 100, 100, 100, 200, '100px-0,100,0,100' ], [ 100, 100, 100, 150, '100px-0,100,0,100' ], [ 100, 100, 200, 100, '100px-51,152,0,100' ], [ 100, 100, 200, 200, '100px-0,201,0,200' ], [ 100, 100, 200, 150, '100px-26,177,0,150' ], [ 100, 100, 150, 100, '100px-26,127,0,100' ], [ 100, 100, 150, 200, '100px-0,150,0,150' ], [ 100, 100, 150, 150, '100px-0,151,0,150' ], [ 100, 200, 100, 100, '100px-26,77,0,100' ], [ 100, 200, 100, 200, '100px-0,101,0,200' ], [ 100, 200, 100, 150, '100px-14,90,0,150' ], [ 100, 200, 200, 100, '100px-76,127,0,100' ], [ 100, 200, 200, 200, '100px-51,152,0,200' ], [ 100, 200, 200, 150, '100px-64,140,0,150' ], [ 100, 200, 150, 100, '100px-51,102,0,100' ], [ 100, 200, 150, 200, '100px-26,127,0,200' ], [ 100, 200, 150, 150, '100px-39,115,0,150' ], [ 100, 150, 100, 100, '100px-18,86,0,100' ], [ 100, 150, 100, 200, '100px-0,100,-7,143' ], [ 100, 150, 100, 150, '100px-0,101,0,150' ], [ 100, 150, 200, 100, '100px-68,136,0,100' ], [ 100, 150, 200, 200, '100px-35,169,0,200' ], [ 100, 150, 200, 150, '100px-51,152,0,150' ], [ 100, 150, 150, 100, '100px-43,111,0,100' ], [ 100, 150, 150, 200, '100px-10,144,0,200' ], [ 100, 150, 150, 150, '100px-26,127,0,150' ], [ 200, 100, 100, 100, '200px-0,100,10,60' ], [ 200, 100, 100, 200, '200px-0,100,20,70' ], [ 200, 100, 100, 150, '200px-0,100,15,65' ], [ 200, 100, 200, 100, '200px-0,201,0,100' ], [ 200, 100, 200, 200, '200px-0,200,20,120' ], [ 200, 100, 200, 150, '200px-0,200,15,115' ], [ 200, 100, 150, 100, '200px-0,150,10,85' ], [ 200, 100, 150, 200, '200px-0,150,20,95' ], [ 200, 100, 150, 150, '200px-0,150,15,90' ], [ 200, 200, 100, 100, '200px-0,101,0,100' ], [ 200, 200, 100, 200, '200px-0,100,0,100' ], [ 200, 200, 100, 150, '200px-0,100,0,100' ], [ 200, 200, 200, 100, '200px-51,152,0,100' ], [ 200, 200, 200, 200, '200px-0,201,0,200' ], [ 200, 200, 200, 150, '200px-26,177,0,150' ], [ 200, 200, 150, 100, '200px-26,127,0,100' ], [ 200, 200, 150, 200, '200px-0,150,0,150' ], [ 200, 200, 150, 150, '200px-0,151,0,150' ], [ 200, 150, 100, 100, '200px-0,100,3,78' ], [ 200, 150, 100, 200, '200px-0,100,7,82' ], [ 200, 150, 100, 150, '200px-0,100,5,80' ], [ 200, 150, 200, 100, '200px-35,169,0,100' ], [ 200, 150, 200, 200, '200px-0,200,7,157' ], [ 200, 150, 200, 150, '200px-0,201,0,150' ], [ 200, 150, 150, 100, '200px-10,144,0,100' ], [ 200, 150, 150, 200, '200px-0,150,7,120' ], [ 200, 150, 150, 150, '200px-0,150,5,118' ], [ 150, 100, 100, 100, '150px-0,100,5,72' ], [ 150, 100, 100, 200, '150px-0,100,10,77' ], [ 150, 100, 100, 150, '150px-0,100,8,75' ], [ 150, 100, 200, 100, '150px-26,177,0,100' ], [ 150, 100, 200, 200, '150px-0,200,10,143' ], [ 150, 100, 200, 150, '150px-0,200,8,141' ], [ 150, 100, 150, 100, '150px-0,151,0,100' ], [ 150, 100, 150, 200, '150px-0,150,10,110' ], [ 150, 100, 150, 150, '150px-0,150,8,108' ], [ 150, 200, 100, 100, '150px-14,90,0,100' ], [ 150, 200, 100, 200, '150px-0,100,-5,128' ], [ 150, 200, 100, 150, '150px-0,100,-4,129' ], [ 150, 200, 200, 100, '150px-64,140,0,100' ], [ 150, 200, 200, 200, '150px-26,177,0,200' ], [ 150, 200, 200, 150, '150px-45,159,0,150' ], [ 150, 200, 150, 100, '150px-39,115,0,100' ], [ 150, 200, 150, 200, '150px-0,151,0,200' ], [ 150, 200, 150, 150, '150px-20,134,0,150' ], [ 150, 150, 100, 100, '150px-0,101,0,100' ], [ 150, 150, 100, 200, '150px-0,100,0,100' ], [ 150, 150, 100, 150, '150px-0,100,0,100' ], [ 150, 150, 200, 100, '150px-51,152,0,100' ], [ 150, 150, 200, 200, '150px-0,201,0,200' ], [ 150, 150, 200, 150, '150px-26,177,0,150' ], [ 150, 150, 150, 100, '150px-26,127,0,100' ], [ 150, 150, 150, 200, '150px-0,150,0,150' ], [ 150, 150, 150, 150, '150px-0,151,0,150' ] ];

		foreach ( $sampleData as $data ) {
			$this->assertEquals( ImagesService::getCut( $data[0], $data[0], $data[1], $data[2], $data[3] ), $data[4] );
		}
	}

	public function testBetterCutData() {
		$sample = [ [ null, 100, 100, 100, 100, '100px-0,101,0,100' ], [ 2, 100, 100, 100, 100, '100px-0,101,0,100' ], [ 0.5, 100, 100, 100, 100, '100px-0,101,0,100' ], [ null, 100, 100, 100, 200, '100px-0,100,0,100' ], [ 2, 100, 100, 100, 200, '100px-0,100,0,100' ], [ 0.5, 100, 100, 100, 200, '100px-0,100,100,200' ], [ null, 100, 100, 100, 150, '100px-0,100,0,100' ], [ 2, 100, 100, 100, 150, '100px-0,100,0,100' ], [ 0.5, 100, 100, 100, 150, '100px-0,100,0,100' ], [ null, 100, 100, 200, 100, '100px-51,152,0,100' ], [ 2, 100, 100, 200, 100, '100px-51,152,0,100' ], [ 0.5, 100, 100, 200, 100, '100px-51,152,0,100' ], [ null, 100, 100, 200, 200, '100px-0,201,0,200' ], [ 2, 100, 100, 200, 200, '100px-0,201,0,200' ], [ 0.5, 100, 100, 200, 200, '100px-0,201,0,200' ], [ null, 100, 100, 200, 150, '100px-26,177,0,150' ], [ 2, 100, 100, 200, 150, '100px-26,177,0,150' ], [ 0.5, 100, 100, 200, 150, '100px-26,177,0,150' ], [ null, 100, 100, 150, 100, '100px-26,127,0,100' ], [ 2, 100, 100, 150, 100, '100px-26,127,0,100' ], [ 0.5, 100, 100, 150, 100, '100px-26,127,0,100' ], [ null, 100, 100, 150, 200, '100px-0,150,0,150' ], [ 2, 100, 100, 150, 200, '100px-0,150,0,150' ], [ 0.5, 100, 100, 150, 200, '100px-0,150,0,150' ], [ null, 100, 100, 150, 150, '100px-0,151,0,150' ], [ 2, 100, 100, 150, 150, '100px-0,151,0,150' ], [ 0.5, 100, 100, 150, 150, '100px-0,151,0,150' ], [ null, 100, 200, 100, 100, '100px-26,77,0,100' ], [ 2, 100, 200, 100, 100, '100px-26,77,0,100' ], [ 0.5, 100, 200, 100, 100, '100px-26,77,0,100' ], [ null, 100, 200, 100, 200, '100px-0,101,0,200' ], [ 2, 100, 200, 100, 200, '100px-0,101,0,200' ], [ 0.5, 100, 200, 100, 200, '100px-0,101,0,200' ], [ null, 100, 200, 100, 150, '100px-14,90,0,150' ], [ 2, 100, 200, 100, 150, '100px-14,90,0,150' ], [ 0.5, 100, 200, 100, 150, '100px-14,90,0,150' ], [ null, 100, 200, 200, 100, '100px-76,127,0,100' ], [ 2, 100, 200, 200, 100, '100px-76,127,0,100' ], [ 0.5, 100, 200, 200, 100, '100px-76,127,0,100' ], [ null, 100, 200, 200, 200, '100px-51,152,0,200' ], [ 2, 100, 200, 200, 200, '100px-51,152,0,200' ], [ 0.5, 100, 200, 200, 200, '100px-51,152,0,200' ], [ null, 100, 200, 200, 150, '100px-64,140,0,150' ], [ 2, 100, 200, 200, 150, '100px-64,140,0,150' ], [ 0.5, 100, 200, 200, 150, '100px-64,140,0,150' ], [ null, 100, 200, 150, 100, '100px-51,102,0,100' ], [ 2, 100, 200, 150, 100, '100px-51,102,0,100' ], [ 0.5, 100, 200, 150, 100, '100px-51,102,0,100' ], [ null, 100, 200, 150, 200, '100px-26,127,0,200' ], [ 2, 100, 200, 150, 200, '100px-26,127,0,200' ], [ 0.5, 100, 200, 150, 200, '100px-26,127,0,200' ], [ null, 100, 200, 150, 150, '100px-39,115,0,150' ], [ 2, 100, 200, 150, 150, '100px-39,115,0,150' ], [ 0.5, 100, 200, 150, 150, '100px-39,115,0,150' ], [ null, 100, 150, 100, 100, '100px-18,86,0,100' ], [ 2, 100, 150, 100, 100, '100px-18,86,0,100' ], [ 0.5, 100, 150, 100, 100, '100px-18,86,0,100' ], [ null, 100, 150, 100, 200, '100px-0,100,-7,143' ], [ 2, 100, 150, 100, 200, '100px-0,100,0,150' ], [ 0.5, 100, 150, 100, 200, '100px-0,100,0,150' ], [ null, 100, 150, 100, 150, '100px-0,101,0,150' ], [ 2, 100, 150, 100, 150, '100px-0,101,0,150' ], [ 0.5, 100, 150, 100, 150, '100px-0,101,0,150' ], [ null, 100, 150, 200, 100, '100px-68,136,0,100' ], [ 2, 100, 150, 200, 100, '100px-68,136,0,100' ], [ 0.5, 100, 150, 200, 100, '100px-68,136,0,100' ], [ null, 100, 150, 200, 200, '100px-35,169,0,200' ], [ 2, 100, 150, 200, 200, '100px-35,169,0,200' ], [ 0.5, 100, 150, 200, 200, '100px-35,169,0,200' ], [ null, 100, 150, 200, 150, '100px-51,152,0,150' ], [ 2, 100, 150, 200, 150, '100px-51,152,0,150' ], [ 0.5, 100, 150, 200, 150, '100px-51,152,0,150' ], [ null, 100, 150, 150, 100, '100px-43,111,0,100' ], [ 2, 100, 150, 150, 100, '100px-43,111,0,100' ], [ 0.5, 100, 150, 150, 100, '100px-43,111,0,100' ], [ null, 100, 150, 150, 200, '100px-10,144,0,200' ], [ 2, 100, 150, 150, 200, '100px-10,144,0,200' ], [ 0.5, 100, 150, 150, 200, '100px-10,144,0,200' ], [ null, 100, 150, 150, 150, '100px-26,127,0,150' ], [ 2, 100, 150, 150, 150, '100px-26,127,0,150' ], [ 0.5, 100, 150, 150, 150, '100px-26,127,0,150' ], [ null, 200, 100, 100, 100, '200px-0,100,10,60' ], [ 2, 200, 100, 100, 100, '200px-0,100,0,50' ], [ 0.5, 200, 100, 100, 100, '200px-0,100,50,100' ], [ null, 200, 100, 100, 200, '200px-0,100,20,70' ], [ 2, 200, 100, 100, 200, '200px-0,100,0,50' ], [ 0.5, 200, 100, 100, 200, '200px-0,100,100,150' ], [ null, 200, 100, 100, 150, '200px-0,100,15,65' ], [ 2, 200, 100, 100, 150, '200px-0,100,0,50' ], [ 0.5, 200, 100, 100, 150, '200px-0,100,75,125' ], [ null, 200, 100, 200, 100, '200px-0,201,0,100' ], [ 2, 200, 100, 200, 100, '200px-0,201,0,100' ], [ 0.5, 200, 100, 200, 100, '200px-0,201,0,100' ], [ null, 200, 100, 200, 200, '200px-0,200,20,120' ], [ 2, 200, 100, 200, 200, '200px-0,200,0,100' ], [ 0.5, 200, 100, 200, 200, '200px-0,200,100,200' ], [ null, 200, 100, 200, 150, '200px-0,200,15,115' ], [ 2, 200, 100, 200, 150, '200px-0,200,0,100' ], [ 0.5, 200, 100, 200, 150, '200px-0,200,0,100' ], [ null, 200, 100, 150, 100, '200px-0,150,10,85' ], [ 2, 200, 100, 150, 100, '200px-0,150,0,75' ], [ 0.5, 200, 100, 150, 100, '200px-0,150,0,75' ], [ null, 200, 100, 150, 200, '200px-0,150,20,95' ], [ 2, 200, 100, 150, 200, '200px-0,150,0,75' ], [ 0.5, 200, 100, 150, 200, '200px-0,150,100,175' ], [ null, 200, 100, 150, 150, '200px-0,150,15,90' ], [ 2, 200, 100, 150, 150, '200px-0,150,0,75' ], [ 0.5, 200, 100, 150, 150, '200px-0,150,75,150' ], [ null, 200, 200, 100, 100, '200px-0,101,0,100' ], [ 2, 200, 200, 100, 100, '200px-0,101,0,100' ], [ 0.5, 200, 200, 100, 100, '200px-0,101,0,100' ], [ null, 200, 200, 100, 200, '200px-0,100,0,100' ], [ 2, 200, 200, 100, 200, '200px-0,100,0,100' ], [ 0.5, 200, 200, 100, 200, '200px-0,100,100,200' ], [ null, 200, 200, 100, 150, '200px-0,100,0,100' ], [ 2, 200, 200, 100, 150, '200px-0,100,0,100' ], [ 0.5, 200, 200, 100, 150, '200px-0,100,0,100' ], [ null, 200, 200, 200, 100, '200px-51,152,0,100' ], [ 2, 200, 200, 200, 100, '200px-51,152,0,100' ], [ 0.5, 200, 200, 200, 100, '200px-51,152,0,100' ], [ null, 200, 200, 200, 200, '200px-0,201,0,200' ], [ 2, 200, 200, 200, 200, '200px-0,201,0,200' ], [ 0.5, 200, 200, 200, 200, '200px-0,201,0,200' ], [ null, 200, 200, 200, 150, '200px-26,177,0,150' ], [ 2, 200, 200, 200, 150, '200px-26,177,0,150' ], [ 0.5, 200, 200, 200, 150, '200px-26,177,0,150' ], [ null, 200, 200, 150, 100, '200px-26,127,0,100' ], [ 2, 200, 200, 150, 100, '200px-26,127,0,100' ], [ 0.5, 200, 200, 150, 100, '200px-26,127,0,100' ], [ null, 200, 200, 150, 200, '200px-0,150,0,150' ], [ 2, 200, 200, 150, 200, '200px-0,150,0,150' ], [ 0.5, 200, 200, 150, 200, '200px-0,150,0,150' ], [ null, 200, 200, 150, 150, '200px-0,151,0,150' ], [ 2, 200, 200, 150, 150, '200px-0,151,0,150' ], [ 0.5, 200, 200, 150, 150, '200px-0,151,0,150' ], [ null, 200, 150, 100, 100, '200px-0,100,3,78' ], [ 2, 200, 150, 100, 100, '200px-0,100,0,75' ], [ 0.5, 200, 150, 100, 100, '200px-0,100,0,75' ], [ null, 200, 150, 100, 200, '200px-0,100,7,82' ], [ 2, 200, 150, 100, 200, '200px-0,100,0,75' ], [ 0.5, 200, 150, 100, 200, '200px-0,100,100,175' ], [ null, 200, 150, 100, 150, '200px-0,100,5,80' ], [ 2, 200, 150, 100, 150, '200px-0,100,0,75' ], [ 0.5, 200, 150, 100, 150, '200px-0,100,75,150' ], [ null, 200, 150, 200, 100, '200px-35,169,0,100' ], [ 2, 200, 150, 200, 100, '200px-35,169,0,100' ], [ 0.5, 200, 150, 200, 100, '200px-35,169,0,100' ], [ null, 200, 150, 200, 200, '200px-0,200,7,157' ], [ 2, 200, 150, 200, 200, '200px-0,200,0,150' ], [ 0.5, 200, 150, 200, 200, '200px-0,200,0,150' ], [ null, 200, 150, 200, 150, '200px-0,201,0,150' ], [ 2, 200, 150, 200, 150, '200px-0,201,0,150' ], [ 0.5, 200, 150, 200, 150, '200px-0,201,0,150' ], [ null, 200, 150, 150, 100, '200px-10,144,0,100' ], [ 2, 200, 150, 150, 100, '200px-10,144,0,100' ], [ 0.5, 200, 150, 150, 100, '200px-10,144,0,100' ], [ null, 200, 150, 150, 200, '200px-0,150,7,120' ], [ 2, 200, 150, 150, 200, '200px-0,150,0,113' ], [ 0.5, 200, 150, 150, 200, '200px-0,150,0,113' ], [ null, 200, 150, 150, 150, '200px-0,150,5,118' ], [ 2, 200, 150, 150, 150, '200px-0,150,0,113' ], [ 0.5, 200, 150, 150, 150, '200px-0,150,0,113' ], [ null, 150, 100, 100, 100, '150px-0,100,5,72' ], [ 2, 150, 100, 100, 100, '150px-0,100,0,67' ], [ 0.5, 150, 100, 100, 100, '150px-0,100,0,67' ], [ null, 150, 100, 100, 200, '150px-0,100,10,77' ], [ 2, 150, 100, 100, 200, '150px-0,100,0,67' ], [ 0.5, 150, 100, 100, 200, '150px-0,100,100,167' ], [ null, 150, 100, 100, 150, '150px-0,100,8,75' ], [ 2, 150, 100, 100, 150, '150px-0,100,0,67' ], [ 0.5, 150, 100, 100, 150, '150px-0,100,75,142' ], [ null, 150, 100, 200, 100, '150px-26,177,0,100' ], [ 2, 150, 100, 200, 100, '150px-26,177,0,100' ], [ 0.5, 150, 100, 200, 100, '150px-26,177,0,100' ], [ null, 150, 100, 200, 200, '150px-0,200,10,143' ], [ 2, 150, 100, 200, 200, '150px-0,200,0,133' ], [ 0.5, 150, 100, 200, 200, '150px-0,200,0,133' ], [ null, 150, 100, 200, 150, '150px-0,200,8,141' ], [ 2, 150, 100, 200, 150, '150px-0,200,0,133' ], [ 0.5, 150, 100, 200, 150, '150px-0,200,0,133' ], [ null, 150, 100, 150, 100, '150px-0,151,0,100' ], [ 2, 150, 100, 150, 100, '150px-0,151,0,100' ], [ 0.5, 150, 100, 150, 100, '150px-0,151,0,100' ], [ null, 150, 100, 150, 200, '150px-0,150,10,110' ], [ 2, 150, 100, 150, 200, '150px-0,150,0,100' ], [ 0.5, 150, 100, 150, 200, '150px-0,150,100,200' ], [ null, 150, 100, 150, 150, '150px-0,150,8,108' ], [ 2, 150, 100, 150, 150, '150px-0,150,0,100' ], [ 0.5, 150, 100, 150, 150, '150px-0,150,0,100' ], [ null, 150, 200, 100, 100, '150px-14,90,0,100' ], [ 2, 150, 200, 100, 100, '150px-14,90,0,100' ], [ 0.5, 150, 200, 100, 100, '150px-14,90,0,100' ], [ null, 150, 200, 100, 200, '150px-0,100,-5,128' ], [ 2, 150, 200, 100, 200, '150px-0,100,0,133' ], [ 0.5, 150, 200, 100, 200, '150px-0,100,0,133' ], [ null, 150, 200, 100, 150, '150px-0,100,-4,129' ], [ 2, 150, 200, 100, 150, '150px-0,100,0,133' ], [ 0.5, 150, 200, 100, 150, '150px-0,100,0,133' ], [ null, 150, 200, 200, 100, '150px-64,140,0,100' ], [ 2, 150, 200, 200, 100, '150px-64,140,0,100' ], [ 0.5, 150, 200, 200, 100, '150px-64,140,0,100' ], [ null, 150, 200, 200, 200, '150px-26,177,0,200' ], [ 2, 150, 200, 200, 200, '150px-26,177,0,200' ], [ 0.5, 150, 200, 200, 200, '150px-26,177,0,200' ], [ null, 150, 200, 200, 150, '150px-45,159,0,150' ], [ 2, 150, 200, 200, 150, '150px-45,159,0,150' ], [ 0.5, 150, 200, 200, 150, '150px-45,159,0,150' ], [ null, 150, 200, 150, 100, '150px-39,115,0,100' ], [ 2, 150, 200, 150, 100, '150px-39,115,0,100' ], [ 0.5, 150, 200, 150, 100, '150px-39,115,0,100' ], [ null, 150, 200, 150, 200, '150px-0,151,0,200' ], [ 2, 150, 200, 150, 200, '150px-0,151,0,200' ], [ 0.5, 150, 200, 150, 200, '150px-0,151,0,200' ], [ null, 150, 200, 150, 150, '150px-20,134,0,150' ], [ 2, 150, 200, 150, 150, '150px-20,134,0,150' ], [ 0.5, 150, 200, 150, 150, '150px-20,134,0,150' ], [ null, 150, 150, 100, 100, '150px-0,101,0,100' ], [ 2, 150, 150, 100, 100, '150px-0,101,0,100' ], [ 0.5, 150, 150, 100, 100, '150px-0,101,0,100' ], [ null, 150, 150, 100, 200, '150px-0,100,0,100' ], [ 2, 150, 150, 100, 200, '150px-0,100,0,100' ], [ 0.5, 150, 150, 100, 200, '150px-0,100,100,200' ], [ null, 150, 150, 100, 150, '150px-0,100,0,100' ], [ 2, 150, 150, 100, 150, '150px-0,100,0,100' ], [ 0.5, 150, 150, 100, 150, '150px-0,100,0,100' ], [ null, 150, 150, 200, 100, '150px-51,152,0,100' ], [ 2, 150, 150, 200, 100, '150px-51,152,0,100' ], [ 0.5, 150, 150, 200, 100, '150px-51,152,0,100' ], [ null, 150, 150, 200, 200, '150px-0,201,0,200' ], [ 2, 150, 150, 200, 200, '150px-0,201,0,200' ], [ 0.5, 150, 150, 200, 200, '150px-0,201,0,200' ], [ null, 150, 150, 200, 150, '150px-26,177,0,150' ], [ 2, 150, 150, 200, 150, '150px-26,177,0,150' ], [ 0.5, 150, 150, 200, 150, '150px-26,177,0,150' ], [ null, 150, 150, 150, 100, '150px-26,127,0,100' ], [ 2, 150, 150, 150, 100, '150px-26,127,0,100' ], [ 0.5, 150, 150, 150, 100, '150px-26,127,0,100' ], [ null, 150, 150, 150, 200, '150px-0,150,0,150' ], [ 2, 150, 150, 150, 200, '150px-0,150,0,150' ], [ 0.5, 150, 150, 150, 200, '150px-0,150,0,150' ], [ null, 150, 150, 150, 150, '150px-0,151,0,150' ], [ 2, 150, 150, 150, 150, '150px-0,151,0,150' ], [ 0.5, 150, 150, 150, 150, '150px-0,151,0,150' ], ];
		foreach ( $sample as $data ) {
			$tmpDeltaY = $data[0];
			array_shift( $data );
			$this->assertEquals( ImagesService::getCut( $data[0], $data[0], $data[1], $data[2], $data[3], "center", false, $tmpDeltaY ), $data[4] );
		}
	}

	public function testGetCroppedThumbnailUrl() {
		$img = 'http://images4.wikia.nocookie.net/__cb62277/wikiaglobal/images/f/f3/Wikia-Visualization-Main%2Cenanimanga.png';
		$img = 'http://img3.wikia.nocookie.net/__cb20131128123957/wikiaglobal/images/0/03/Wikia-Visualization-Main%2Carkhamcity.png';
		$srcWidth = 579;
		$srcHeight = 327;
		$destWidth = 480;
		$destHeight = 320;

		$expected = urldecode( 'http://img3.wikia.nocookie.net/__cb20131128123957/wikiaglobal/images/thumb/0/03/Wikia-Visualization-Main%2Carkhamcity.png/480px-45%2C537%2C0%2C327-Wikia-Visualization-Main%2Carkhamcity.png.jpg' );

		$this->assertEquals( $expected, urldecode( ImagesService::getCroppedThumbnailUrl( $img, $destWidth, $destHeight, $srcWidth, $srcHeight, ImagesService::EXT_JPG ) ) );
	}

	/**
	 * @dataProvider getThumbUrlFromFileUrlDataProvider
	 */
	public function testGetThumbUrlFromFileUrl( $imageUrl, $destSize, $newExtension, $expected ) {
		$this->assertEquals(
			$expected,
			ImagesService::getThumbUrlFromFileUrl( $imageUrl, $destSize, $newExtension )
		);
	}

	public function getThumbUrlFromFileUrlDataProvider() {
		return [
			[
				'imageUrl' => 'http://images4.wikia.nocookie.net/__cb62277/wikiaglobal/images/f/f3/Wikia-Visualization-Main%2Cenanimanga.png',
				'destSize' => '50',
				'newExtension' => null,
				'expected' => 'http://images4.wikia.nocookie.net/__cb62277/wikiaglobal/images/thumb/f/f3/Wikia-Visualization-Main%2Cenanimanga.png/50px-Wikia-Visualization-Main%2Cenanimanga.png'
			],
			[
				'imageUrl' => 'http://images.damian.wikia-dev.com/__cb1378818316/wikiaglobal/images/8/8b/Wikia-Visualization-Main%2Crunescape.png',
				'destSize' => '50',
				'newExtension' => null,
				'expected' => 'http://images.damian.wikia-dev.com/__cb1378818316/wikiaglobal/images/thumb/8/8b/Wikia-Visualization-Main%2Crunescape.png/50px-Wikia-Visualization-Main%2Crunescape.png'
			],
			[
				'imageUrl' => 'http://images.damian.wikia-dev.com/__cb1378818316/wikiaglobal/images/8/8b/Wikia-Visualization-Main%2Crunescape.png',
				'destSize' => '100',
				'newExtension' => null,
				'expected' => 'http://images.damian.wikia-dev.com/__cb1378818316/wikiaglobal/images/thumb/8/8b/Wikia-Visualization-Main%2Crunescape.png/100px-Wikia-Visualization-Main%2Crunescape.png'
			],
			[
				'imageUrl' => 'http://images.damian.wikia-dev.com/__cb1378818316/wikiaglobal/images/8/8b/Wikia-Visualization-Main%2Crunescape.png',
				'destSize' => '75px',
				'newExtension' => null,
				'expected' => 'http://images.damian.wikia-dev.com/__cb1378818316/wikiaglobal/images/thumb/8/8b/Wikia-Visualization-Main%2Crunescape.png/75px-Wikia-Visualization-Main%2Crunescape.png'
			],
			[
				'imageUrl' => 'http://images.damian.wikia-dev.com/__cb1378818316/wikiaglobal/images/thumb/8/8b/Wikia-Visualization-Main%2Crunescape.png',
				'destSize' => '75px',
				'newExtension' => null,
				'expected' => 'http://images.damian.wikia-dev.com/__cb1378818316/wikiaglobal/images/thumb/8/8b/Wikia-Visualization-Main%2Crunescape.png/75px-Wikia-Visualization-Main%2Crunescape.png'
			],
			[
				'imageUrl' => 'http://images.damian.wikia-dev.com/__cb1378818316/wikiaglobal/images/thumb/8/8b/Wikia-Visualization-Main%2Crunescape.png',
				'destSize' => '50x60',
				'newExtension' => null,
				'expected' => 'http://images.damian.wikia-dev.com/__cb1378818316/wikiaglobal/images/thumb/8/8b/Wikia-Visualization-Main%2Crunescape.png/50x60-Wikia-Visualization-Main%2Crunescape.png'
			],
			[
				'imageUrl' => 'http://images.damian.wikia-dev.com/__cb1378818316/wikiaglobal/images/thumb/8/8b/Wikia-Visualization-Main%2Crunescape.png',
				'destSize' => '100x200',
				'newExtension' => null,
				'expected' => 'http://images.damian.wikia-dev.com/__cb1378818316/wikiaglobal/images/thumb/8/8b/Wikia-Visualization-Main%2Crunescape.png/100x200-Wikia-Visualization-Main%2Crunescape.png'
			],
			[
				'imageUrl' => 'http://images4.wikia.nocookie.net/__cb62277/wikiaglobal/images/f/f3/Wikia-Visualization-Main%2Cenanimanga.png',
				'destSize' => '50',
				'newExtension' => ImagesService::EXT_PNG,
				'expected' => 'http://images4.wikia.nocookie.net/__cb62277/wikiaglobal/images/thumb/f/f3/Wikia-Visualization-Main%2Cenanimanga.png/50px-Wikia-Visualization-Main%2Cenanimanga.png'
			],
			[
				'imageUrl' => 'http://images4.wikia.nocookie.net/__cb62277/wikiaglobal/images/f/f3/Wikia-Visualization-Main%2Cenanimanga.png',
				'destSize' => '50',
				'newExtension' => ImagesService::EXT_JPG,
				'expected' => 'http://images4.wikia.nocookie.net/__cb62277/wikiaglobal/images/thumb/f/f3/Wikia-Visualization-Main%2Cenanimanga.png/50px-Wikia-Visualization-Main%2Cenanimanga.png.jpg'
			],
			[
				'imageUrl' => 'http://images4.wikia.nocookie.net/__cb62277/wikiaglobal/images/f/f3/Wikia-Visualization-Main%2Cenanimanga.png',
				'destSize' => '50',
				'newExtension' => ImagesService::EXT_JPEG,
				'expected' => 'http://images4.wikia.nocookie.net/__cb62277/wikiaglobal/images/thumb/f/f3/Wikia-Visualization-Main%2Cenanimanga.png/50px-Wikia-Visualization-Main%2Cenanimanga.png.jpeg'
			],
			[
				'imageUrl' => 'http://images4.wikia.nocookie.net/__cb62277/wikiaglobal/images/f/f3/Wikia-Visualization-Main%2Cenanimanga.png',
				'destSize' => '50',
				'newExtension' => ImagesService::EXT_GIF,
				'expected' => 'http://images4.wikia.nocookie.net/__cb62277/wikiaglobal/images/thumb/f/f3/Wikia-Visualization-Main%2Cenanimanga.png/50px-Wikia-Visualization-Main%2Cenanimanga.png.gif'
			],
			[
				'imageUrl' => 'http://images2.wikia.nocookie.net/__cb20130906174203/corp/images/a/a5/W-Live_Games_Hubslider_330x210-1.jpg',
				'destSize' => '100x100',
				'newExtension' => ImagesService::EXT_JPG,
				'expected' => 'http://images2.wikia.nocookie.net/__cb20130906174203/corp/images/thumb/a/a5/W-Live_Games_Hubslider_330x210-1.jpg/100x100-W-Live_Games_Hubslider_330x210-1.jpg'
			],
			[
				'imageUrl' => 'http://images2.wikia.nocookie.net/__cb20130906174203/corp/images/a/a5/W-Live_Games_Hubslider_330x210-1.jpg',
				'destSize' => '100x100',
				'newExtension' => ImagesService::EXT_JPEG,
				'expected' => 'http://images2.wikia.nocookie.net/__cb20130906174203/corp/images/thumb/a/a5/W-Live_Games_Hubslider_330x210-1.jpg/100x100-W-Live_Games_Hubslider_330x210-1.jpg'
			],
			[
				'imageUrl' => 'http://images2.wikia.nocookie.net/__cb20130906174203/corp/images/a/a5/W-Live_Games_Hubslider_330x210-1.jpeg',
				'destSize' => '100x100',
				'newExtension' => ImagesService::EXT_JPG,
				'expected' => 'http://images2.wikia.nocookie.net/__cb20130906174203/corp/images/thumb/a/a5/W-Live_Games_Hubslider_330x210-1.jpeg/100x100-W-Live_Games_Hubslider_330x210-1.jpeg'
			],
		];
	}
}
