<?php

class Scribunto_LuaTextLibrary extends Scribunto_LuaLibraryBase {
	function register() {
		global $wgUrlProtocols;

		$lib = array(
			'unstrip' => array( $this, 'textUnstrip' ),
			'unstripNoWiki' => array( $this, 'textUnstripNoWiki' ),
			'killMarkers' => array( $this, 'killMarkers' ),
			'getEntityTable' => array( $this, 'getEntityTable' ),
		);
		$opts = array(
			'comma' => wfMessage( 'comma-separator' )->inContentLanguage()->text(),
			'and' => wfMessage( 'and' )->inContentLanguage()->text() .
				wfMessage( 'word-separator' )->inContentLanguage()->text(),
			'ellipsis' => wfMessage( 'ellipsis' )->inContentLanguage()->text(),
			'nowiki_protocols' => array(),
		);

		foreach ( $wgUrlProtocols as $prot ) {
			if ( substr( $prot, -1 ) === ':' ) {
				// To convert the protocol into a case-insensitive Lua pattern,
				// we need to replace letters with a character class like [Xx]
				// and insert a '%' before various punctuation.
				$prot = preg_replace_callback( '/([a-zA-Z])|([()^$%.\[\]*+?-])/', function ( $m ) {
					if ( $m[1] ) {
						return '[' . strtoupper( $m[1] ) . strtolower( $m[1] ) . ']';
					} else {
						return '%' . $m[2];
					}
				}, substr( $prot, 0, -1 ) );
				$opts['nowiki_protocols']["($prot):"] = '%1&#58;';
			}
		}

		$this->getEngine()->registerInterface( 'mw.text.lua', $lib, $opts );
	}

	function textUnstrip( $s ) {
		$this->checkType( 'unstrip', 1, $s, 'string' );
		$stripState = $this->getParser()->mStripState;
		return array( $stripState->killMarkers( $stripState->unstripNoWiki( $s ) ) );
	}

	function textUnstripNoWiki( $s ) {
		$this->checkType( 'unstripNoWiki', 1, $s, 'string' );
		return array( $this->getParser()->mStripState->unstripNoWiki( $s ) );
	}

	function killMarkers( $s ) {
		$this->checkType( 'killMarkers', 1, $s, 'string' );
		return array( $this->getParser()->mStripState->killMarkers( $s ) );
	}

	function getEntityTable() {
		$flags = ENT_QUOTES;
		// PHP 5.3 compat
		if ( defined( "ENT_HTML5" ) ) {
			$flags |= constant( "ENT_HTML5" );
		}
		$table = array_flip( get_html_translation_table( HTML_ENTITIES, $flags, "UTF-8" ) );
		return array( $table );
	}
}
