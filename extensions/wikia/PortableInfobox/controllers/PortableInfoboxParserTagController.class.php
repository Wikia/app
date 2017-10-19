<?php

use \Wikia\PortableInfobox\Parser\Nodes;
use \Wikia\PortableInfobox\Helpers\InvalidInfoboxParamsException;
use \Wikia\PortableInfobox\Helpers\InfoboxParamsValidator;
use \Wikia\PortableInfobox\Parser\XmlMarkupParseErrorException;
use \Wikia\PortableInfobox\Parser\Nodes\UnimplementedNodeException;

class PortableInfoboxParserTagController extends WikiaController {
	const PARSER_TAG_NAME = 'infobox';
	const PARSER_TAG_VERSION = 2;
	const DEFAULT_THEME_NAME = 'wikia';
	const DEFAULT_LAYOUT_NAME = 'default';
	const INFOBOX_THEME_PREFIX = 'pi-theme-';
	const INFOBOX_LAYOUT_PREFIX = 'pi-layout-';
	const ACCENT_COLOR = 'accent-color';
	const ACCENT_COLOR_TEXT = 'accent-color-text';

	private $markerNumber = 0;
	private $infoboxParamsValidator = null;

	protected $markers = [ ];
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
	public static function replaceInfoboxMarkers( Parser $parser, &$text ) {
		global $wgArticleAsJson;
		// The replacements for ArticleAsJson are handled in PortableInfoboxHooks::onArticleAsJsonBeforeEncode
		if ( !$wgArticleAsJson ) {
			$text = static::getInstance()->replaceMarkers( $text );
		}

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

		$this->getParamsValidator()->validateParams( $params );

		$data = $infoboxNode->getRenderData();
		//save for later api usage
		$this->saveToParserOutput( $parser->getOutput(), $infoboxNode );

		$themeList = $this->getThemes( $params, $frame );
		$layout = $this->getLayout( $params );
		$accentColor = $this->getColor( self::ACCENT_COLOR, $params, $frame );
		$accentColorText = $this->getColor( self::ACCENT_COLOR_TEXT, $params, $frame );

		$renderService = \F::app()->checkSkin( 'wikiamobile' ) ?
			new PortableInfoboxMobileRenderService() : new PortableInfoboxRenderService();
		return $renderService->renderInfobox( $data, implode( ' ', $themeList ), $layout, $accentColor, $accentColorText );

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
		} catch ( UnimplementedNodeException $e ) {
			return $this->handleError( wfMessage( 'portable-infobox-unimplemented-infobox-tag', [ $e->getMessage() ] )->escaped() );
		} catch ( XmlMarkupParseErrorException $e ) {
			return $this->handleXmlParseError( $e->getErrors(), $text );
		} catch ( InvalidInfoboxParamsException $e ) {
			return $this->handleError( wfMessage( 'portable-infobox-xml-parse-error-infobox-tag-attribute-unsupported', [ $e->getMessage() ] )->escaped() );
		}

		$marker = $parser->uniqPrefix() . "-" . self::PARSER_TAG_NAME . "-{$this->markerNumber}" . Parser::MARKER_SUFFIX;
		$this->markers[$marker] = $renderedValue;

		return [ $marker, 'markerType' => 'nowiki' ];
	}

	/**
	 * @desc Moves the first marker to the top of article content
	 *
	 * @param String $text
	 */
	public function moveFirstMarkerToTop( &$text ) {
		if ( !empty( $this->markers ) ) {
			$firstMarker = array_keys( $this->markers )[ 0 ];

			// Skip if the first marker is already at the top
			if ( strpos( $text, $firstMarker ) !== 0 ) {
				// Remove first marker and the following whitespace
				$text = preg_replace( '/' . $firstMarker . '\s*/', '', $text, 1 );
				$text = $firstMarker . ' ' . $text;
			}
		}
	}

	public function replaceMarkers( $text ) {
		return strtr( $text, $this->markers );
	}

	protected function saveToParserOutput( \ParserOutput $parserOutput, Nodes\NodeInfobox $raw ) {
		// parser output stores this in page_props table, therefore we can reuse the data in data provider service
		// (see: PortableInfoboxDataService.class.php)
		if ( $raw ) {
			$infoboxes = json_decode(
				$parserOutput->getProperty( PortableInfoboxDataService::INFOBOXES_PROPERTY_NAME ),
				true
			);

			// When you modify this structure, remember to bump the version
			// Version is checked in PortableInfoboxDataService::load()
			$infoboxes[] = [
				'parser_tag_version' => self::PARSER_TAG_VERSION,
				'data' => $raw->getRenderData(),
				'metadata' => $raw->getMetadata()
			];

			$parserOutput->setProperty(
				PortableInfoboxDataService::INFOBOXES_PROPERTY_NAME,
				json_encode( $infoboxes )
			);
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

	private function getThemes( $params, PPFrame $frame ) {
		$themes = [ ];

		if ( isset( $params['theme'] ) ) {
			$staticTheme = trim( $params['theme'] );
			if ( !empty ( $staticTheme ) ) {
				$themes[] = $staticTheme;
			}
		}
		if ( !empty( $params['theme-source'] ) ) {
			$variableTheme = trim( $frame->getArgument( $params['theme-source'] ) );
			if ( !empty( $variableTheme ) ) {
				$themes[] = $variableTheme;
			}
		}

		// use default global theme if not present
		$themes = !empty( $themes ) ? $themes : [ self::DEFAULT_THEME_NAME ];

		return array_map( function ( $name ) {
			return Sanitizer::escapeClass( self::INFOBOX_THEME_PREFIX . preg_replace( '|\s+|s', '-', $name ) );
		}, $themes );
	}

	private function getLayout( $params ) {
		$layoutName = isset( $params[ 'layout' ] ) ? $params[ 'layout' ] : false;
		if ( $this->getParamsValidator()->validateLayout( $layoutName ) ) {
			//make sure no whitespaces, prevents side effects
			return self::INFOBOX_LAYOUT_PREFIX . $layoutName;
		}

		return self::INFOBOX_LAYOUT_PREFIX . self::DEFAULT_LAYOUT_NAME;
	}

	private function getColor( $colorParam, $params, PPFrame $frame ) {
		$sourceParam = $colorParam . '-source';
		$defaultParam = $colorParam . '-default';

		$color = '';

		if ( isset( $params[$sourceParam] ) && !empty( $frame->getArgument( $params[$sourceParam] ) ) ) {
			$color = trim( $frame->getArgument( $params[$sourceParam] ) );
			$color = $this->sanitizeColor( $color );
		}

		if ( empty( $color ) && isset( $params[$defaultParam] ) ) {
			$color = trim( $params[$defaultParam] );
			$color = $this->sanitizeColor( $color );
		}

		return $color;
	}

	private function sanitizeColor( $color ) {
		$color = substr( $color, 0, 1 ) === '#' ? $color : '#' . $color;
		$color = ( $this->getParamsValidator()->validateColorValue( $color ) ) ? $color : '';
		return $color;
	}

	private function getParamsValidator() {
		if ( empty( $this->infoboxParamsValidator ) ) {
			$this->infoboxParamsValidator = new InfoboxParamsValidator();
		}

		return $this->infoboxParamsValidator;
	}
}
