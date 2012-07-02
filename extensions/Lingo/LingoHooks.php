<?php

/**
 * File holding the LingoHooks class
 *
 * @author Stephan Gambke
 * @file
 * @ingroup Lingo
 */
if ( !defined( 'LINGO_VERSION' ) ) {
	die( 'This file is part of the Lingo extension, it is not a valid entry point.' );
}

/**
 * The LingoHooks class.
 * 
 * It contains the hook handlers of the extension
 *
 * @ingroup Lingo
 */
class LingoHooks {

	/**
	 * Hooks into ParserAfterTidy.
	 * 
	 * @param Parser $parser
	 * @param String $text
	 * @return Boolean 
	 */
	static function parse( &$parser, &$text ) {

		global $wgexLingoUseNamespaces;

		$title = $parser->getTitle();

		// parse if
		if ( !isset( $parser->mDoubleUnderscores['noglossary'] ) && // __NOGLOSSARY__ not present and
			(
			!$title || // title not set or
			!isset( $wgexLingoUseNamespaces[$title->getNamespace()] ) || // namespace not explicitly forbidden or
			$wgexLingoUseNamespaces[$title->getNamespace()] // namespace explicitly allowed
			)
		) { 
			LingoParser::parse( $parser, $text );
		}

		return true;
	}

	/**
	 * Deferred setting of description in extension credits
	 *
	 * Setting of description in extension credits has to be deferred to the
	 * SpecialVersionExtensionTypes hook as it uses variable $wgexLingoPage (which
	 * might be set only after inclusion of the extension in LocalSettings) and
	 * function wfMsg not available before.
	 *
	 * @return Boolean Always true.
	 */
	static function setCredits() {

		global $wgExtensionCredits, $wgexLingoPage;
		$wgExtensionCredits['parserhook']['lingo']['description'] =
			wfMsg( 'lingo-desc', $wgexLingoPage ? $wgexLingoPage : wfMsgForContent( 'lingo-terminologypagename' ) );

		return true;
	}

}

