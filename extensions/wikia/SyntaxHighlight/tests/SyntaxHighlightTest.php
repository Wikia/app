<?php

/**
 * @group Integration
 */
class SyntaxHighlightTest extends WikiaBaseTest {
	/** @var Parser $parser */
	private $parser;

	/** @var ParserOptions $opts */
	private $opts;

	/** @var Title $title */
	private $title;

	protected function setUp() {
		$this->setupFile = __DIR__ . '/../SyntaxHighlight.setup.php';
		parent::setUp();

		Hooks::register( 'ParserFirstCallInit', 'SyntaxHighlightHooks::onParserFirstCallInit' );

		$this->title = new Title();
		$this->opts = new ParserOptions();
		$this->parser = new Parser();
	}

	/**
	 * @dataProvider syntaxHighlightDataProvider
	 *
	 * @param string $input
	 * @param string $expectedOutput
	 */
	public function testParserTag( string $input, string $expectedOutput ) {
		$out = $this->parser->parse( $input, $this->title, $this->opts );

		$actualOutput = rtrim( $out->getText() );
		$this->assertEquals( $expectedOutput, $actualOutput );
		$this->assertContains( 'ext.syntaxHighlight.light', $out->getModules() );
	}

	public function syntaxHighlightDataProvider() {
		return [
			'source tag' => [
				'<source lang="javascript">my awesome code</source>',
				'<pre class="source javascript" dir="ltr">my awesome code</pre>'
			],
			'syntaxhighlight tag' => [
				'<syntaxhighlight lang="javascript">my awesome code</syntaxhighlight>',
				'<pre class="source javascript" dir="ltr">my awesome code</pre>'
			],
			'tag with html content' => [
				'<source lang="javascript">my <script>alert("hack");</script> code</source>',
				'<pre class="source javascript" dir="ltr">my &lt;script>alert("hack");&lt;/script> code</pre>'
			]
		];
	}
}
