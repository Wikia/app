<?php
namespace Wikia\CollectionView\Parser;

class MediaWikiParserService implements ExternalParser {

	protected $parser;
	protected $frame;
	protected $localParser;

	public function __construct( \Parser $parser, \PPFrame $frame ) {
		$this->parser = $parser;
		$this->frame = $frame;
	}

	public function parse( $wikitext ) {
		return $this->getParserInstance()
			->parse( $wikitext, $this->getParserTitle(), $this->getParserOptions(), false )
			->getText();
	}

	public function parseRecursive( $wikitext ) {
		$preprocessed = $this->parser->recursivePreprocess( $wikitext, $this->frame );
		$newlinesstripped = preg_replace( '|[\n\r]|Us', '', $preprocessed );
		$marksstripped = preg_replace( '|{{{.*}}}|Us', '', $newlinesstripped );
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
