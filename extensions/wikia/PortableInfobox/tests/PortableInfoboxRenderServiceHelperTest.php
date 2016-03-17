<?php

use Wikia\PortableInfobox\Helpers\PortableInfoboxRenderServiceHelper;

class PortableInfoboxRenderServiceHelperTest extends WikiaBaseTest {
	private $helper;

	protected function setUp() {
		$this->setupFile = dirname( __FILE__ ) . '/../PortableInfobox.setup.php';
		parent::setUp();

		$this->helper = new PortableInfoboxRenderServiceHelper();
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
			->setConstructorArgs( [ 'TestFile' ] )
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

	private function getThumbnailMock( $thumbnailSizes ) {
		$thumbnailWidth = isset( $thumbnailSizes[ 'width' ] ) ? $thumbnailSizes[ 'width' ] : null;
		$thumbnailHeight = isset( $thumbnailSizes[ 'height' ] ) ? $thumbnailSizes[ 'height' ] : null;

		$thumbnailMock = $this->getMockBuilder( 'ThumbnailImage' )
			->setMethods( [ 'getWidth', 'getHeight' ] )
			->getMock();
		$thumbnailMock->expects( $this->any() )
			->method( 'getWidth' )
			->will( $this->returnValue( $thumbnailWidth ) );
		$thumbnailMock->expects( $this->any() )
			->method( 'getHeight' )
			->will( $this->returnValue( $thumbnailHeight ) );

		return $thumbnailMock;
	}

	/**
	 * @param array $input
	 * @param array $expectedOutput
	 * @param string $description
	 * @dataProvider testCreateHorizontalGroupDataDataProvider
	 */
	public function testCreateHorizontalGroupData( $input, $expectedOutput, $description ) {
		$this->assertEquals(
			$expectedOutput,
			$this->helper->createHorizontalGroupData( $input ),
			$description
		);
	}

	public function testCreateHorizontalGroupDataDataProvider() {
		return [
			[
				'input' => [
					[
						'type' => 'header',
						'data' => [
							'value' => 'test header'
						]
					],
					[
						'type' => 'data',
						'data' => [
							'label' => 'test label 1',
							'value' => 'test value 1'
						]
					],
					[
						'type' => 'data',
						'data' => [
							'label' => 'test label 2',
							'value' => 'test value 2'
						]
					]
				],
				'output' => [
					'header' => 'test header',
					'labels' => [ 'test label 1', 'test label 2' ],
					'values' => [ 'test value 1', 'test value 2' ],
					'renderLabels' => true
				],
				'description' => 'Horizontal group data with header and two data tags'
			],
			[
				'input' => [
					[
						'type' => 'data',
						'data' => [
							'label' => 'test label 1',
							'value' => 'test value 1'
						]
					],
					[
						'type' => 'data',
						'data' => [
							'label' => 'test label 2',
							'value' => 'test value 2'
						]
					]
				],
				'output' => [
					'labels' => [ 'test label 1', 'test label 2' ],
					'values' => [ 'test value 1', 'test value 2' ],
					'renderLabels' => true
				],
				'description' => 'Horizontal group data without header'
			],
			[
				'input' => [
					[
						'type' => 'header',
						'data' => [
							'value' => 'test header'
						]
					],
					[
						'type' => 'data',
						'data' => [
							'label' => '',
							'value' => 'test value 1'
						]
					],
					[
						'type' => 'data',
						'data' => [
							'label' => 'test label 2',
							'value' => 'test value 2'
						]
					]
				],
				'output' => [
					'header' => 'test header',
					'labels' => [ '', 'test label 2' ],
					'values' => [ 'test value 1', 'test value 2' ],
					'renderLabels' => true
				],
				'description' => 'Horizontal group data with empty label'
			],
			[
				'input' => [
					[
						'type' => 'data',
						'data' => [
							'label' => '',
							'value' => 'test value 1'
						]
					],
					[
						'type' => 'data',
						'data' => [
							'label' => '',
							'value' => 'test value 2'
						]
					]
				],
				'output' => [
					'labels' => [ '', '' ],
					'values' => [ 'test value 1', 'test value 2' ],
					'renderLabels' => false
				],
				'description' => 'Horizontal group data without labels'
			],
		];
	}

	/**
	 * @param array $item
	 * @param array $heroData
	 * @param boolean $result
	 * @param string $description
	 * @param array $mockParams
	 * @dataProvider testIsValidHeroDataItemDataProvider
	 */
	public function testIsValidHeroDataItem( $item, $heroData, $result, $description, $mockParams ) {
		$this->createWikiaFileHelperMock( $mockParams );

		$this->assertEquals(
			$result,
			$this->helper->isValidHeroDataItem( $item, $heroData ),
			$description
		);
	}

	public function testIsValidHeroDataItemDataProvider() {
		return [
			[
				'item' => [
					'type' => 'title'
				],
				'heroData' => [ ],
				'result' => true,
				'description' => 'First title in infobox',
				'mockParams' => [ ]
			],
			[
				'item' => [
					'type' => 'title'
				],
				'heroData' => [
					'title' => 'first infobox title'
				],
				'result' => false,
				'description' => 'not first title in infobox',
				'mockParams' => [ ]
			],
			[
				'item' => [
					'type' => 'image',
					'data' => array( null )
				],
				'heroData' => [ ],
				'result' => true,
				'description' => 'first image in infobox',
				'mockParams' => [
					'fileWidth' => 300
				]
			],
			[
				'item' => [
					'type' => 'image'
				],
				'heroData' => [
					'image' => 'first infobox image'
				],
				'result' => false,
				'description' => 'not first image in infobox',
				'mockParams' => [
					'fileWidth' => 300
				]
			],
			[
				'item' => [
					'type' => 'image'
				],
				'heroData' => [ ],
				'result' => false,
				'description' => 'too small image',
				'mockParams' => [
					'fileWidth' => 299
				]
			]
		];
	}

	/**
	 * @param string $type
	 * @param boolean $result
	 * @param string $description
	 * @dataProvider testIsTypeSupportedInTemplatesDataProvider
	 */
	public function testIsTypeSupportedInTemplates( $type, $result, $description ) {
		$templates = [
			'testType' => 'testType.mustache'
		];

		$this->assertEquals(
			$result,
			$this->helper->isTypeSupportedInTemplates( $type, $templates ),
			$description
		);
	}

	public function testIsTypeSupportedInTemplatesDataProvider() {
		return [
			[
				'type' => 'testType',
				'result' => true,
				'description' => 'valid data type'
			],
			[
				'type' => 'invalidTestType',
				'result' => false,
				'description' => 'invalid data type'
			]
		];
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
		$helper = new PortableInfoboxRenderServiceHelper();
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
}
