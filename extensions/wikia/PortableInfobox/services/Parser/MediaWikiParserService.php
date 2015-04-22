<?php
namespace Wikia\PortableInfobox\Parser;

class MediaWikiParserService implements ExternalParser {

	protected $parser;
	protected $frame;
	protected $localParser;

	public function __construct( \Parser $parser, \PPFrame $frame ) {
		$this->parser = $parser;
		$this->frame = $frame;
	}

	public function parse( $wikitext ) {
		if ( substr( $wikitext, 0, 1 ) == "*" ) {
			//fix for first item list elements
			$wikitext = "\n" . $wikitext;
		}
		$parsedText = $this->getParserInstance()
			->parse( $wikitext, $this->getParserTitle(), $this->getParserOptions(), false )
			->getText();
		return $parsedText;
	}

	/**
	 * @FIXME: regardless of what is the final approach, this code needs to be explained
	 * WHY it does the things it does. Here. In docblock. Or by phrasing it explicitly with
	 * class and method names.
	 */
	public function parseRecursive( $wikitext ) {
		$parsed = $this->parse($wikitext);
		$preprocessed = $this->parser->recursivePreprocess( $parsed, $this->frame );
		$newlinesstripped = preg_replace( '|[\n\r]|Us', '', $preprocessed );
		$marksstripped = preg_replace( '|{{{.*}}}|Us', '', $newlinesstripped );
		return $marksstripped;
	}

	private function getParserTitle() {
		return $this->parser->getTitle();
	}

	private function getParserOptions() {
		$options = $this->parser->getOptions();
		$options->enableLimitReport( false );
		return $options;
	}

	private function getParserInstance() {
		if ( !isset( $this->localParser ) ) {
			$this->localParser = new \Parser();
		}
		return $this->localParser;
	}
}
