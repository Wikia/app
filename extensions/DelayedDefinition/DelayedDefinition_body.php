<?php

class ExtDelayedDefinition {
	var $mCache, $mTransTable;
	var $mMarkerHead;
	var $mMarkerTail;
	var $mParser;

	// Resets state, called when parser clears state.
	function clearState() {
		$this->mCache = array();
		$this->mTransTable = array();

		$salt = dechex( mt_rand() );
		$this->mMarkerHead = "\x7fDELAY-DEF-" . $salt . "-";
		$this->mMarkerTail = "-DEF-DELAY\x7f";

		$this->mParser = null;

		return true;
	}

	// Initialize hooks and tags
	function __construct( &$parser ) {
		global $wgHooks;

		$parser->setHook( 'define', array( &$this, 'define' ) );
		$parser->setHook( 'display', array( &$this, 'display' ) );

		$wgHooks['ParserClearState'][] = array( &$this, 'clearState' );
		$wgHooks['ParserAfterTidy'][] = array( &$this, 'replaceMarkers' );

		$this->clearState();
	}

	/**
	 * Parses the <define> block into HTML
	 *
	 * THIS IS A GIANT, CRAPPY HACK!
	 * FIXME: This function makes a recursive call to Parser::parse.
	 *
	 * Currently (Mediawiki 1.16), there are no Parser hooks that allow this to work
	 * without the ugly hack, and Parser::recursiveTagParse only runs the
	 * Parser::internalParse branch of the parser engine.  In addition, tag extensions
	 * are limited to returning HTML, so partial parsing is not acceptable here.
	 *
	 * A reasonable fix here would seem to require multiple additions to the current Parser.
	 *
	 * Please note that since the hack being used here is outside the scope of intended
	 * use for Parser::parse, it is unclear if it will work correctly in all cases, and 
	 * future versions of Mediawiki may break this behavior.
	**/
	function parse( $text ) {
		global $wgParser;

		$opt =& $wgParser->getOptions();
		$orig = $opt->getIsSectionPreview();
		
		// Avoids problems associated with parsing a partial page.
		$opt->setIsSectionPreview( true );

		// Call parse while duplicating the current parameters and forcing
		// clearState to be false.
		$out = $wgParser->parse( $text, $wgParser->getTitle(), $opt,
			false, false, $wgParser->getRevisionId() )->getText();

		$opt->setIsSectionPreview( $orig );

		// Remove extraneous encoding created by the parser.
		$out = preg_replace( "/<!--.*-->/Us", "", $out );
		return trim( $out );
	}

	// Tag callback for <define>.
	function define( $input, $argv, &$parser ) {
		if ( !array_key_exists( 'name', $argv ) ) {
			// name argument is missing.
			return '<strong class="error">' . wfMsgForContent( "delaydef-error-no-name" ) . '</strong>';
		}

		$key = $this->findKey( $argv['name'] );
		if ( array_key_exists( $key, $this->mCache ) ) {
			// Attempt to redefine the same name twice.
			return '<strong class="error">' .
				wfMsgForContent( "delaydef-error-redef", $argv['name'] ) .
				'</strong>';
		}

		$this->mCache[$key] = $this->parse( $input );

		// Use a blank placeholder, otherwise MW may use consecutive
		// newlines to generate unintended paragraph breaks.
		return $this->mMarkerHead . "blank" . $this->mMarkerTail;
	}

	// Tag callback for <display>.
	function display( $input, $argv, &$parser ) {
		if ( !array_key_exists( 'name', $argv ) ) {
			// name argument is missing
			return '<strong class="error">' . wfMsgForContent( "delaydef-error-no-name" ) . '</strong>';
		} elseif ( $input !== null ) {
			/* if <display name="foo"> BAR </display> is used
			 * then treat this as both the definition of "foo"
			 * and as a display request.
			 */
			$out = $this->define( $input, $argv, $parser );
			if ( $out !== '' ) {
				// Passes errors to user.
				return $out;
			}
		}

		return $this->getMarker( $argv['name'] );
	}

	// Generate unique markers for DelayedDefinion, replaced by replaceMarkers
	// after page is fully parsed.
	function getMarker( $name ) {
		$key = $this->findKey( $name );

		return $this->mMarkerHead . $key . $this->mMarkerTail;
	}

	// Translate names into unique numeric keys.
	function findKey( $name ) {
		if ( !array_key_exists( $name, $this->mTransTable ) ) {
			$this->mTransTable[$name] = count( $this->mTransTable );
		}
		return $this->mTransTable[$name];
	}

	// Replace the unique markers with actual content.  
	// Called by the hook ParserAfterTidy.
	function replaceMarkers( &$parser, &$text ) {
		// Replace display markers with content.
		foreach ( $this->mCache as $key => $content ) {
			$marker = $this->mMarkerHead . $key . $this->mMarkerTail;
			$text = str_replace( $marker, $content, $text );
		}

		// Strip the blank marker.
		$marker = $this->mMarkerHead . "blank" . $this->mMarkerTail;
		$text = str_replace( $marker, "", $text );


		// On section preview, kill extra markers.  Assumed to be defined on the 
		// rest of the page.
		if ( $parser->getOptions()->getIsSectionPreview() ) {
			$regex = "/" . $this->mMarkerHead . "\d+" . $this->mMarkerTail . "/";
			$text = preg_replace( $regex, "", $text );

			return true;
		}

		// Find display markers with no matching define and replace them with
		// an error message.

		$regex = "/" . $this->mMarkerHead . "(\d+)" . $this->mMarkerTail . "/";
		$matches = array();

		preg_match_all( $regex, $text, $matches );
		$rev = array_flip( $this->mTransTable );

		foreach ( $matches[0] as $k => $v ) {
			$key = $matches[1][$k];
			$missing = '<strong class="error">' .
				wfMsgForContent( 'delaydef-error-missing-def', $rev[intval( $key )] ) .
				'</strong>';
			$text = str_replace( $v, $missing, $text );
		}

		return true;
	}
}
