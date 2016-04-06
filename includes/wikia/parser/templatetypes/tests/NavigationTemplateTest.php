<?php

class NavigationTemplateTest extends WikiaBaseTest {

	/**
	 * @dataProvider markedTemplateContentProvider
	 */
	public function testMarkNavigationElements( $content, $expected, $message ) {
		$marked = NavigationTemplate::handle( $content );

		$this->assertEquals( $expected, $marked, $message );
	}

	public function markedTemplateContentProvider() {
		return [
			[ '', '', 'Empty content was marked' ],
			[ '1', "\x7f" . 'NAVUNIQ1NAVUNIQ' . "\x7f", 'Numbers should be marked' ],
			[ '{{#invoke: Eras|main}}', "\x7f" . 'NAVUNIQ{{#invoke: Eras|main}}NAVUNIQ' . "\x7f",
			  'Wikitext should be marked' ],
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
			],
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
				"\x7fNAVUNIQakjsdlkjflk <div>asdf</div>kasjdlfkjdks ksdjlafkjNAVUNIQ\x7fNAVUNIQ aksdjlfkj alksjdldf\nlkjsdl \x7fNAVUNIQdNAVUNIQ\x7f",
				"NAVUNIQ aksdjlfkj alksjdldf\nlkjsdl d",
				"If block element in navigation template it should be removed"
			],
			[
				"\x7fNAVUNIQakjsdlkjflk <div>asdf</div>kasjdlfkjdks ksdjlafkjNAVUNIQ\x7f test",
				" test",
				"Single nav template with block should be removed"
			],
			[
				"\x7fNAVUNIQasdfNAVUNIQ\x7f test",
				"asdf test",
				"Single inline element should be left"
			]
		];
	}
}
