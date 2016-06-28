<?php

class NavigationTemplateTest extends WikiaBaseTest {

	/**
	 * @dataProvider markedTemplateContentProvider
	 */
	public function testMarkNavigationElements( $content, $expected, $message ) {
		$marked = NavigationTemplate::handle( $content );

		$this->assertEquals( $expected,
			preg_match( $markerRegex = "/<\x7f" . NavigationTemplate::MARK . ".+?\x7f>/s", $marked ), $message );
	}

	public function markedTemplateContentProvider() {
		return [
			[ '', 0, 'Empty content was marked' ],
			[ '1', 1, 'Numbers should be marked' ],
			[ '{{#invoke: Eras|main}}', 1, 'Wikitext should be marked' ],
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
				"<p><\x7fNAVUNIQ_342\x7f>\n</p>fakjsdlkjflk <div>asdf</div>kasjdlfkjdks ksdjlafkj<p></\x7fNAVUNIQ_342\x7f>\n</p>NAVUNIQ aksdjlfkj alksjdldf\nlkjsdl <p><\x7fNAVUNIQ_343\x7f>\n</p>d<p></\x7fNAVUNIQ_343\x7f>\n</p>",
				"NAVUNIQ aksdjlfkj alksjdldf\nlkjsdl d",
				"If block element in navigation template it should be removed"
			],
			[
				"<p><\x7fNAVUNIQ_342\x7f>\n</p>akjsdlkjflk <div>asdf</div>kasjdlfkjdks ksdjlafkj<p></\x7fNAVUNIQ_342\x7f>\n</p> test",
				" test",
				"Single nav template with block should be removed"
			],
			[
				"<p>&lt;\x7fNAVUNIQ_342\x7f&gt;\n</p>akjsdlkjflk <div>asdf</div>kasjdlfkjdks ksdjlafkj<p>&lt;/\x7fNAVUNIQ_342\x7f&gt;\n</p> test",
				" test",
				"Single nav template with block should be removed, even when encoded"
			],
			[
				"<p><\x7fNAVUNIQ_342\x7f>\n</p>asdf<p></\x7fNAVUNIQ_342\x7f>\n</p> test",
				"asdf test",
				"Single inline element should be left"
			],
			[
				"<p><\x7fNAVUNIQ_342\x7f>\n</p><div>some content <p><\x7fNAVUNIQ_343\x7f>\n</p> <p>nested template</p> <p></\x7fNAVUNIQ_343\x7f>\n</p> <p><\x7fNAVUNIQ_344\x7f>\n</np> <p>nested template</p> <p></\x7fNAVUNIQ_344\x7f>\n</p></div><p></\x7fNAVUNIQ_342\x7f>\n</p>",
				"",
				"nested templates with block element and one nested template without block elements, everything should be removed"
			],
			[
				"<p><\x7fNAVUNIQ_342\x7f>\n</p><div>some content <p><\x7fNAVUNIQ_343\x7f>\n</p> <p>nested template</p> <p></\x7fNAVUNIQ_343\x7f>\n</p> <p><\x7fNAVUNIQ_344\x7f>\n</p> nested template <p></\x7fNAVUNIQ_344\x7f>\n</p></div><p></\x7fNAVUNIQ_342\x7f>\n</p>",
				"",
				"nested templates with block elements, everything should be removed"
			],
			[
				"<p><\x7fNAVUNIQ_342\x7f>\n</p><a>some content <p><\x7fNAVUNIQ_343\x7f>\n</p> <a>nested template</a> <p><\x7fNAVUNIQ_346\x7f>\n</p> <a>nested nested template</a><p><\x7fNAVUNIQ_347\x7f>\n</p> <a>nested nested nested template</a><p><\x7fNAVUNIQ_348\x7f>\n</p> <a>nested nested nested template</a> <p></\x7fNAVUNIQ_348\x7f>\n</p> <p></\x7fNAVUNIQ_347\x7f>\n</p> <p></\x7fNAVUNIQ_346\x7f>\n</p> <p></\x7fNAVUNIQ_343\x7f>\n</p> <p><\x7fNAVUNIQ_344\x7f>\n</p> <a>nested template</a> <p></\x7fNAVUNIQ_344\x7f>\n</p></a><p></\x7fNAVUNIQ_342\x7f>\n</p>",
				"<a>some content  <a>nested template</a>  <a>nested nested template</a> <a>nested nested nested template</a> <a>nested nested nested template</a>      <a>nested template</a> </a>",
				"nested templates without block elements, nothing should be removed if there is no block element"
			],
			[
				"<p><\x7fNAVUNIQ_342\x7f>\n</p><a>some content <p><\x7fNAVUNIQ_343\x7f>\n</p> <a>nested template</a> <p><\x7fNAVUNIQ_346\x7f>\n</p> <a>nested nested template</a><p><\x7fNAVUNIQ_347\x7f>\n</p> <p>nested nested nested template</p><p><\x7fNAVUNIQ_348\x7f>\n</p> <a>nested nested nested template</a> <p></\x7fNAVUNIQ_348\x7f>\n</p><p></\x7fNAVUNIQ_347\x7f>\n</p><p></\x7fNAVUNIQ_346\x7f>\n</p><p></\x7fNAVUNIQ_343\x7f>\n</p><p><\x7fNAVUNIQ_344\x7f>\n</p> <a>nested template</a> <p></\x7fNAVUNIQ_344\x7f>\n</p></a><p></\x7fNAVUNIQ_342\x7f>\n</p>",
				"",
				"block element within the most inner template, everything should be removed"
			],
			[
				"<p><\x7fNAVUNIQ_342\x7f>\n</p> <a>something</a> <p></\x7fNAVUNIQ_342\x7f>\n</p><p><\x7fNAVUNIQ_343\x7f>\n</p><p>something2</p><p></\x7fNAVUNIQ_343\x7f>\n</p><p><\x7fNAVUNIQ_342\x7f>\n</p>something<p></\x7fNAVUNIQ_342\x7f>\n</p><p><\x7fNAVUNIQ_343\x7f>\n</p><div>something2</div><p></\x7fNAVUNIQ_343\x7f>\n</p>",
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
				"<\x7fNAVUNIQ_342\x7f>
				some wikitext within NAVUNIQ_342  marks
				</\x7fNAVUNIQ_342\x7f>",

				"<\x7fNAVUNIQ_342\x7f>
				some wikitext within NAVUNIQ_342  marks
				</\x7fNAVUNIQ_342\x7f>",

				"outer marks should not be removed"
			],
			[
				"<\x7fNAVUNIQ_342\x7f>\nsome <\x7fNAVUNIQ_344\x7f>\nwikitext within\n</\x7fNAVUNIQ_344\x7f> NAVUNIQ_342  marks\n</\x7fNAVUNIQ_342\x7f>",
				"<\x7fNAVUNIQ_342\x7f>\nsome wikitext within NAVUNIQ_342  marks\n</\x7fNAVUNIQ_342\x7f>",
				"inner marks should be removed"
			],
			[
				"<\x7fNAVUNIQ_342\x7f>\n<\x7fNAVUNIQ_343\x7f>\nsome <\x7fNAVUNIQ_344\x7f>\nwikitext within\n</\x7fNAVUNIQ_344\x7f> NAVUNIQ_342  marks\n</\x7fNAVUNIQ_343\x7f>\n</\x7fNAVUNIQ_342\x7f>",
				"<\x7fNAVUNIQ_342\x7f>\nsome wikitext within NAVUNIQ_342  marks\n</\x7fNAVUNIQ_342\x7f>",
				"inner marks should be removed"
			],
			[
				"wikitext without NAVUNIQ marks",
				"wikitext without NAVUNIQ marks",
				"wikitext without NAVUNIQ marks should be unchanged"
			]
		];
	}
}
