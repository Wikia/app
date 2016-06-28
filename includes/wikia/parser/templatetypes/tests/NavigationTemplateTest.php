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
	 * @param $expectedOutput
	 * @param $templateText
	 * @dataProvider getNavigationTemplates
	 */
	public function testHideNavigationWithBlockElements( $templateText, $expectedOutput, $message ) {
		$output = NavigationTemplate::handle( $templateText );
		NavigationTemplate::resolve( $output );

		$this->assertSame( $expectedOutput, $output, $message );
	}

	public function getNavigationTemplates() {
		return [
			[
				'<a>This is a <strong>template</strong> <b>without</b> a <span>block</span> element</a>.',
				'<a>This is a <strong>template</strong> <b>without</b> a <span>block</span> element</a>.',
				'A template with a link, formatting tags and a span one should be visible.',
			],
			[
				'<span>This is a template with a div <div>element</div></span>.',
				'',
				'A template with a div tag should be hidden.',
			],
			[
				'<span>This is a template with a DIV <DIV>element</DIV></span>.',
				'',
				'A template with a DIV (uppercase) tag should be hidden.',
			],
			[
				'<span>This is a template with a table <table>element</table></span>.',
				'',
				'A template with a table tag should be hidden.',
			],
			[
				'<span>This is a template with a TABLE <TABLE>element</TABLE></span>.',
				'',
				'A template with a TABLE (uppercase) tag should be hidden.',
			],
			[
				'<span>This is a template with a p <p>element</p></span>.',
				'',
				'A template with a p tag should be hidden.',
			],
			[
				'<span>This is a template with a P <P>element</P></span>.',
				'',
				'A template with a P (uppercase) tag should be hidden.',
			],
			[
				'<poem>This is a template with a poem tag. This is one is tricky and should not be matched as a p tag.</poem>.',
				'<poem>This is a template with a poem tag. This is one is tricky and should not be matched as a p tag.</poem>.',
				'A template with a poem tag should be visible.',
			]
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
				"<\x7fNAVUNIQ_342\x7f>\nfakjsdlkjflk <div>asdf</div>kasjdlfkjdks ksdjlafkj\n</\x7fNAVUNIQ_342\x7f>NAVUNIQ aksdjlfkj alksjdldf\nlkjsdl <\x7fNAVUNIQ_343\x7f>\nd\n</\x7fNAVUNIQ_343\x7f>",
				"NAVUNIQ aksdjlfkj alksjdldf\nlkjsdl d",
				"If block element in navigation template it should be removed"
			],
			[
				"<\x7fNAVUNIQ_342\x7f>\nakjsdlkjflk <div>asdf</div>kasjdlfkjdks ksdjlafkj\n</\x7fNAVUNIQ_342\x7f> test",
				" test",
				"Single nav template with block should be removed"
			],
			[
				"&lt;\x7fNAVUNIQ_342\x7f&gt;\nakjsdlkjflk <div>asdf</div>kasjdlfkjdks ksdjlafkj\n&lt;/\x7fNAVUNIQ_342\x7f&gt; test",
				" test",
				"Single nav template with block should be removed, even when encoded"
			],
			[
				"<\x7fNAVUNIQ_342\x7f>\nasdf\n</\x7fNAVUNIQ_342\x7f> test",
				"asdf test",
				"Single inline element should be left"
			],
			[
				"<\x7fNAVUNIQ_342\x7f>\n<div>some content <\x7fNAVUNIQ_343\x7f>\n <p>nested template</p> \n</\x7fNAVUNIQ_343\x7f> <\x7fNAVUNIQ_344\x7f>\n <p>nested template</p> \n</\x7fNAVUNIQ_344\x7f></div>\n</\x7fNAVUNIQ_342\x7f>",
				"",
				"nested templates with block element and one nested template without block elements, everything should be removed"
			],
			[
				"<\x7fNAVUNIQ_342\x7f>\n<div>some content <\x7fNAVUNIQ_343\x7f>\n <p>nested template</p> \n</\x7fNAVUNIQ_343\x7f> <\x7fNAVUNIQ_344\x7f>\n nested template \n</\x7fNAVUNIQ_344\x7f></div>\n</\x7fNAVUNIQ_342\x7f>",
				"",
				"nested templates with block elements, everything should be removed"
			],
			[
				"<\x7fNAVUNIQ_342\x7f>\n<a>some content <\x7fNAVUNIQ_343\x7f>\n <a>nested template</a> <\x7fNAVUNIQ_346\x7f>\n <a>nested nested template</a><\x7fNAVUNIQ_347\x7f>\n <a>nested nested nested template</a><\x7fNAVUNIQ_348\x7f>\n <a>nested nested nested template</a> \n</\x7fNAVUNIQ_348\x7f> \n</\x7fNAVUNIQ_347\x7f> \n</\x7fNAVUNIQ_346\x7f> \n</\x7fNAVUNIQ_343\x7f> <\x7fNAVUNIQ_344\x7f>\n <a>nested template</a> \n</\x7fNAVUNIQ_344\x7f></a>\n</\x7fNAVUNIQ_342\x7f>",
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
