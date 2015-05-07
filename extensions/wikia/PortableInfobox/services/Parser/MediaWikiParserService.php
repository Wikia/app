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

	/**
	 * Method used for parsing wikitext provided through variable
	 * @param $wikitext
	 * @return mixed
	 */
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
	 * Method used for parsing wikitext provided in infobox that might contain variables
	 * @param $wikitext
	 * @return string HTML outcome
	 */
	public function parseRecursive( $wikitext ) {
		wfProfileIn( __METHOD__ );
		$withVars = $this->parser->replaceVariables( $wikitext, $this->frame );
		$parsed = $this->parse( $withVars );
		$ready = $this->parser->mStripState->unstripBoth( $parsed );
		$newlinesstripped = preg_replace( '|[\n\r]|Us', '', $ready );
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
