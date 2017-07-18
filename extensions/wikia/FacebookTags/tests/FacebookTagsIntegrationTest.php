<?php

use PHPUnit\Framework\TestCase;

/**
 * @group Integration
 */
class FacebookTagsIntegrationTest extends TestCase {
	/** @var Parser $parser */
	private $parser;

	protected function setUp() {
		parent::setUp();

		$this->parser = new Parser();
		$this->parser->firstCallInit();
	}

	/**
	 * @dataProvider provideInputAndExpectedOutput
	 * @param string $givenInput
	 * @param string $expectedOutput
	 */
	public function testFacebookTagParser( string $givenInput, string $expectedOutput ) {
		$parserOutput = $this->parser->parse( $givenInput, new Title(), new ParserOptions() );
		$actualOutput = trim( $parserOutput->getText() );

		$this->assertEquals( $expectedOutput, $actualOutput );
	}

	public function provideInputAndExpectedOutput() {
		return [
			'fb:like' => [
				'<fb:like href="https://developers.facebook.com/docs/plugins/" layout="standard" action="like" size="small" show-faces="true" share="true"></fb:like>',
				'<iframe src="https://www.facebook.com/plugins/like.php?href=https%3A%2F%2Fdevelopers.facebook.com%2Fdocs%2Fplugins%2F&width=450&layout=standard&action=like&size=small&show_faces=true&share=true&height=80" width="450" height="80" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true"></iframe>'
			],
			'fb:page' => [
				'<fb:page href="https://www.facebook.com/facebook" tabs="timeline" small_header="false" adapt_container_width="true" hide_cover="false" show_facepile="true"></fb:page>',
				'<iframe src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2Ffacebook&tabs=timeline&width=340&height=500&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=true" width="340" height="500" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true"></iframe>'
			],
			'fb:like-box fallback to fb:page' => [
				'<fb:like-box href="https://www.facebook.com/facebook" tabs="timeline" small_header="false" adapt_container_width="true" hide_cover="false" show_facepile="true"></fb:page>',
				'<iframe src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2Ffacebook&tabs=timeline&width=340&height=500&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=true" width="340" height="500" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true"></iframe>'
			],
			'fb:follow' => [
				'<fb:follow href="https://www.facebook.com/zuck" layout="standard" size="small" show_faces="true"></fb:follow>',
				'<iframe src="https://www.facebook.com/plugins/follow.php?href=https%3A%2F%2Fwww.facebook.com%2Fzuck&width=450&height=80&layout=standard&size=small&show_faces=true" width="450" height="80" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true"></iframe>'
			],
			'fb:share_button' => [
				'<fb:share_button href="https://developers.facebook.com/docs/plugins/" layout="button_count" size="small" mobile_iframe="true"></fb:share_button>',
				'<iframe src="https://www.facebook.com/plugins/share_button.php?href=https%3A%2F%2Fdevelopers.facebook.com%2Fdocs%2Fplugins%2F&layout=button_count&size=small&mobile_iframe=true&width=88&height=20" width="88" height="20" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true"></iframe>'
			],
			'fb:share-button fallback to fb:share_button' => [
				'<fb:share-button href="https://developers.facebook.com/docs/plugins/" layout="button_count" size="small" mobile_iframe="true"></fb:share_button>',
				'<iframe src="https://www.facebook.com/plugins/share_button.php?href=https%3A%2F%2Fdevelopers.facebook.com%2Fdocs%2Fplugins%2F&layout=button_count&size=small&mobile_iframe=true&width=88&height=20" width="88" height="20" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true"></iframe>'
			],
		];
	}
}
