<?php
/**
 * @author Adam Robak <adamr@wikia-inc.com>
 * @group Integration
 */

class ImageServingDriverBaseTest extends WikiaBaseTest {


	/**
	 * @param $imgExist
	 * @param $imgList
	 * @param $limit
	 * @param $expected
	 * @dataProvider dataProvider
	 */
	public function testFormatResult( $imgExist, $imgList, $expected ) {

		$mockedIs = $this->getMockBuilder( 'ImageServing' )
			->disableOriginalConstructor()
			->setMethods( [ 'getUrl' ] )
			->getMock();

		$driver = $this->getMockBuilder( 'ImageServingDriverMainNS' )
			->setConstructorArgs( [ null, $mockedIs, null ] )
			->enableOriginalConstructor()
			->setMethods( [ 'getImageFile' ] )
			->getMock();

		$imgFile = $this->getMockBuilder( 'WikiaLocalFile' )
			->disableOriginalConstructor()
			->setMethods( [ 'getWidth', 'getHeight' ] )
			->getMock();

		$mockedIs->expects( $this->any() )
			->method( 'getUrl' )
			->will( $this->returnValue( 'http://url' ) );

		$imgFile->expects( $this->any() )
			->method( 'getWidth' )
			->will( $this->returnValue( 100 ) );

		$imgFile->expects( $this->any() )
			->method( 'getHeight' )
			->will( $this->returnValue( 100 ) );

		if ( $imgExist ) {
			$driver->expects( $this->any() )
				->method( 'getImageFile' )
				->will( $this->returnValue( $imgFile ) );
		} else {
			$driver->expects( $this->any() )
				->method( 'getImageFile' )
				->will( $this->returnValue( null ) );
		}

		//invoke private method
		$formatResult = new ReflectionMethod( 'ImageServingDriverMainNS', 'formatResult' );
		$formatResult->setAccessible( true );

		$result = $formatResult->invoke( $driver, $imgList, $this->getDbOut() );

		$this->assertEquals( $expected, $result );
	}

	public function dataProvider() {
		//img exists - true/false
		//img list
		//limit
		//expected result
		return [
			[
				true,
				[ 'img_1' => [ 'img_1' => true ] ],
				[ 'img_1' => $this->getResultArray( 'img_1', 100, 100, 'http://url' ) ]
			],
			[
				false,
				[ 'img_1' => [ 'img_1' => true ] ],
				[ 'img_1' => $this->getResultArray( 'img_1', 0, 0, '' ) ]
			],
			//no such element in db
			[
				true,
				[ 'img_not_exist' => [ 'img_not_exist' => true ] ],
				[]
			],
			[
				false,
				[ 'img_not_exist' => [ 'img_not_exist' => true ] ],
				[]
			],
			[
				true,
				[ 'img_1' => [ 'img_1' => true ] ],
				[ 'img_1' => $this->getResultArray( 'img_1', 100, 100, 'http://url' ) ],
			],
			[
				true,
				[ 'img_1' => [ 'img_1' => true ], 'img_2' => [ 'img_2' => true ] ],
				[
					'img_1' => $this->getResultArray( 'img_1', 100, 100, 'http://url' ),
					'img_2' => $this->getResultArray( 'img_2', 100, 100, 'http://url' ),
				]
			],
			[
				true,
				[ 'img_1' => [ [ 'img_1', 'img_1b' ], 'img_2', 'img_3' ] ],
				[
					0 => $this->getResultArray( 'img_1', 100, 100, 'http://url' ),
					1 => $this->getResultArray( 'img_1', 100, 100, 'http://url' ),
					2 => $this->getResultArray( 'img_1', 100, 100, 'http://url' ),
				],
			],
		];
	}

	public function getResultArray( $name, $width, $height, $url ) {
		return [
			[
				'name' => $name,
				'original_dimensions' => [
					'width' => $width,
					'height' => $height
				],
				'url' => $url
			]
		];
	}

	public function getDbOut() {
		return [
			'img_1' => [
				'img_width' => 200,
				'img_height' => 200
			],
			'img_2' => [
				'img_width' => 300,
				'img_height' => 300
			],
			'img_3' => [
				'img_width' => 400,
				'img_height' => 400
			],
		];
	}
}