<?php

class MediaWikiParserTest extends WikiaBaseTest {

	/** @var Parser */
	protected $parser;

	public function setUp() {
		$this->parser = new Parser();
		$title = Title::newFromText( 'test' );
		$options = new ParserOptions();
		$this->parser->startExternalParse( $title, $options, 'text', true );
		parent::setUp();
	}

	protected function parse( $wikitext, $params, $newline = false ) {
		$withVars = $this->parser->replaceVariables( $wikitext,
			$this->parser->getPreprocessor()->newCustomFrame( $params ) );
		$parserOutput = $this->parser->parse( $withVars, $this->parser->getTitle(), $this->parser->getOptions(),
			$newline );

		return preg_replace( '|{{{.*}}}|Us', '', preg_replace( '|[\n\r]|Us', '', $parserOutput->getText() ) );
	}

	public function testAsideTagPWrappedDuringParsing() {
		$aside = "<aside></aside>";
		$result = ( new Parser() )->doBlockLevels( $aside, true );
		//parser adds new line at the end of block
		$this->assertEquals( $aside . "\n", $result );
	}


	/**
	 * @dataProvider mwParserWrapperDataProvider
	 *
	 * @param $wikitext
	 * @param $params
	 */
	public function testWrapper( $wikitext, $params, $newline ) {
		$frame = $this->parser->getPreprocessor()->newCustomFrame( $params );
		$wrapper = new \Wikia\PortableInfobox\Parser\MediaWikiParserService( $this->parser, $frame );

		$output = $wrapper->parseRecursive( $wikitext );

		$this->assertEquals( $this->parse( $wikitext, $params, $newline ), $output );
	}

	public function mwParserWrapperDataProvider() {
		return [
			[ "*1\n*2\n*3", [ ], true ],
			[ "''d''", [ ], false ],
			[ "'''dd'''", [ ], false ],
			[ "#1\n#2\n#3 ksajdlk", [ ], true ],
			[ "{{{test}}}", [ 'test' => 1 ], false ],
			[ " :asdf", [ ], false ],
			[ "\n:asdf", [ ], false ],
			[ "\n;asdf", [ ], false ],
			[ "[[asdf]]", [ ], false ]
		];
	}
}