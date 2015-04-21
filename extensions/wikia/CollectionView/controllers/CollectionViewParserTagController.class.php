<?php

class CollectionViewParserTagController extends WikiaController {
	const PARSER_TAG_NAME = 'collection';
//	const INFOBOXES_PROPERTY_NAME = 'infoboxes';

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
		//save for later api usage
//		$this->saveToParserOutput( $parser->getOutput(), $data );

		$renderer = new CollectionViewRenderService();
		$renderedValue = $renderer->renderCollectionView( $data );

		return [ $renderedValue, 'markerType' => 'nowiki' ];
	}

//	protected function saveToParserOutput( \ParserOutput $parserOutput, $raw ) {
//		if ( !empty( $raw ) ) {
//			$infoboxes = $parserOutput->getProperty( self::INFOBOXES_PROPERTY_NAME );
//			$infoboxes[ ] = $raw;
//			$parserOutput->setProperty( self::INFOBOXES_PROPERTY_NAME, $infoboxes );
//		}
//	}

}
