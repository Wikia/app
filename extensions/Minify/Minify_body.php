<?php

class Minify {
	var $mText;
	var $mType;

	// Initialize
	function Minify( $text ) {
		global $wgRequest;

		$this->mType = $wgRequest->getVal( 'ctype' );
		if ( $this->mType == '' ) {
			$this->mType = $wgRequest->getVal( 'gen' );
		}
		$this->mText = $text;
	}

	// Perform operations
	function run() {
		if ( strlen( $this->mText ) == 0 ) { return; }

		switch( $this->mType ) {

		case 'text/css':
		case 'css':
			$this->runCSS();
			break;

		case 'text/javascript':
		case 'js':
			$this->runJS();
			break;
		}

		return $this->mText;
	}

	/*
	 * Port of the Java based YUI CSS compressor written by Julien Lecomte <jlecomte@yahoo-inc.com>
	 * Code under the BSD license
	 * http://developer.yahoo.com/yui/compressor/
	 *
	 * The YUI compressor was in turn a port of cssmin by Isaac Schlueter.
	 */
	function runCSS() {
		$text = $this->mText;

		// Remove comment blocks, subject to a few special cases.

		$startIndex = 0;
		$iemac = false;
		$preserve = false;
		while ( ( $startIndex = strpos( $text, "/*", $startIndex ) ) !== false ) {
			$preserve = ( strlen( $text ) > $startIndex + 2 );
			if ( $preserve ) {
				$preserve = ( $text[$startIndex + 2] == '!' );
			}
			$endIndex = strpos( $text, "*/", $startIndex + 2 );
			if ( $endIndex === false ) {
				if ( !$preserve ) {
					$text = substr_replace( $text, "", $startIndex, strlen( $text ) );
					break;
				}
			} else {
				if ( $text[$endIndex - 1] == "\\" ) {
					// Looks for IE Mac style conditional CSS.
					// If found, leaves the conditional "comment" in place

					$startIndex = $endIndex + 2;
					$iemac = true;
				} elseif ( $iemac ) {
					$startIndex = $endIndex + 2;
					$iemac = false;
				} elseif ( !$preserve ) {
					$text = substr_replace( $text, "", $startIndex, $endIndex + 2 - $startIndex );
				} else {
					$startIndex = $endIndex + 2;
				}
			}
		}

		// Normalize all consecutive whitespace to single spaces.
		$text = preg_replace( "/\\s+/u", " ", $text );

		// Make a pseudo class for the Box Model Hack
		$text = preg_replace( "/\"\\\\\"}\\\\\"\"/", "___PSEUDOCLASSBMH___", $text );

		// Munge the special case of psuedo-class colons in CSS identifier string.
		// e.g. p :link { ... } != p:link {...}
		$matches = array();
		preg_match_all( "/(^|\\})(([^\\{:])+:)+([^\\{]*\\{)/", $text, $matches );
		foreach ( $matches[0] as $m ) {
			$m2 = str_replace( ":", "___PSEUDOCLASSCOLON___", $m );
			$text = str_replace( $m, $m2, $text );
		}

		// Remove spaces before identifier that don't require them,
		// and restored the munged colons.
		$text = preg_replace( "/\\s+([!{};:>+\\(\\)\\],])/", "\\1", $text );
		$text = str_replace( "___PSEUDOCLASSCOLON___", ":", $text );

		// Remove spaces that follow things which don't require them.
		$text = preg_replace( "/([!{}:;>+\\(\\[,])\\s+/", "\\1", $text );

		// Add semicolons at end of statements where missing.
		$text = preg_replace( "/([^;\\}])}/", "\\1;}", $text );

		// Replace "0px" with "0", etc.
		$text = preg_replace( "/([\\s:])(0)(px|em|%|in|cm|mm|pc|pt|ex)/", "\\1\\2", $text );

		// Collapse redundant zeroes.
		$text = str_replace( ":0 0 0 0;", ":0;", $text );
		$text = str_replace( ":0 0 0;", ":0;", $text );
		$text = str_replace( ":0 0;", ":0;", $text );

		// Restore special case of background-position.
		$text = str_replace( "background-position:0;", "background-position:0 0;", $text );

		// Replace 0.### with .### where appropriate.
		$text = preg_replace( "/(:|\\s)0+\\.(\\d+)/", "\\1.\\2", $text );

		// Rewrite "rgb( x, y, z )" expressions in "#ABCDEF" form.
		$matches = array();
		preg_match_all( "/rgb\\s*\\(\\s*([0-9,\\s]+)\\s*\\)/", $text, $matches );
		foreach ( $matches[0] as $k => $m ) {
			$hex = "#";
			$rgb = explode( "," , $matches[1][$k] );
			foreach ( $rgb as $value ) {
				$value = intval( $value );
				if ( $value < 16 ) {
					$hex .= "0";
				}
				$hex .= dechex( $value );
			}
			$text = str_replace( $m, $hex, $text );
		}

		// Collapse #AABBCC into #ABC.  Prefix codes avoid cases where this format is not okay.
		$text = preg_replace( "/([^\"'=\\s])(\\s*)#([0-9a-fA-F])\\3([0-9a-fA-F])\\4([0-9a-fA-F])\\5/i",
				"\\1\\2#\\3\\4\\5", $text );

		// Remove empty rules.
		$text = preg_replace( "/[^\\}]+\\{;\\}/", "", $text );

		// Restore the Box Model Hack
		$text = str_replace( "___PSEUDOCLASSBMH___", "\"\\\\\"}\\\\\"\"", $text );

		// Collapse redundant semicolons.
		$text = preg_replace( "/;;+/", ";", $text );

		// Trim whitespace from ends of final text.
		$text = trim( $text );

		$this->mText = $text;
	}

	/*
	 * Calls Ryan Grove's PHP port of
	 * Douglas Crockford's JSMin, see jsmin.php for details
	 */
	function runJS() {
		try {
			$this->mText = JSMin::minify( $this->mText );
		} catch ( JSMinException $e ) {
			// Do nothing.  Text will be passed uncompressed.
		}
	}
}
