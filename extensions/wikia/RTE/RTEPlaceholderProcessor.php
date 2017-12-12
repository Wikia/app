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

		// XW-2433 - hack starts
		if ( $data['type'] == 'double-brackets' || $data['type'] == 'ext' ) {
			$wikiText = RTEData::get( 'wikitext', intval( $data['wikitextIdx'] ) );

			// render template's wikitext
			$parserOutput = $this->parser->parse( $wikiText, $this->title, $this->parserOptions );

			// store data
			$data['placeholder'] = 1;
			$dataIdx = RTEData::put( 'data', $data );

			// wrap a template in contenteditable="false" element
			$wrapper = Html::openElement( 'div', [
				'_rte_dataidx' => sprintf( '%04d', $dataIdx ),
				'class' => "placeholder placeholder-{$data['type']}",
				'type' => $data['type'],
				'contenteditable' => 'false',
			] );

			wfProfileOut( __METHOD__ );
			return $wrapper . $parserOutput->getText() . Html::closeElement( 'div' );
		}
		// hack ends here

		wfProfileOut( __METHOD__ );
		return RTE::renderPlaceholder( $data['type'], $data );
	}
}
