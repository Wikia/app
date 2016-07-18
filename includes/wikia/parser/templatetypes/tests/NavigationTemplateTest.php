<?php

class NavigationTemplateTest extends WikiaBaseTest {

	public function testEmptyContentMarking() {
		$marked = NavigationTemplate::handle( '' );

		$dom = HtmlHelper::createDOMDocumentFromText( $marked );
		$xp = new DOMXPath( $dom );
		$result = $xp->query( NavigationTemplate::NAV_PATH, $dom );

		$this->assertEquals( 0, $result->length, 'Empty content marked' );
	}

	/**
	 * @dataProvider markedTemplateContentProvider
	 */
	public function testMarkNavigationElements( $content, $expected, $message ) {
		$marked = NavigationTemplate::handle( $content );

		$dom = HtmlHelper::createDOMDocumentFromText( $marked );
		$xp = new DOMXPath( $dom );
		$result = $xp->query( NavigationTemplate::NAV_PATH, $dom );

		$this->assertEquals( $expected, $result->item( 0 )->nodeValue, $message );
	}

	public function markedTemplateContentProvider() {
		return [
			[ '1', "\n1", 'Numbers should be marked' ],
			[ '{{#invoke: Eras|main}}', "\n{{#invoke: Eras|main}}", 'Wikitext should be marked' ],
		];
	}

	/**
	 * @dataProvider articleHtmlProvided
	 */
	public function testMultiTemplates( $marked, $expected, $message ) {
		NavigationTemplate::resolve( $marked );

		$this->assertEquals( $expected, $marked, $message );
	}

	public function articleHtmlProvided() {
		return [
			[ "", "", "Empty html should be correctly processed" ],
			[
				"<div data-navuniq=\"test\">\nfakjsdlkjflk <div>asdf</div>kasjdlfkjdks ksdjlafkj</div>\nNAVUNIQ aksdjlfkj alksjdldf\nlkjsdl <div data-navuniq=\"test_1\">\nd</div>\n",
				"\nNAVUNIQ aksdjlfkj alksjdldf\nlkjsdl \nd",
				"If block element in navigation template it should be removed"
			],
			[
				"<div data-navuniq=\"test\">\nakjsdlkjflk <div>asdf</div>kasjdlfkjdks ksdjlafkj</div> test",
				" test",
				"Single nav template with block should be removed"
			],
			[
				"<div data-navuniq=\"test\">asdf</div> test",
				"asdf test",
				"Single inline element should be left"
			],
			[
				"<div data-navuniq=\"test\"><div>some content <div data-navuniq=\"test_1\"> <p>nested template</p> </div> <div data-navuniq=\"test_2\"> <p>nested template</p> </div></div></div>",
				"",
				"nested templates with block element and one nested template without block elements, everything should be removed"
			],
			[
				"<div data-navuniq=\"test\"><div>some content <div data-navuniq=\"test_1\"> <p>nested template</p> </div> <div data-navuniq=\"test_2\"> nested template </div></div></div>",
				"",
				"nested templates with block elements, everything should be removed"
			],
			[
				"<div data-navuniq=\"test\"> <a>something</a> </div><div data-navuniq=\"test_1\">\n</p><p>something2</p></div><div data-navuniq=\"test\">something</div><div data-navuniq=\"test_1\"><div>something2</div></div>",
				" <a>something</a> something",
				"multiple invocations of the same template, those with block elements should be removed"
			]
		];
	}


	/**
	 * @dataProvider getMarkedWikitext
	 */
	public function testRemoveInnerMarks( $input, $expectedOutput, $message ) {
		$this->assertEquals( $expectedOutput, NavigationTemplate::removeInnerMarks( $input ), $message );
	}

	public function getMarkedWikitext() {
		return [
			[
				"<div data-navuniq=\"test\">\nsome wikitext within NAVUNIQ_342  marks</div>",
				"<div data-navuniq=\"test\">\nsome wikitext within NAVUNIQ_342  marks</div>",
				"outer marks should not be removed"
			],
			[
				"<div data-navuniq=\"test\">\nsome <div data-navuniq=\"test_1\">\nwikitext within\n</div> NAVUNIQ_342  marks\n</div>",
				"<div data-navuniq=\"test\">\nsome wikitext within\n NAVUNIQ_342  marks\n</div>",
				"inner marks should be removed"
			],
			[
				"<div data-navuniq=\"test\">\n<div data-navuniq=\"test_1\">\nsome <div data-navuniq=\"test_2\">\nwikitext within\n</div> NAVUNIQ_342  marks\n</div>\n</div>",
				"<div data-navuniq=\"test\">\nsome wikitext within\n NAVUNIQ_342  marks\n\n</div>",
				"multiple inner marks should be removed"
			],
			[
				"wikitext without NAVUNIQ marks",
				"wikitext without NAVUNIQ marks",
				"wikitext without NAVUNIQ marks should be unchanged"
			],
			[
				"wikitext without NAVUNIQ <div data-navuniq=\"test\">\nmarks</div>",
				"wikitext without NAVUNIQ <div data-navuniq=\"test\">\nmarks</div>",
				"inline marker"
			]
		];
	}
}
