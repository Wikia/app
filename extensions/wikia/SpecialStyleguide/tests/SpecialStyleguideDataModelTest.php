<?php
class SpecialStyleguideDataModelTest extends WikiaBaseTest {

	public function setUp() {
		$this->setupFile =  dirname(__FILE__) . '/../SpecialStyleguide.setup.php';
		parent::setUp();
	}
	
	private $mockedSectionData = array(
		'header' => [
			'home' => [
				'mainHeader' => 'Main header of home page',
				'getStartedBtnLink' => 'Get started!',
			],
			'components' => [
				'sectionHeader' => 'Header of the components page',
				'tagLine' => 'Tagline of components page'
			]
		],
		'footer' => [
			'list' => [
				[
					'link' => '#',
					'linkTitle' => 'Blog',
					'linkLabel' => 'Blog',
				],
				[
					'link' => '#',
					'linkTitle' => 'Change log',
					'linkLabel' => 'Change log',
				]
			],
		],
		'home' => [
			'sections' => [
				[
					'header' => 'Header 1',
					'paragraph' => 'Paragraph 1'
				],
				[
					'header' => 'Header 2',
					'paragraph' => 'Paragraph 2'
				],
				[
					'header' => 'Header 3',
					'paragraph' => 'Paragraph 3'
				]
			]
		],
		'components' => [
			[
				'name' => 'Buttons',
				'description' => 'Buttons are buttons'
			],
			[
				'name' => 'Lightbox',
				'description' => 'Lightbox is for images'
			]
		],
	);
	
	/**
	 * @group Slow
	 * @slowExecutionTime 0.02869 ms
	 * @dataProvider getSectionDataProvider
	 *
	 * @param array $sectionNamesArray
	 * @param array $expectedResults
	 */
	public function testGetSectionData( $sectionNamesArray, $expectedResults ) {
		$model = new SpecialStyleguideDataModel();

		$sectionData = new ReflectionProperty( SpecialStyleguideDataModel::class, 'sectionData' );
		$sectionData->setAccessible( true );
		$sectionData->setValue( $model, $this->mockedSectionData );

		$this->assertEquals( $expectedResults, $model->getPartOfSectionData( $sectionNamesArray ) );
	}
	
	public function getSectionDataProvider() {
		return [
			[
				'sectionNamesArray' => [],
				'expectedResults' => [],
			],
			[
				'sectionNamesArray' => ['header'],
				'expectedResults' => [
					'home' => [
						'mainHeader' => 'Main header of home page',
						'getStartedBtnLink' => 'Get started!',
					],
					'components' => [
						'sectionHeader' => 'Header of the components page',
						'tagLine' => 'Tagline of components page'
					]
				],
			],
			[
				'sectionNamesArray' => ['header', 'components'],
				'expectedResults' => [
					'sectionHeader' => 'Header of the components page',
					'tagLine' => 'Tagline of components page'
				],
			],
			[
				'sectionNamesArray' => ['idonotexist', 'meneither'],
				'expectedResults' => [],
			],
		];
	}
	
}
