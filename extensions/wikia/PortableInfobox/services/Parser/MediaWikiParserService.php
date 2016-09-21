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
	 * Method used for parsing wikitext provided in infobox that might contain variables
	 *
	 * @param $wikitext
	 *
	 * @return string HTML outcome
	 */
	public function parseRecursive( $wikitext ) {
		wfProfileIn( __METHOD__ );
		if ( in_array( substr( $wikitext, 0, 1 ), [ '*', '#' ] ) ) {
			//fix for first item list elements
			$wikitext = "\n" . $wikitext;
		}
		$parsed = $this->parser->internalParse( $wikitext, false, $this->frame );
		$output = $this->parser->doBlockLevels( $parsed, false );
		$ready = $this->parser->mStripState->unstripBoth( $output );
		$this->parser->replaceLinkHolders( $ready );
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
	 *
	 * @param string $title
	 */
	public function addImage( $title ) {
		$file = wfFindFile( $title );
		$tmstmp = $file ? $file->getTimestamp() : false;
		$sha1 = $file ? $file->getSha1() : false;
		$this->parser->getOutput()->addImage( $title, $tmstmp, $sha1 );
	}
}
