<?php

/**
 * Adapted form of the MultiLang extension from Arnomane
 *
 * @addtogroup Extensions
 * @author Rob Church <robchur@gmail.com>
 */
 
if( defined( 'MEDIAWIKI' ) ) {

	$wgAutoloadClasses['Multilang'] = dirname( __FILE__ ) . '/Multilang.class.php';
	$wgExtensionFunctions[] = 'efMultilang';
	
	function efMultilang() {
		global $wgMultilang, $wgParser, $wgHooks;
		# Use of a StubObject means we can have a single, persistent instance
		# that will remember what's going on between parse runs, and we can
		# defer initialisation until we need to call a hook function
		$wgMultilang = new StubObject( 'wgMultilang', 'Multilang' );
		$wgParser->setHook( 'language', array( &$wgMultilang, 'languageBlock' ) );
		$wgParser->setHook( 'multilang', array( &$wgMultilang, 'outputBlock' ) );
		$wgHooks['ParserClearState'][] = array( &$wgMultilang, 'clearState' );
	}

}

