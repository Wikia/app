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

		$fileMock = $this->getMockBuilder('File')
			->setConstructorArgs( [ 'TestFile' ] )
			->setMethods( [ 'getWidth' ] )
			->getMock();
		$fileMock->expects($this->any())
			->method( 'getWidth' )
			->will( $this->returnValue( $fileWidth ) );

		$this->mockStaticMethod( 'WikiaFileHelper', 'getFileFromTitle', $fileMock );
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
					'values' => [ 'test value 1', 'test value 2' ]
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
					'values' => [ 'test value 1', 'test value 2' ]
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
					'values' => [ 'test value 1', 'test value 2' ]
				],
				'description' => 'Horizontal group data with empty label'
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
	 * @param array $mockParams
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
}
