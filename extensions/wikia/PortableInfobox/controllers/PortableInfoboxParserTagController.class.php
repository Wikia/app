<?php

class PortableInfoboxParserTagController extends WikiaController {
	const PARSER_TAG_NAME = 'infobox';
	const INFOBOXES_PROPERTY_NAME = 'infoboxes';
	const DEFAULT_THEME_NAME = 'wikia';
	const INFOBOX_THEME_PREFIX = "portable-infobox-theme-";

	private $markerNumber = 0;
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
		global $wgArticleAsJson;
		$this->markerNumber++;
		$markup = '<' . self::PARSER_TAG_NAME . '>' . $text . '</' . self::PARSER_TAG_NAME . '>';

		$infoboxParser = new Wikia\PortableInfobox\Parser\XmlParser( $frame->getNamedArguments() );
		$infoboxParser->setExternalParser( ( new Wikia\PortableInfobox\Parser\MediaWikiParserService( $parser, $frame ) ) );

		try {
			$data = $infoboxParser->getDataFromXmlString( $markup );
		} catch ( \Wikia\PortableInfobox\Parser\Nodes\UnimplementedNodeException $e ) {
			return $this->handleError( wfMessage( 'unimplemented-infobox-tag', [ $e->getMessage() ] )->escaped() );
		} catch ( \Wikia\PortableInfobox\Parser\XmlMarkupParseErrorException $e ) {
			return $this->handleError( wfMessage( 'xml-parse-error' ) );
		}

		//save for later api usage
		$this->saveToParserOutput( $parser->getOutput(), $data );

		$renderer = new PortableInfoboxRenderService();
		$theme = $this->getThemeWithDefault( $params, $frame );
		$renderedValue = $renderer->renderInfobox( $data, $theme );
		if ( $wgArticleAsJson ) {
			// (wgArticleAsJson == true) it means that we need to encode output for use inside JSON
			$renderedValue = trim( json_encode( $renderedValue ), '"' );
		}

		$marker = $parser->uniqPrefix() . "-" . self::PARSER_TAG_NAME . "-{$this->markerNumber}-QINU";
		$this->markers[ $marker ] = $renderedValue;
		return [ $marker, 'markerType' => 'nowiki' ];
	}

	public function replaceMarkers( $text ) {
		return strtr( $text, $this->markers );
	}

	protected function saveToParserOutput( \ParserOutput $parserOutput, $raw ) {
		if ( !empty( $raw ) ) {
			$infoboxes = $parserOutput->getProperty( self::INFOBOXES_PROPERTY_NAME );
			$infoboxes[ ] = $raw;
			$parserOutput->setProperty( self::INFOBOXES_PROPERTY_NAME, $infoboxes );
		}
	}

	private function handleError( $message ) {
		$renderedValue = '<strong class="error"> ' . $message . '</strong>';
		return [ $renderedValue, 'markerType' => 'nowiki' ];
	}

	private function getThemeWithDefault( $params, PPFrame $frame ) {
		$value = isset( $params[ 'theme-source' ] ) ? $frame->getArgument( $params[ 'theme-source' ] ) : false;
		$themeName = $this->getThemeName( $params, $value );
		//make sure no whitespaces, prevents side effects
		return self::INFOBOX_THEME_PREFIX . preg_replace( '|\s+|s', '-', $themeName );
	}

	private function getThemeName( $params, $value ) {
		return !empty( $value ) ? $value :
			// default logic
			( isset( $params[ 'theme' ] ) ? $params[ 'theme' ] : self::DEFAULT_THEME_NAME );
	}

}
