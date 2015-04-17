<?php

class MediaWikiParserService {

	protected $parser;
	protected $localParser;

	public function __construct( $parser ) {
		$this->parser = $parser;
	}

	public function parse( $wikitext ) {
		return $this->getParserInstance()
			->parse( $wikitext, $this->getParserTitle(), $this->getParserOptions(), false )
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
			$this->localParser = new Parser();
		}
		return $this->localParser;
	}

}