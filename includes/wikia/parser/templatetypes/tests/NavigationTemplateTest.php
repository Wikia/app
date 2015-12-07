<?php

class NavigationTemplateTest extends WikiaBaseTest {

	/**
	 * @param $expectedOutput
	 * @param $templateText
	 * @dataProvider getNavigationTemplates
	 */
	public function testHideNavigationWithBlockElements( $templateText, $expectedOutput, $message ) {
		$sanitizedOutput = NavigationTemplate::handle( $templateText );

		$this->assertSame( $expectedOutput, $sanitizedOutput, $message );
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
}
