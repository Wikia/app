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
		wfProfileIn(__METHOD__);
		$parsed = $this->getParserInstance()
			->parse( $wikitext, $this->getParserTitle(), $this->getParserOptions(), false )
			->getText();
		wfProfileOut(__METHOD__);
		return $parsed;
	}

	public function parseRecursive( $wikitext ) {
		wfProfileIn(__METHOD__);
		$preprocessed = $this->parser->recursivePreprocess( $wikitext, $this->frame );
		$newlinesstripped = preg_replace( '|[\n\r]|Us', '', $preprocessed );
		$marksstripped = preg_replace( '|{{{.*}}}|Us', '', $newlinesstripped );
		wfProfileOut(__METHOD__);
		return $this->parse( $marksstripped );
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
