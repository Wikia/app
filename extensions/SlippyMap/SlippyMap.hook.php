<?php
/**
 * Hooks for SlippyMap extension
 *
 * @file
 * @ingroup Extensions
 */

class SlippyMapHook {

	/**
	 * Each map we render gets a unique ID. Required to avoid
	 * JavaScript namespace collisions.
	 *
	 * @var int
	 */
	var $mId;

	/**
	 * Property: SlippyMapMarkerList
	 * Evil hack as documented at
	 * http://www.mediawiki.org/wiki/Manual:Tag_extensions#How_can_I_avoid_modification_of_my_extension.27s_HTML_output.3F
	 * This is here so that random <p> and <pre> tags aren't added to the inline JavaScript output
	 */
	var $mParserMarkers = array();

	public function __construct() {
		global $wgParser, $wgHooks, $wgOut, $wgScriptPath, $wgStyleVersion;
		global $wgSlippyMapJs;

		// Load i18n
		self::loadMessages();

		// Initialize unique map id
		$this->mId = 0;

		// Hook for adding JS variables to <head>
		$wgHooks['MakeGlobalVariablesScript'][] = array( &$this, 'jsVariables' );

		// Add JavaScript files to <head>, starting with OpenLayers so that it is available in SlippyMap.js
		$wgOut->addScriptFile( $wgScriptPath . '/extensions/SlippyMap/OpenLayers/public/OpenLayers.js?' . $wgStyleVersion );
		if ( method_exists( $wgOut, 'addScriptClass' ) ) {
			$wgOut->addScriptClass( 'SlippyMap' );
		} else {
			$wgOut->addScriptFile( $wgScriptPath . '/extensions/SlippyMap/js/' . $wgSlippyMapJs . '?' . $wgStyleVersion );
		}

		// Add our CSS to <head>
		$wgOut->addExtensionStyle( $wgScriptPath . '/extensions/SlippyMap/SlippyMap.css?' . $wgStyleVersion );

		// Expand our maps after tidy has run
		$wgHooks['ParserAfterTidy'][] = array( &$this, 'afterTidy' );

		// Register the hook with the parser
		$wgParser->setHook( 'slippymap', array( &$this, 'render' ) );

		// Continue
		return true;
	}

	public function render( $input, $args, $parser ) {
		// Create SlippyMap
		$slippyMap = new SlippyMap( $parser );

		// Hack to ease testing for invalid/valid paramater values
		// when we're running parsertests.
		$return_dummy_map = false;
		if ( isset( $args['dummy'] ) && class_exists("ParserTest") ) {
			$return_dummy_map = true;
		}
		unset( $args['dummy'] );

		// Configure slippyMap
		$had_errors = ! $slippyMap->extractOptions( $input, $args );

		// Render & return output
		if ( $had_errors ) {
			return $slippyMap->renderErrors();
		} else {
			if ( $return_dummy_map ) {
				return "A dummy map";
			} else {
				$marker = $this->stashMarker( $slippyMap->render( $this->mId ) );
				$this->mId += 1;
				return $marker;
			}
		}
	}

	/**
	 * Hook to add JS variables to <head>
	 */
	public function jsVariables( $vars ) {
		global $wgContLang, $wgSlippyMapAutoLoadMaps;

		$vars['wgSlippyMapCode'] = wfMsg( 'slippymap_code' );
		$vars['wgSlippyMapButtonCode'] = wfMsg( 'slippymap_button_code' );
		$vars['wgSlippyMapResetview'] = wfMsg( 'slippymap_resetview' );
		$vars['wgSlippyMapLanguageCode'] = $wgContLang->getCode();
		$vars['wgSlippyMapSlippyByDefault'] = $wgSlippyMapAutoLoadMaps;

		return true;
	}

	private function stashMarker( $text ) {
		$pMarker = "SlippyMap-marker{$this->mId}-SlippyMap";
		$this->mParserMarkers[$this->mId] = $text;
		return $pMarker;
	}

	public function afterTidy( &$parser, &$text ) {
		$keys = array();
		$marker_count = count( $this->mParserMarkers );

		for ($i = 0; $i < $marker_count; $i++) {
			$keys[] = 'SlippyMap-marker' . $i . '-SlippyMap';
		}

		$text = str_replace( $keys, $this->mParserMarkers, $text );

	  	return true;
	}

	private static function loadMessages() {
		wfProfileIn( __METHOD__ );
		wfLoadExtensionMessages( 'SlippyMap' );
		wfProfileOut( __METHOD__ );
	}
}
