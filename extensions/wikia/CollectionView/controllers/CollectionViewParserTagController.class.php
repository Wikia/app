<?php

class CollectionViewParserTagController extends WikiaController {
	const PARSER_TAG_NAME = 'collection';
	const COLLECTIONS_PROPERTY_NAME = 'collections';

	static $collectionIndex = 0;

	/**
	 * @desc Parser hook: used to register parser tag in MW
	 *
	 * @param Parser $parser
	 * @return bool
	 */
	public static function parserTagInit( Parser $parser ) {
		$parser->setHook( self::PARSER_TAG_NAME, [ new static(), 'renderCollectionView' ] );
		return true;
	}

	/**
	 * @desc Renders Collection View
	 *
	 * @param String $text
	 * @param Array $params
	 * @param Parser $parser
	 * @param PPFrame $frame
	 * @returns String $html
	 */
	public function renderCollectionView( $text, $params, $parser, $frame ) {
		$markup = '<' . self::PARSER_TAG_NAME . '>' . $text . '</' . self::PARSER_TAG_NAME . '>';

		$collectionViewParser = new Wikia\CollectionView\Parser\XmlParser( $frame->getNamedArguments() );
		$collectionViewParser->setExternalParser( ( new Wikia\CollectionView\Parser\MediaWikiParserService( $parser, $frame ) ) );
		$data = $collectionViewParser->getDataFromXmlString( $markup );

		$parserOutput = $parser->getOutput();
		//save for later api usage
		$this->saveToParserOutput( $parserOutput, $data );

		$renderer = new CollectionViewRenderService();
		$renderedValue = $renderer->renderCollectionView( $data, self::$collectionIndex++ );

		return [ $renderedValue, 'markerType' => 'nowiki' ];
	}

	protected function saveToParserOutput( \ParserOutput $parserOutput, $raw ) {
		if ( !empty( $raw ) ) {
			//TODO we should convert $raw to the format described in CONCF-460
			$collections = $parserOutput->getProperty( self::COLLECTIONS_PROPERTY_NAME );
			$collections[ ] = $raw;
			$parserOutput->setProperty( self::COLLECTIONS_PROPERTY_NAME, $collections );
		}
	}
}
