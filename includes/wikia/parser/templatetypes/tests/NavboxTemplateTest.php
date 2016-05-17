<?php

class NavboxTemplateTest extends WikiaBaseTest {

	public function testUnclosedMarker() {
		$html = 'Lorem ipsum dolor sit amet dolor. Aliquam commodo turpis in faucibus' .
				' massa sit amet, purus. Phasellus tellus tortor, a diam. Suspendisse at tortor. Maecenas id ipsum.' .
				' Nulla venenatis. Morbi sit amet lorem. In mauris sit amet, varius risus in nonummy laoreet, ante ' .
				'ipsum dolor sit amet, tellus. Nulla congue. Lorem ipsum ac purus. Phasellus ornare nisl, eu ' .
				'scelerisque a, fermentum quis, accumsan eu, rhoncus purus, nec diam. Aliquam semper. Sed aliquet ' .
				'commodo turpis egestas. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ' .
				'ridiculus mus. Curabitur tempor. Phasellus consequat. Integer mi at justo. Nulla dolor cursus lectus,' .
				' pellentesque quis, tincidunt risus at tellus felis facilisis neque, a ante ipsum orci, sollicitudin ' .
				'non, lobortis venenatis, nunc eu enim. Pellentesque sed est. Donec non luctus ullamcorper pellentesque.';
		$result = "&lt;NAVBOXUNIQ_5735851f2f565&gt;{$html}";

		NavboxTemplate::resolve( $result );

		$this->assertEquals( $html, $result );
	}

	/**
	 * @dataProvider markedTemplateContentProvider
	 */
	public function testMarkNavigationElements( $content, $expected, $message ) {
		$marked = NavboxTemplate::handle( $content );

		$this->assertEquals( $expected, preg_match( $markerRegex = "/<\x7f" . NavboxTemplate::MARK . ".+?\x7f>/s", $marked ), $message );
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
		NavboxTemplate::resolve( $marked );

		$this->assertEquals( $expected, $marked, $message );
	}

	public function articleHtmlProvided() {
		return [
			[ "", "", "Empty html should be correctly processed" ],
			[
				"<\x7fNAVBOXUNIQ_342\x7f>fakjsdlkjflk <div>asdf</div>kasjdlfkjdks ksdjlafkj</\x7fNAVBOXUNIQ_342\x7f>NAVBOXUNIQ aksdjlfkj alksjdldf\nlkjsdl <\x7fNAVBOXUNIQ_343\x7f>d</\x7fNAVBOXUNIQ_343\x7f>",
				"<div data-type=\"navbox\">fakjsdlkjflk <div>asdf</div>kasjdlfkjdks ksdjlafkj</div>NAVBOXUNIQ aksdjlfkj alksjdldf\nlkjsdl <div data-type=\"navbox\">d</div>",
				"Multiple navboxes marked"
			],
			[
				"<\x7fNAVBOXUNIQ_342\x7f>akjsdlkjflk <div>asdf</div>kasjdlfkjdks ksdjlafkj</\x7fNAVBOXUNIQ_342\x7f> test",
				"<div data-type=\"navbox\">akjsdlkjflk <div>asdf</div>kasjdlfkjdks ksdjlafkj</div> test",
				"Single navbox"
			],
			[
				"&lt;\x7fNAVBOXUNIQ_342\x7f&gt;akjsdlkjflk <div>asdf</div>kasjdlfkjdks ksdjlafkj&lt;/\x7fNAVBOXUNIQ_342\x7f&gt; test",
				"<div data-type=\"navbox\">akjsdlkjflk <div>asdf</div>kasjdlfkjdks ksdjlafkj</div> test",
				"Single encoded navbox"
			],
			[
				"<\x7fNAVBOXUNIQ_342\x7f><div>some content <\x7fNAVBOXUNIQ_343\x7f> <p>nested template</p> </\x7fNAVBOXUNIQ_343\x7f> <\x7fNAVBOXUNIQ_344\x7f> <p>nested template</p> </\x7fNAVBOXUNIQ_344\x7f></div></\x7fNAVBOXUNIQ_342\x7f>",
				"<div data-type=\"navbox\"><div>some content <div data-type=\"navbox\"> <p>nested template</p> </div> <div data-type=\"navbox\"> <p>nested template</p> </div></div></div>",
				"Nested navboxes should be marked"
			],
			[
				"<\x7fNAVBOXUNIQ_342\x7f> <a>something</a> </\x7fNAVBOXUNIQ_342\x7f><\x7fNAVBOXUNIQ_343\x7f><p>something2</p></\x7fNAVBOXUNIQ_343\x7f><\x7fNAVBOXUNIQ_342\x7f>something</\x7fNAVBOXUNIQ_342\x7f><\x7fNAVBOXUNIQ_343\x7f><div>something2</div></\x7fNAVBOXUNIQ_343\x7f>",
				"<div data-type=\"navbox\"> <a>something</a> </div><div data-type=\"navbox\"><p>something2</p></div><div data-type=\"navbox\">something</div><div data-type=\"navbox\"><div>something2</div></div>",
				"multiple invocations of the same template"
			]
		];
	}
}
