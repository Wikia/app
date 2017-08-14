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
	 * @param string $expectedTagOutput
	 */
	public function testFacebookTagParser( string $givenInput, string $expectedTagOutput ) {
		$parserOutput = $this->parser->parse( $givenInput, new Title(), new ParserOptions() );

		$this->assertContains( $expectedTagOutput, $parserOutput->getText() );
	}

	public function provideInputAndExpectedOutput() {
		return [
			'fb:like' => [
				'<fb:like href="https://developers.facebook.com/docs/plugins/" layout="standard" action="like" size="small" show_faces="true" share="true" width="450" height="80"></fb:like>',
				'<iframe width="450" height="80" src="https://www.facebook.com/plugins/like.php?href=https%3A%2F%2Fdevelopers.facebook.com%2Fdocs%2Fplugins%2F&amp;layout=standard&amp;action=like&amp;size=small&amp;show_faces=true&amp;share=true&amp;width=450&amp;height=80" scrolling="no" frameborder="0" allowtransparency="true"></iframe>'
			],
			'fb:page' => [
				'<fb:page href="https://www.facebook.com/facebook" tabs="timeline" small_header="false" adapt_container_width="true" hide_cover="false" show_facepile="true" width="340" height="500"></fb:page>',
				'<iframe width="340" height="500" src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2Ffacebook&amp;tabs=timeline&amp;small_header=false&amp;adapt_container_width=true&amp;hide_cover=false&amp;show_facepile=true&amp;width=340&amp;height=500" scrolling="no" frameborder="0" allowtransparency="true"></iframe>'
			],
			'fb:like-box fallback to fb:page' => [
				'<fb:like-box href="https://www.facebook.com/facebook" tabs="timeline" small_header="false" adapt_container_width="true" hide_cover="false" show_facepile="true" width="340" height="500"></fb:page>',
				'<iframe width="340" height="500" src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2Ffacebook&amp;tabs=timeline&amp;small_header=false&amp;adapt_container_width=true&amp;hide_cover=false&amp;show_facepile=true&amp;width=340&amp;height=500" scrolling="no" frameborder="0" allowtransparency="true"></iframe>'
			],
			'fb:follow' => [
				'<fb:follow href="https://www.facebook.com/zuck" layout="standard" size="small" show_faces="true" width="450" height="80"></fb:follow>',
				'<iframe width="450" height="80" src="https://www.facebook.com/plugins/follow.php?href=https%3A%2F%2Fwww.facebook.com%2Fzuck&amp;layout=standard&amp;size=small&amp;show_faces=true&amp;width=450&amp;height=80" scrolling="no" frameborder="0" allowtransparency="true"></iframe>'
			],
			'fb:share_button' => [
				'<fb:share_button href="https://developers.facebook.com/docs/plugins/" layout="button_count" size="small" mobile_iframe="true" width="88" height="20"></fb:share_button>',
				'<iframe width="88" height="20" src="https://www.facebook.com/plugins/share_button.php?href=https%3A%2F%2Fdevelopers.facebook.com%2Fdocs%2Fplugins%2F&amp;layout=button_count&amp;size=small&amp;mobile_iframe=true&amp;width=88&amp;height=20" scrolling="no" frameborder="0" allowtransparency="true"></iframe>'
			],
			'fb:share-button fallback to fb:share_button' => [
				'<fb:share-button href="https://developers.facebook.com/docs/plugins/" layout="button_count" size="small" mobile_iframe="true" width="88" height="20"></fb:share_button>',
				'<iframe width="88" height="20" src="https://www.facebook.com/plugins/share_button.php?href=https%3A%2F%2Fdevelopers.facebook.com%2Fdocs%2Fplugins%2F&amp;layout=button_count&amp;size=small&amp;mobile_iframe=true&amp;width=88&amp;height=20" scrolling="no" frameborder="0" allowtransparency="true"></iframe>'
			],
		];
	}
}
