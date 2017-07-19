<?php
class ReverseParserTest extends WikiaBaseTest {

	/* @var RTEReverseParser */
	private $reverseParser;

	function setUp() {
		$this->setupFile = __DIR__ . "/..//RTE_setup.php";
		parent::setUp();

		$this->reverseParser = new RTEReverseParser();
	}

	/**
	 * @dataProvider reverseParserDataProvider
	 * @param $markup
	 * @param $expectedWikitext
	 */
	function testReverseParser( $markup, $expectedWikitext ) {
		$this->assertEquals(
			$expectedWikitext,
			$this->reverseParser->parse( $markup ) );
	}

	public function reverseParserDataProvider() {
		return [
			[
				'<h2>123</h2>',
				'==123=='
			],
			[
				'<p data-rte-fromparser="true">This is a test page</p><p data-rte-empty-lines-before="1" data-rte-fromparser="true">óćżńłćżńćżłć</p><p data-rte-fromparser="true"> </p><p data-rte-empty-lines-before="3" data-rte-fromparser="true"><img alt="" class="image thumb" data-image-="" data-image-key="BB-Funny.jpg" data-rte-meta="%7B%22type%22%3A%22image%22%2C%22wikitext%22%3A%22%5B%5BFile%3ABB-Funny.jpg%7Cthumb%5D%5D%22%2C%22title%22%3A%22BB-Funny.jpg%22%2C%22params%22%3A%7B%22thumbnail%22%3Atrue%2C%22alt%22%3A%22BB-Funny%22%2C%22caption%22%3A%22%22%7D%7D" height="136" name="BB-Funny.jpg" src="http://vignette-poz.wikia-dev.com/muppet/images/9/91/BB-Funny.jpg/revision/latest/scale-to-width-down/180?cb=20160114013619" type="image" width="180" /></p>',
				'This is a test page

óćżńłćżńćżłć



[[File:BB-Funny.jpg|thumb]]'
			]
		];
	}
}
