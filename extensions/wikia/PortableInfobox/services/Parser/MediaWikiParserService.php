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
		wfProfileIn( __METHOD__ );
		if ( substr( $wikitext, 0, 1 ) == "*" ) {
			//fix for first item list elements
			$wikitext = "\n" . $wikitext;
		}
		$parsedText = $this->getParserInstance()
			->parse( $wikitext, $this->getParserTitle(), $this->getParserOptions(), false )
			->getText();
		wfProfileOut( __METHOD__ );
		return $parsedText;
	}

	/**
	 * @FIXME: regardless of what is the final approach, this code needs to be explained
	 * WHY it does the things it does. Here. In docblock. Or by phrasing it explicitly with
	 * class and method names.
	 */
	public function parseRecursive( $wikitext ) {
		wfProfileIn( __METHOD__ );
		$parsed = $this->parser->internalParse( $wikitext, false, $this->frame );
		$newlinesstripped = preg_replace( '|[\n\r]|Us', '', $parsed );
		$marksstripped = preg_replace( '|{{{.*}}}|Us', '', $newlinesstripped );
		wfProfileOut( __METHOD__ );
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
