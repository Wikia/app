<?php

use Wikia\PortableInfobox\Parser\Nodes;

class PortableInfoboxParserTagController extends WikiaController {
	const PARSER_TAG_NAME = 'infobox';
	const DEFAULT_THEME_NAME = 'wikia';
	const DEFAULT_LAYOUT_NAME = 'default';
	const INFOBOX_THEME_PREFIX = 'pi-theme-';
	const INFOBOX_LAYOUT_PREFIX = 'pi-layout-';

	private $markerNumber = 0;
	private $markers = [ ];
	private $supportedLayouts = [
		'default',
		'stacked'
	];

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
	 *
	 * @return bool
	 */
	public static function parserTagInit( Parser $parser ) {
		$parser->setHook( self::PARSER_TAG_NAME, [ static::getInstance(), 'renderInfobox' ] );

		return true;
	}

	/**
	 * Parser hook: used to replace infobox markes put on rendering
	 *
	 * @param $text
	 *
	 * @return string
	 */
	public static function replaceInfoboxMarkers( &$parser, &$text ) {
		$text = static::getInstance()->replaceMarkers( $text );

		return true;
	}

	/**
	 * @param $markup
	 * @param Parser $parser
	 * @param PPFrame $frame
	 * @param array $params
	 *
	 * @return string
	 * @throws UnimplementedNodeException when node used in markup does not exists
	 * @throws XmlMarkupParseErrorException xml not well formatted
	 * @throws InvalidInfoboxParamsException when unsupported attributes exist in params array
	 */
	public function render( $markup, Parser $parser, PPFrame $frame, $params = null ) {
		$frameArguments = $frame->getArguments();
		$infoboxNode = Nodes\NodeFactory::newFromXML( $markup, $frameArguments ? $frameArguments : [ ] );
		$infoboxNode->setExternalParser( new Wikia\PortableInfobox\Parser\MediaWikiParserService( $parser, $frame ) );

		//get params if not overridden
		if ( !isset( $params ) ) {
			$params = ( $infoboxNode instanceof Nodes\NodeInfobox ) ? $infoboxNode->getParams() : [ ];
		}

		$infoboxParamsValidator = new Wikia\PortableInfobox\Helpers\InfoboxParamsValidator();
		$infoboxParamsValidator->validateParams( $params );

		$data = $infoboxNode->getRenderData();
		//save for later api usage
		$this->saveToParserOutput( $parser->getOutput(), $infoboxNode );

		$theme = $this->getThemeWithDefault( $params, $frame );
		$layout = $this->getLayout( $params );

		return ( new PortableInfoboxRenderService() )->renderInfobox( $data, $theme, $layout );
	}

	/**
	 * @desc Renders Infobox
	 *
	 * @param String $text
	 * @param Array $params
	 * @param Parser $parser
	 * @param PPFrame $frame
	 *
	 * @returns String $html
	 */
	public function renderInfobox( $text, $params, $parser, $frame ) {
		$this->markerNumber++;
		$markup = '<' . self::PARSER_TAG_NAME . '>' . $text . '</' . self::PARSER_TAG_NAME . '>';

		try {
			$renderedValue = $this->render( $markup, $parser, $frame, $params );
		} catch ( \Wikia\PortableInfobox\Parser\Nodes\UnimplementedNodeException $e ) {
			return $this->handleError( wfMessage( 'portable-infobox-unimplemented-infobox-tag', [ $e->getMessage() ] )->escaped() );
		} catch ( \Wikia\PortableInfobox\Parser\XmlMarkupParseErrorException $e ) {
			return $this->handleXmlParseError( $e->getErrors(), $text );
		} catch ( \Wikia\PortableInfobox\Helpers\InvalidInfoboxParamsException $e ) {
			return $this->handleError( wfMessage( 'portable-infobox-xml-parse-error-infobox-tag-attribute-unsupported', [ $e->getMessage() ] )->escaped() );
		}

		$marker = $parser->uniqPrefix() . "-" . self::PARSER_TAG_NAME . "-{$this->markerNumber}\x7f-QINU";
		$this->markers[ $marker ] = $renderedValue;

		return [ $marker, 'markerType' => 'nowiki' ];
	}

	public function replaceMarkers( $text ) {
		wfProfileIn( __METHOD__ );

		global $wgArticleAsJson;

		if ( !empty( $wgArticleAsJson ) && !empty( $this->markers ) ) {
			$text = $this->moveFirstInfoboxToTop( $text );
		}

		$articleWithMarkersReplaced = strtr( $text, $this->markers );

		wfProfileOut( __METHOD__ );

		return $articleWithMarkersReplaced;
	}

	protected function saveToParserOutput( \ParserOutput $parserOutput, Nodes\NodeInfobox $raw ) {
		// parser output stores this in page_props table, therefore we can reuse the data in data provider service
		// (see: PortableInfoboxDataService.class.php)
		if ( $raw ) {
			$infoboxes = json_decode( $parserOutput->getProperty( PortableInfoboxDataService::INFOBOXES_PROPERTY_NAME ), true );
			$infoboxes[] = [ 'data' => $raw->getRenderData(), 'sourcelabels' => $raw->getSourceLabel() ];
			$parserOutput->setProperty( PortableInfoboxDataService::INFOBOXES_PROPERTY_NAME, json_encode( $infoboxes ) );
		}
	}

	private function handleError( $message ) {
		$renderedValue = '<strong class="error"> ' . $message . '</strong>';

		return [ $renderedValue, 'markerType' => 'nowiki' ];
	}

	private function handleXmlParseError( $errors, $xmlMarkup ) {
		$errorRenderer = new PortableInfoboxErrorRenderService( $errors );
		if ( $this->wg->Title && $this->wg->Title->getNamespace() == NS_TEMPLATE ) {
			$renderedValue = $errorRenderer->renderMarkupDebugView( $xmlMarkup );
		} else {
			$renderedValue = $errorRenderer->renderArticleMsgView();
		}

		return [ $renderedValue, 'markerType' => 'nowiki' ];
	}

	private function getThemeWithDefault( $params, PPFrame $frame ) {
		$value = isset( $params[ 'theme-source' ] ) ? $frame->getArgument( $params[ 'theme-source' ] ) : false;
		$themeName = $this->getThemeName( $params, $value );

		//make sure no whitespaces, prevents side effects
		return Sanitizer::escapeClass( self::INFOBOX_THEME_PREFIX . preg_replace( '|\s+|s', '-', $themeName ) );
	}

	private function getThemeName( $params, $value ) {
		return !empty( $value ) ? $value :
			// default logic
			( isset( $params[ 'theme' ] ) ? $params[ 'theme' ] : self::DEFAULT_THEME_NAME );
	}

	private function getLayout( $params ) {
		$layoutName = isset( $params[ 'layout' ] ) ? $params[ 'layout' ] : false;
		if ( $layoutName && in_array( $layoutName, $this->supportedLayouts ) ) {
			//make sure no whitespaces, prevents side effects
			return self::INFOBOX_LAYOUT_PREFIX . $layoutName;
		}

		return self::INFOBOX_LAYOUT_PREFIX . self::DEFAULT_LAYOUT_NAME;
	}

	private function moveFirstInfoboxToTop( $article ) {
		$articleDecoded = json_decode( $article );

		if ( !empty( $articleDecoded->content ) ) {
			$firstMarker = array_keys( $this->markers )[0];
			$firstInfobox = $this->markers[$firstMarker];

			// Remove the first marker
			$this->markers[$firstMarker] = '';

			// Put the first infobox in the beginning of article content
			$articleDecoded->content = $firstInfobox . $articleDecoded->content;
		}

		return json_encode( $articleDecoded );
	}
}
