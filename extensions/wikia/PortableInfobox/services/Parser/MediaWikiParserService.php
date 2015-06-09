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
		//save current options state, as it'll be overridden by new instance when parse is invoked
		$options = $this->getParserOptions();
		$tmpOptions = clone $options;
		$tmpOptions->setIsPartialParse( true );

		$output = $this->parser->parse( $wikitext, $this->getParserTitle(), $tmpOptions, false, false )->getText();
		//restore options state
		$this->parser->Options( $options );

		wfProfileOut( __METHOD__ );
		return $output;
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

	public function replaceVariables( $wikitext ) {
		$output = $this->parser->replaceVariables( $wikitext, $this->frame );
		return $output;
	}

	/**
	 * Add image to parser output for later usage
	 * @param string $title
	 */
	public function addImage( $title ) {
		$file = wfFindFile( $title );
		$tmstmp = $file ? $file->getTimestamp() : false;
		$sha1 = $file ? $file->getSha1() : false;
		$this->parser->getOutput()->addImage( $title, $tmstmp, $sha1 );
	}

	private function getParserTitle() {
		return $this->parser->getTitle();
	}

	private function getParserOptions() {
		$options = $this->parser->getOptions();
		$options->enableLimitReport( false );
		return $options;
	}
}
