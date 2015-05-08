<?php

class PortableInfoboxParserTagController extends WikiaController {
	const PARSER_TAG_NAME = 'infobox';
	const INFOBOXES_PROPERTY_NAME = 'infoboxes';

	private $count = 0;
	private $markers = [ ];

	protected static $instance;

	/**
	 * @return PortableInfoboxParserTagController
	 */
	public static function getInstance() {
		if ( !isset( static::$instance ) ) {
			static::$instance = new PortableInfoboxParserTagController();
		}
		return static::$instance;
	}

	/**
	 * @desc Parser hook: used to register parser tag in MW
	 *
	 * @param Parser $parser
	 * @return bool
	 */
	public static function parserTagInit( Parser $parser ) {
		$parser->setHook( self::PARSER_TAG_NAME, [ static::getInstance(), 'renderInfobox' ] );
		return true;
	}

	/**
	 * Parser hook: used to replace infobox markes put on rendering
	 * @param $text
	 * @return string
	 */
	public static function replaceInfoboxMarkers( &$parser, &$text ) {
		$text = static::getInstance()->replaceMarkers( $text );
		return true;
	}

	/**
	 * @desc Renders Infobox
	 *
	 * @param String $text
	 * @param Array $params
	 * @param Parser $parser
	 * @param PPFrame $frame
	 * @returns String $html
	 */
	public function renderInfobox( $text, $params, $parser, $frame ) {
		$this->count++;
		$markup = '<' . self::PARSER_TAG_NAME . '>' . $text . '</' . self::PARSER_TAG_NAME . '>';

		$infoboxParser = new Wikia\PortableInfobox\Parser\XmlParser( $frame->getNamedArguments() );
		$infoboxParser->setExternalParser( ( new Wikia\PortableInfobox\Parser\MediaWikiParserService( $parser, $frame ) ) );

		try {
			$data = $infoboxParser->getDataFromXmlString( $markup );
		} catch ( \Wikia\PortableInfobox\Parser\Nodes\UnimplementedNodeException $e ) {

			return [ $this->renderUnimplementedTagErrorMesssage( $e->getMessage() ), 'markerType' => 'nowiki' ];
		}

		//save for later api usage
		$this->saveToParserOutput( $parser->getOutput(), $data );

		$renderer = new PortableInfoboxRenderService();
		$renderedValue = $renderer->renderInfobox( $data );

		$marker = $parser->uniqPrefix() . "-" . self::PARSER_TAG_NAME . "-{$this->count}-QINU";
		$this->markers[ $marker ] = $renderedValue;
		return [ $marker, 'markerType' => 'nowiki' ];
	}

	public function replaceMarkers( $text ) {
		return strtr( $text, $this->markers );
	}

	private function renderUnimplementedTagErrorMesssage( $tagName ) {
		$renderedValue = '<strong class="error"> '
			. wfMessage( 'unimplemented-infobox-tag', [ $tagName ] )->escaped()
			. '</strong>';
		return $renderedValue;
	}

	protected function saveToParserOutput( \ParserOutput $parserOutput, $raw ) {
		if ( !empty( $raw ) ) {
			$infoboxes = $parserOutput->getProperty( self::INFOBOXES_PROPERTY_NAME );
			$infoboxes[ ] = $raw;
			$parserOutput->setProperty( self::INFOBOXES_PROPERTY_NAME, $infoboxes );
		}
	}

}
