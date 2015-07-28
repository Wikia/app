<?php

class TemplateConverterTest extends WikiaBaseTest {

	public function setUp() {
		$this->setupFile = __DIR__ . '/../TemplateDraft.setup.php';
		parent::setUp();
	}

	/**
	 * @dataProvider convertAsInfoboxProvider
	 */
	public function testConvertAsInfobox( $variables, $expected, $comment ) {
		$mockTemplateDataExtractor = $this->getMockBuilder( 'TemplateDataExtractor' )
			->disableOriginalConstructor()
			->setMethods( ['getTemplateVariablesWithLabels'] )
			->getMock();

		$mockTemplateDataExtractor
			->expects( $this->once() )
			->method( 'getTemplateVariablesWithLabels' )
			->will( $this->returnValue( $variables ) );

		$mockTemplateConverter = $this->getMockBuilder( 'TemplateConverter' )
			->disableOriginalConstructor()
			->setMethods( ['getTemplateDataExtractor'] )
			->getMock();

		$mockTemplateConverter
			->expects( $this->once() )
			->method( 'getTemplateDataExtractor' )
			->will( $this->returnValue( $mockTemplateDataExtractor ) );

		$result = $mockTemplateConverter->convertAsInfobox( 'fake content' );

		$this->assertSame( $result, $expected, $comment );
	}

	public function convertAsInfoboxProvider() {
		$variables = [
			'image' => [
				'name' => 'image',
				'label' => '',
				'default' => ''
			],
			'name' => [
				'name' => 'name',
				'label' => '',
				'default' => ''
			],
			'born' => [
				'name' => 'born',
				'label' => 'Born label',
				'default' => ''
			]
		];

		$fullInfoboxOutput = '<infobox>
	<image source="image"/>
	<title source="name"><default>{{PAGENAME}}</default></title>
	<data source="born"><label>Born label</label></data>
</infobox>
';

		return [
			[ $variables, $fullInfoboxOutput, 'Converting a simple infobox' ],
			[
				[
					'picture' => [
						'name' => 'picture',
						'label' => '',
						'default' => ''
					]
				],
				"<infobox>\n\t<image source=\"picture\"/>\n</infobox>\n",
				'Image tag alias, with no default pipe',
			],
			[
				[
					'title' => [
						'name' => 'title',
						'label' => '',
						'default' => 'Test title'
					]
				],
				"<infobox>\n\t<title source=\"title\"><default>Test title</default></title>\n</infobox>\n",
				'Title tag alias, with default text in the pipe',
			],
			[
				[
					'name' => [
						'name' => 'name',
						'label' => '',
						'default' => ''
					]
				],
				"<infobox>\n\t<title source=\"name\"><default>{{PAGENAME}}</default></title>\n</infobox>\n",
				'Multiples of the same parameter in the wikitext only add one row',
			],
			[
				[],
				"<infobox>\n</infobox>\n",
				'Empty content',
			],
			[
				[
					'game' => [
						'name' => 'game',
						'label' => '',
						'default' => ''
					],
					'title' => [
						'name' => 'title',
						'label' => '',
						'default' => 'Test title'
					],
					'hero' => [
						'name' => 'hero',
						'label' => '',
						'default' => ''
					],
					'image' => [
						'name' => 'image',
						'label' => '',
						'default' => ''
					]
				],
				"<infobox>\n\t<data source=\"game\"><label>game</label></data>\n\t<title source=\"title\"><default>Test title</default></title>\n\t<data source=\"hero\"><label>hero</label></data>\n\t<image source=\"image\"/>\n</infobox>\n",
				'Title and image tags aliases in the middle and other data attributes',
			],
		];
	}
}
