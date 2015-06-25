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
		$templateConverter = new TemplateConverter();

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
{{!}} class="infoboxlabel" {{!}} Born
{{!}} class="infoboxcell" {{!}}
{{{born|}}}
{{!}}-
|}}
|}';

		$fullInfoboxOutput = '<infobox>
	<image source="image"/>
	<title source="name"><default>{{PAGENAME}}</default></title>
	<data source="born"><label>born</label></data>
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
				"<infobox>\n\t<title source=\"title\"><default>{{PAGENAME}}</default></title>\n</infobox>\n",
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
			/* @todo: Common case to try to account for, uncomment when improving
			[
				"{{PAGENAME}}\n{{{{#if:{{{length|}}}|:{{{length|}}}|bar}}}}",
				"<infobox>\n\t<data source=\"length\"><label>length</label></data>\n</infobox>\n",
				'More than three curly braces with a template parameter inside',
			],*/
		];
	}
}
