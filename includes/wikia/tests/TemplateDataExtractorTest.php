<?php

class TemplateDataExtractorTest extends WikiaBaseTest {

	public function setUp() {
		parent::setUp();
	}

	/**
	 * @dataProvider getTemplateVariablesDataProvider
	 */
	public function testGetTemplateVariables( $content, $expected, $comment ) {
		$mockTitle = $this->getMock( 'Title' );
		$templateDataExtractor = new TemplateDataExtractor( $mockTitle );

		$result = $templateDataExtractor->getTemplateVariables( $content );

		$this->assertSame( $result, $expected, $comment );
	}

	/**
	 * @dataProvider getTemplateVariablesWithLabelsDataProvider
	 */
	public function testGetTemplateVariablesWithLabels( $content, $expected, $comment ) {
		$mockTitle = $this->getMock( 'Title' );
		$templateDataExtractor = new TemplateDataExtractor( $mockTitle );

		$result = $templateDataExtractor->getTemplateVariablesWithLabels( $content );

		$this->assertSame( $result, $expected, $comment );
	}

	public function getTemplateVariablesDataProvider() {
		$content = '{| class="infobox
|-
| class="infoboximage" colspan="2" | {{{image|}}}
|-
! class="infoboxheading" colspan="2" | {{{name}}}
{{#if:{{{born|}}}|
{{!}}-
{{!}} class="infoboxlabel" {{!}} Born label
{{!}} class="infoboxcell" {{!}}
{{{born|1/1/1970}}}
{{!}}-
|}}
|}';
		$contentWithTransclusionTags = '{| class="infobox
|-
| class="infoboximage" colspan="2" | {{{image<includeonly>|</includeonly>}}}
|-
! class="infoboxheading" colspan="2" | {{{name<includeonly>|</includeonly>}}}
{{#if:{{{born|}}}|
{{!}}-
{{!}} class="infoboxlabel" {{!}} Born label
{{!}} class="infoboxcell" {{!}}
{{{born|1/1/1970}}}
{{!}}-
|}}
|}';

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
				'label' => '',
				'default' => '1/1/1970'
			]
		];

		return [
			[ $content, $variables, 'extracting variables from simple infobox wikitext' ],
			[ $contentWithTransclusionTags, $variables, 'extracting variables from simple infobox wikitext with transclusion tags' ],
			[
				'{{{picture}}}',
				[
					'picture' => [
						'name' => 'picture',
						'label' => '',
						'default' => ''
					]
				],
				'Simple variable',
			],
			[
				'{{{title|Test title}}}',
				[
					'title' => [
						'name' => 'title',
						'label' => '',
						'default' => 'Test title'
					]
				],
				'Variable with default value',
			],
			[
				"{{{name|}}}\n{{{name|default name}}}\\n{{{name}}}",
				[
					'name' => [
						'name' => 'name',
						'label' => '',
						'default' => 'default name'
					]
				],
				'Multiples of the same parameter in the wikitext only add one with default value',
			],
			[
				'',
				[],
				'Empty content',
			],
			[
				"{{PAGENAME}}\n{{{{#if:{{{length|}}}|:{{{length|}}}|bar}}}}",
				[
					'length' => [
						'name' => 'length',
						'label' => '',
						'default' => ''
					]
				],
				'More than three curly braces with a template parameter inside',
			],
		];
	}

	public function getTemplateVariablesWithLabelsDataProvider() {
		$content = '{| class="infobox
|-
| class="infoboximage" colspan="2" | {{{image|}}}
|-
! class="infoboxheading" colspan="2" | {{{name|default name}}}
{{#if:{{{born|}}}|
{{!}}-
{{!}} class="infoboxlabel" {{!}} Born label
{{!}} class="infoboxcell" {{!}}
{{{born|}}}
{{!}}-
|}}
|}';

		$variables = [
			'image' => [
				'name' => 'image',
				'label' => '',
				'default' => ''
			],
			'name' => [
				'name' => 'name',
				'label' => '',
				'default' => 'default name'
			],
			'born' => [
				'name' => 'born',
				'label' => 'Born label',
				'default' => ''
			]
		];

		$contentLong = "
		{|class=\"infobox bordered vcard\"
!colspan=\"2\" |<small>VEHICLE</small><br />'''{{{name|{{PAGENAME}}}}}'''
|-
{{#if:{{{front_image|}}}|{{!}} colspan=\"2\" class=\"fullwidth\" {{!}}[[File:{{{front_image}}}|250px|center|link=File:{{{front_image}}}]]<center>{{{caption}}}</center>}}
{{#if:{{{vehicle_class|}}}|
{{!}}-
!width=\"10%\" {{!}}'''Vehicle class<br>([[Grand Theft Auto V|GTA V]])'''
{{!}}width=\"20%\" {{!}}[[:Category:{{{vehicle_class|}}} Vehicle Class|{{{vehicle_class|}}}]]|
{{!}}-
|
}}
{{#if:{{{vehicle_type|}}}|
{{!}}-
!width=\"10%\" {{!}}'''Vehicle type'''
{{!}}width=\"20%\" {{!}}{{{vehicle_type|}}}|
{{!}}-
|
}}
{{#if:{{{capacity|}}}|
{{!}}-
!width=\"10%\" style=\"background: #000000; text-align:center; color:lightgray;\"{{!}}'''Capacity'''
{{!}}width=\"20%\" style=\"background: #656565; text-align:left; color: white;\"{{!}}{{{capacity|200}}}|
{{!}}-
|
}}
|}
";

		$variablesLong = [
			'name' => [
				'name' => 'name',
				'label' => '',
				'default' => '{{PAGENAME}}'
			],
			'front_image' => [
				'name' => 'front_image',
				'label' => '',
				'default' => ''
			],
			'caption' => [
				'name' => 'caption',
				'label' => '',
				'default' => ''
			],
			'vehicle_class' => [
				'name' => 'vehicle_class',
				'label' => "'''Vehicle class<br>([[Grand Theft Auto V|GTA V]])'''",
				'default' => ''
			],
			'vehicle_type' => [
				'name' => 'vehicle_type',
				'label' => "'''Vehicle type'''",
				'default' => ''
			],
			'capacity' => [
				'name' => 'capacity',
				'label' => "'''Capacity'''",
				'default' => '200'
			]
		];

		return [
			[ $content, $variables, 'extracting variables with labels from simple infobox wikitext' ],
			[ $contentLong, $variablesLong, 'extracting variables from longer infobox wikitext' ],
		];
	}
}
