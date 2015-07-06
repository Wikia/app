<?php

class TemplateConverterTest extends WikiaBaseTest {

	public function setUp() {
		$this->setupFile = __DIR__ . '/../TemplateDraft.setup.php';
		parent::setUp();
	}

	/**
	 * @dataProvider convertAsInfoboxProvider
	 */
	public function testConvertAsInfobox( $content, $expected, $comment ) {
		$mockTitle = $this->getMock( 'Title' );
		$templateConverter = new TemplateConverter( $mockTitle );

		$result = $templateConverter->convertAsInfobox( $content );

		$this->assertSame( $result, $expected, $comment );
	}

	public function convertAsInfoboxProvider() {
		$wikiTextFullInfobox = '{| class="infobox
|-
| class="infoboximage" colspan="2" | {{{image|}}}
|-
! class="infoboxheading" colspan="2" | {{{name|}}}
{{#if:{{{born|}}}|
{{!}}-
{{!}} class="infoboxlabel" {{!}} Born label
{{!}} class="infoboxcell" {{!}}
{{{born|}}}
{{!}}-
|}}
|}';

		$fullInfoboxOutput = '<infobox>
	<image source="image"/>
	<title source="name"><default>{{PAGENAME}}</default></title>
	<data source="born"><label>Born label</label></data>
</infobox>
';

		return [
			[ $wikiTextFullInfobox, $fullInfoboxOutput, 'Converting a simple infobox' ],
			[
				'{{{picture}}}',
				"<infobox>\n\t<image source=\"picture\"/>\n</infobox>\n",
				'Image tag alias, with no default pipe',
			],
			[
				'{{{title|Test title}}}',
				"<infobox>\n\t<title source=\"title\"><default>Test title</default></title>\n</infobox>\n",
				'Title tag alias, with default text in the pipe',
			],
			[
				"{{{name|}}}\n{{{name|}}}\\n{{{name}}}",
				"<infobox>\n\t<title source=\"name\"><default>{{PAGENAME}}</default></title>\n</infobox>\n",
				'Multiples of the same parameter in the wikitext only add one row',
			],
			[
				'',
				"<infobox>\n</infobox>\n",
				'Empty content',
			],
			[
				"{{PAGENAME}}\n{{{{#if:{{{length|}}}|:{{{length|}}}|bar}}}}",
				"<infobox>\n\t<data source=\"length\"><label>length</label></data>\n</infobox>\n",
				'More than three curly braces with a template parameter inside',
			],
			[
				"{{{name|}}}\n{{{title|Test title}}}\\n{{{surname|Kowalski}}}",
				"<infobox>\n\t<title source=\"name\"><default>{{PAGENAME}}</default></title>\n\t<title source=\"title\"><default>Test title</default></title>\n\t<data source=\"surname\"><label>surname</label><default>Kowalski</default></data>\n</infobox>\n",
				'Title tag aliases, with default text in the pipe and data tag',
			],
			[
				"{{{game|}}}\n{{{title|Test title}}}\\n{{{hero}}} and {{{image}}}",
				"<infobox>\n\t<data source=\"game\"><label>game</label></data>\n\t<title source=\"title\"><default>Test title</default></title>\n\t<data source=\"hero\"><label>hero</label></data>\n\t<image source=\"image\"/>\n</infobox>\n",
				'Title and image tags aliases in the middle and other data attributes',
			],
		];
	}
}
