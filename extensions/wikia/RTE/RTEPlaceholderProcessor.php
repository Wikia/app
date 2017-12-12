<?php

/**
 * Class RTEPlaceholderProcessor
 */
class RTEPlaceholderProcessor {
	/** @var Parser $parser */
	private $parser;

	/**
	 * The parser options used in the current parsing context
	 * @var ParserOptions $parserOptions
	 */
	private $parserOptions;

	/**
	 * Title of the page being parsed
	 * @var Title $title
	 */
	private $title;

	public function __construct( Parser $parser, ParserOptions $parserOptions, Title $title ) {
		$this->parser = $parser;
		$this->parserOptions = $parserOptions;
		$this->title = $title;
	}

	/**
	 * Callback function for preg_replace_callback which handle placehodler markers.
	 * Called from RTEParser class.
	 * @see RTEParser::parse()
	 *
	 * @author: Inez Korczyński
	 * @param $var
	 * @return string|null
	 */
	public function replacePlaceholder( $var ) {
		wfProfileIn( __METHOD__ );
		$data = RTEData::get( 'placeholder', intval( $var[1] ) );

		if ( !$data ) {
			return '';
		}

		wfProfileOut( __METHOD__ );
		return RTE::renderPlaceholder( $data['type'], $data );
	}
}
