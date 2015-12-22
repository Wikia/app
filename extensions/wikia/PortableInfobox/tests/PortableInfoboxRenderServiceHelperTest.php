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
		$fileMock->expects($this->any())
			->method( 'getWidth' )
			->will( $this->returnValue( $fileWidth ) );
		$fileMock->expects($this->any())
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
		$thumbnailMock->expects($this->any())
			->method( 'getWidth' )
			->will( $this->returnValue( $thumbnailWidth ) );
		$thumbnailMock->expects($this->any())
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
	 * @param string $input
	 * @param array $data
	 * @param string $expected
	 * @dataProvider sanitizeInfoboxFieldsDataProvider
	 */
	public function testSanitizeInfoboxFields( $input, $data, $expected ) {
		$this->assertEquals(
			$expected,
			$this->helper->sanitizeInfoboxFields( $input , $data )
		);
	}

	public function sanitizeInfoboxFieldsDataProvider() {
		return [
			['title',
				['value' => 'Test Title' ],
				[ 'value' => 'Test Title' ]
			],
			['title',
				['value' => '  Test Title    '],
				['value' => 'Test Title']
			],
			['title',
				['value' => 'Test Title <img src=\'data:image/gif;base64,R0lGODlhAQABAIABAAAAAP///yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D\' class=\'article-media\' data-ref=\'1\' width=\'400\' height=\'100\' /> ' ],
				['value' =>  'Test Title']],
			['title',
				['value' => 'Test Title <a href="example.com">with link</a>'],
				[ 'value' =>  'Test Title with link']
			],
			['title',
				['value' => 'Real world <a href="http://vignette-poz.wikia-dev.com/mediawiki116/images/b/b6/DBGT_Logo.svg/revision/latest?cb=20150601155347" 	class="image image-thumbnail" 	 	 	><img src="http://vignette-poz.wikia-dev.com/mediawiki116/images/b/b6/DBGT_Logo.svg/revision/latest/scale-to-width-down/30?cb=20150601155347" 	 alt="DBGT Logo"  	class="" 	 	data-image-key="DBGT_Logo.svg" 	data-image-name="DBGT Logo.svg" 	 	 width="30"  	 height="18"  	 	 	 	></a>title example'] ,
				[ 'value' =>  'Real world title example']
			],
			['hero-mobile',
				['title' => ['value' => 'Test Title'] ],
				['title' => ['value' => 'Test Title'] ]
			],
			['hero-mobile',
				['title' => ['value' => 'Real world <a href="http://vignette-poz.wikia-dev.com/mediawiki116/images/b/b6/DBGT_Logo.svg/revision/latest?cb=20150601155347" 	class="image image-thumbnail" 	 	 	><img src="http://vignette-poz.wikia-dev.com/mediawiki116/images/b/b6/DBGT_Logo.svg/revision/latest/scale-to-width-down/30?cb=20150601155347" 	 alt="DBGT Logo"  	class="" 	 	data-image-key="DBGT_Logo.svg" 	data-image-name="DBGT Logo.svg" 	 	 width="30"  	 height="18"  	 	 	 	></a>title example'] ] ,
				['title' => ['value' => 'Real world title example'] ]
			],
			['data',
				[
					'label' => 'Data <a>Link</a>',
					'value' => 'Data <a>Value</a>' ],
				[
					'label' => 'Data <a>Link</a>',
					'value' => 'Data <a>Value</a>'
				]
			],
			['data',
				['label' => 'Test data label <img src=\'data:image/gif;base64,R0lGODlhAQABAIABAAAAAP///yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D\' class=\'article-media\' data-ref=\'1\' width=\'400\' height=\'100\' />with image'],
				['label' => 'Test data label with image']
			],
			['data',
				[
					'label' => 'Data <div class="some class">with <h2>div </h2>with <small>class</small></div> and other tags',
					'value' => 'Data <small>Value</small>'
				],
				[
					'label' => 'Data with div with class and other tags',
					'value' => 'Data <small>Value</small>'
				]
			],
			['data',
				[
					'label' => '<img src="money.jpg" class="test classes" width="20" />',
					'value' => 'Data <small>Value</small>'
				],
				[
					'label' => '<img src="money.jpg" class="test classes" width="20" />',
					'value' => 'Data <small>Value</small>'
				]
			],
			['horizontal-group-content',
				[
					'labels' => [
						0 => '<img src="money.jpg" class="test classes" width="20" />',
						1 => 'Label with <a>link</a>',
						2 => 'Label with <small>link</small>',
						3 => 'Money <img src="money.jpg" class="test classes" width="20" />'
						],
					'values' => [
						0 => 'Data <small>Value</small>',
						1 => 'Data <a>Value</a>',
						2 => '<img src="money.jpg" class="test classes" width="20" />',
						3 => '$50'
						]
				],
				[
					'labels' => [
						0 => '<img src="money.jpg" class="test classes" width="20" />',
						1 => 'Label with <a>link</a>',
						2 => 'Label with link',
						3 => 'Money',
					],
					'values' => [
						0 => 'Data <small>Value</small>',
						1 => 'Data <a>Value</a>',
						2 => '<img src="money.jpg" class="test classes" width="20" />',
						3 => '$50'
					]
				]
			]
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
				'heroData' => [],
				'result' => true,
				'description' => 'First title in infobox',
				'mockParams' => []
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
				'mockParams' => []
			],
			[
				'item' => [
					'type' => 'image',
					'data' => array( null )
				],
				'heroData' => [],
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
				'heroData' => [],
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
	 * @desc test getImageSizesForThumbnailer function. It should return the sizes we pass to transform function,
	 * not the sizes we want image to have. transform adjusts the correct sizes,
	 * that is creates thumbnail with sizes not bigger than passed, keeping the original aspect ratio.
	 *
	 * @param $mockParams
	 * @param $isWikiaMobile
	 * @param $wgPortableInfoboxCustomImageWidth
	 * @param $result
	 * @param $description
	 * @dataProvider testGetImageSizesForThumbnailerDataProvider
	 */
	public function testGetImageSizesForThumbnailer( $mockParams, $isWikiaMobile, $wgPortableInfoboxCustomImageWidth, $result, $description ) {
		$this->mockGlobalVariable('wgPortableInfoboxCustomImageWidth', $wgPortableInfoboxCustomImageWidth);
		$mock = $this->getMockBuilder( 'Wikia\PortableInfobox\Helpers\PortableInfoboxRenderServiceHelper' )
			->setMethods( [ 'isWikiaMobile' ] )
			->getMock();
		$mock->expects( $this->any() )->method( 'isWikiaMobile' )->will( $this->returnValue( $isWikiaMobile ) );

		$file = $this->createWikiaFileHelperMock( $mockParams );

		$this->assertEquals(
			$result,
			$mock->getImageSizesForThumbnailer( $file ),
			$description
		);
	}

	public function testGetImageSizesForThumbnailerDataProvider() {
		return [
			[
				'mockParams' => [
					'fileHeight' => 2000,
					'fileWidth' => 3000
				],
				'isWikiaMobile' => false,
				'wgPortableInfoboxCustomImageWidth' => null,
				'result' => [
					'height' => 500,
					'width' => 270
				],
				'description' => 'Big image on desktop'
			],
			[
				'mockParams' => [
					'fileHeight' => 3000,
					'fileWidth' => 250
				],
				'isWikiaMobile' => false,
				'wgPortableInfoboxCustomImageWidth' => null,
				'result' => [
					'height' => 500,
					'width' => 270
				],
				'description' => 'Tall image on desktop'
			],
			[
				'mockParams' => [
					'fileHeight' => 200,
					'fileWidth' => 2000
				],
				'isWikiaMobile' => false,
				'wgPortableInfoboxCustomImageWidth' => null,
				'result' => [
					'height' => 200,
					'width' => 270
				],
				'description' => 'Wide image on desktop'
			],
			[
				'mockParams' => [
					'fileHeight' => 50,
					'fileWidth' => 45
				],
				'isWikiaMobile' => false,
				'wgPortableInfoboxCustomImageWidth' => null,
				'result' => [
					'height' => 50,
					'width' => 270
				],
				'description' => 'Small image on desktop'
			],
			[
				'mockParams' => [
					'fileHeight' => 2000,
					'fileWidth' => 3000
				],
				'isWikiaMobile' => true,
				'wgPortableInfoboxCustomImageWidth' => null,
				'result' => [
					'height' => null,
					'width' => 360
				],
				'description' => 'Big image on mobile'
			],
			[
				'mockParams' => [
					'fileHeight' => 3000,
					'fileWidth' => 250
				],
				'isWikiaMobile' => true,
				'wgPortableInfoboxCustomImageWidth' => null,
				'result' => [
					'height' => null,
					'width' => 360
				],
				'description' => 'Tall image on mobile'
			],
			[
				'mockParams' => [
					'fileHeight' => 200,
					'fileWidth' => 2000
				],
				'isWikiaMobile' => true,
				'wgPortableInfoboxCustomImageWidth' => null,
				'result' => [
					'height' => null,
					'width' => 360
				],
				'description' => 'Wide image on mobile'
			],
			[
				'mockParams' => [
					'fileHeight' => 50,
					'fileWidth' => 45
				],
				'isWikiaMobile' => true,
				'wgPortableInfoboxCustomImageWidth' => null,
				'result' => [
					'height' => null,
					'width' => 360
				],
				'description' => 'Small image on mobile'
			],
			[
				'mockParams' => [
					'fileHeight' => 2000,
					'fileWidth' => 3000
				],
				'isWikiaMobile' => false,
				'wgPortableInfoboxCustomImageWidth' => 400,
				'result' => [
					'height' => 2000,
					'width' => 400
				],
				'description' => 'Big image on desktop with custom image width'
			],
			[
				'mockParams' => [
					'fileHeight' => 3000,
					'fileWidth' => 250
				],
				'isWikiaMobile' => false,
				'wgPortableInfoboxCustomImageWidth' => 400,
				'result' => [
					'height' => 3000,
					'width' => 400
				],
				'description' => 'Tall image on desktop with custom image width'
			],
			[
				'mockParams' => [
					'fileHeight' => 200,
					'fileWidth' => 2000
				],
				'isWikiaMobile' => false,
				'wgPortableInfoboxCustomImageWidth' => 400,
				'result' => [
					'height' => 200,
					'width' => 400
				],
				'description' => 'Wide image on desktop with custom image width'
			],
			[
				'mockParams' => [
					'fileHeight' => 2000,
					'fileWidth' => 3000
				],
				'isWikiaMobile' => true,
				'wgPortableInfoboxCustomImageWidth' => 400,
				'result' => [
					'height' => null,
					'width' => 360
				],
				'description' => 'Big image on mobile with custom image width'
			],
		];
	}

	/**
	 * @desc test getImageSizesToDisplay function. It should return the logical size used to define HTML width and
	 * height in the output. This allows to differentiate between physical size and logical size, allowing
	 * to achieve high pereived quality on for example Retina displays.
	 *
	 * @param $thumbnailSizes
	 * @param $isWikiaMobile
	 * @param $wgPortableInfoboxCustomImageWidth
	 * @param $result
	 * @param $description
	 * @dataProvider testGetImageSizesToDisplayDataProvider
	 */
	public function testGetImageSizesToDisplay( $thumbnailSizes, $isWikiaMobile, $wgPortableInfoboxCustomImageWidth, $result, $description ) {
		$this->mockGlobalVariable('wgPortableInfoboxCustomImageWidth', $wgPortableInfoboxCustomImageWidth);
		$mock = $this->getMockBuilder( 'Wikia\PortableInfobox\Helpers\PortableInfoboxRenderServiceHelper' )
			->setMethods( [ 'isWikiaMobile' ] )
			->getMock();
		$mock->expects( $this->any() )->method( 'isWikiaMobile' )->will( $this->returnValue( $isWikiaMobile ) );

		$thumbnailMock = $this->getThumbnailMock( $thumbnailSizes );

		$this->assertEquals(
			$result,
			$mock->getImageSizesToDisplay( $thumbnailMock ),
			$description
		);
	}

	public function testGetImageSizesToDisplayDataProvider() {
		return [
			[
				'thumbnailSizes' => [
					'height' => 500,
					'width' => 270
				],
				'isWikiaMobile' => false,
				'wgPortableInfoboxCustomImageWidth' => null,
				'result' => [
					'height' => 500,
					'width' => 270
				],
				'description' => 'Regular thumbnail image on desktop with no custom width; logical size = physical size'
			],
			[
				'thumbnailSizes' => [
					'height' => 1000,
					'width' => 540
				],
				'isWikiaMobile' => false,
				'wgPortableInfoboxCustomImageWidth' => 540,
				'result' => [
					'height' => 500,
					'width' => 270
				],
				'description' => 'Regular thumbnail image on desktop with double custom width; portrait'
			],
			[
				'thumbnailSizes' => [
					'height' => 500,
					'width' => 540
				],
				'isWikiaMobile' => false,
				'wgPortableInfoboxCustomImageWidth' => 540,
				'result' => [
					'height' => 250,
					'width' => 270
				],
				'description' => 'Regular thumbnail image on desktop with double custom width; landscape'
			],
			[
				'thumbnailSizes' => [
					'height' => 250,
					'width' => 270
				],
				'isWikiaMobile' => true,
				'wgPortableInfoboxCustomImageWidth' => null,
				'result' => [
					'height' => 250,
					'width' => 270
				],
				'description' => 'Regular thumbnail image on mobile with no custom width; logical size = physical size'
			],
			[
				'thumbnailSizes' => [
					'height' => 360,
					'width' => 270

				],
				'isWikiaMobile' => true,
				'wgPortableInfoboxCustomImageWidth' => 540,
				'result' => [
					'height' => 360,
					'width' => 270
				],
				'description' => 'Regular thumbnail image on mobile with double custom width; portrait; logical size = physical size'
			],
			[
				'thumbnailSizes' => [
					'height' => 270,
					'width' => 360
				],
				'isWikiaMobile' => true,
				'wgPortableInfoboxCustomImageWidth' => 540,
				'result' => [
					'height' => 270,
					'width' => 360
				],
				'description' => 'Regular thumbnail image on desktop with double custom width; landscape; logical size = physical size'
			],
				[
					'thumbnailSizes' => [
							'height' => 600,
							'width' => 210
					],
					'isWikiaMobile' => false,
					'wgPortableInfoboxCustomImageWidth' => 540,
					'result' => [
							'height' => 500,
							'width' => 175
					],
					'description' => 'Regular thumbnail image on desktop with double custom width; portrait extra
					thin image edge case'
				]
		];
	}
}
