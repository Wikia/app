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
		$preprocessed = $this->parser->recursivePreprocess( $wikitext, $this->frame );
		$newlinesstripped = preg_replace( '|[\n\r]|Us', '', $preprocessed );
		$marksstripped = preg_replace( '|{{{.*}}}|Us', '', $newlinesstripped );
		return $this->getParserInstance()
			->parse( $marksstripped, $this->getParserTitle(), $this->getParserOptions(), false )
			->getText();
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
