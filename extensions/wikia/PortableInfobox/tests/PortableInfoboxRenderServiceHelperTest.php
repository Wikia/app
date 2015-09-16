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
	 */
	public function createWikiaFileHelperMock( $input ) {
		$fileWidth = isset( $input[ 'fileWidth' ] ) ? $input[ 'fileWidth' ] : null;
		$fileHeight = isset( $input[ 'fileHeight' ] ) ? $input[ 'fileHeight' ] : null;

		$fileMock = $this->getMockBuilder('File')
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
	 * @dataProvider sanitizeInfoboxTitleSourceDataProvider
	 */
	public function testSanitizeInfoboxTitle( $input, $data, $expected ) {
		$this->assertEquals(
			$expected,
			$this->helper->sanitizeInfoboxTitle( $input , $data )
		);
	}

	public function sanitizeInfoboxTitleSourceDataProvider() {
		return [
			['title', [ 'value' => 'Test Title' ], [ 'value' => 'Test Title' ] ],
			['title', ['value' => '  Test Title    '] , [ 'value' => 'Test Title'] ],
			['title', ['value' => 'Test Title <img src=\'data:image/gif;base64,R0lGODlhAQABAIABAAAAAP///yH5BAEAAAEALAAAAAABAAEAQAICTAEAOw%3D%3D\' class=\'article-media\' data-ref=\'1\' width=\'400\' height=\'100\' /> ' ], [ 'value' =>  'Test Title']],
			['title', ['value' => 'Test Title <a href="example.com">with link</a>'], [ 'value' =>  'Test Title with link'] ],
			['title', ['value' => 'Real world <a href="http://vignette-poz.wikia-dev.com/mediawiki116/images/b/b6/DBGT_Logo.svg/revision/latest?cb=20150601155347" 	class="image image-thumbnail" 	 	 	><img src="http://vignette-poz.wikia-dev.com/mediawiki116/images/b/b6/DBGT_Logo.svg/revision/latest/scale-to-width-down/30?cb=20150601155347" 	 alt="DBGT Logo"  	class="" 	 	data-image-key="DBGT_Logo.svg" 	data-image-name="DBGT Logo.svg" 	 	 width="30"  	 height="18"  	 	 	 	></a>title example'] , [ 'value' =>  'Real world title example'] ],
			['hero-mobile', ['title' => ['value' => 'Test Title'] ], ['title' => ['value' => 'Test Title'] ] ],
			['hero-mobile', ['title' => ['value' => 'Real world <a href="http://vignette-poz.wikia-dev.com/mediawiki116/images/b/b6/DBGT_Logo.svg/revision/latest?cb=20150601155347" 	class="image image-thumbnail" 	 	 	><img src="http://vignette-poz.wikia-dev.com/mediawiki116/images/b/b6/DBGT_Logo.svg/revision/latest/scale-to-width-down/30?cb=20150601155347" 	 alt="DBGT Logo"  	class="" 	 	data-image-key="DBGT_Logo.svg" 	data-image-name="DBGT Logo.svg" 	 	 width="30"  	 height="18"  	 	 	 	></a>title example'] ] , ['title' => ['value' => 'Real world title example'] ] ],
			['data', [ 'value' => 'Test <a>Group</a>' ], [ 'value' => 'Test <a>Group</a>' ] ],
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
					'type' => 'image'
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
	 * @desc test getAdjustedImageSize function. It should return the sizes we pass to transform function,
	 * not the sizes we want image to have. transform adjusts the correct sizes,
	 * that is creates thumbnail with sizes not bigger than passed, keeping the original aspect ratio.
	 * 
	 * @param $mockParams
	 * @param $isWikiaMobile
	 * @param $result
	 * @param $description
	 * @dataProvider testGetAdjustedImageSizeDataProvider
	 */
	public function testGetAdjustedImageSize( $mockParams, $isWikiaMobile, $result, $description ) {
		$mock = $this->getMockBuilder( 'Wikia\PortableInfobox\Helpers\PortableInfoboxRenderServiceHelper' )
			->setMethods( [ 'isWikiaMobile' ] )
			->getMock();
		$mock->expects( $this->any() )->method( 'isWikiaMobile' )->will( $this->returnValue( $isWikiaMobile ) );

		$file = $this->createWikiaFileHelperMock( $mockParams );

		$this->assertEquals(
			$result,
			$mock->getAdjustedImageSize( $file ),
			$description
		);
	}

	public function testGetAdjustedImageSizeDataProvider() {
		return [
			[
				'mockParams' => [
					'fileHeight' => 2000,
					'fileWidth' => 3000
				],
				'isWikiaMobile' => false,
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
				'result' => [
					'height' => null,
					'width' => 360
				],
				'description' => 'Small image on mobile'
			]
		];
	}
}
