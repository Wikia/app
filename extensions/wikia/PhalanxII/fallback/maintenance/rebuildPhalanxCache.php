<?php
/**
 * A maintenance script to rebuild Phalanx's cache. Rebuilding the cache
 * during regular HTTP requests has become too resource-consuming.
 *
 * @file extensions/wikia/Phalanx/maintenance/rebuildPhalanxCache.php
 * @author Michał Roszka (Mix) <michal@wikia-inc.com>
 */

// MediaWiki
ini_set( "include_path", dirname( __FILE__ ) . "/../../../../../maintenance/" );
require_once( "commandLine.inc" );

// Phalanx caches its blocks by the type and by the language. Let's
// get supported types and languages.
$aTypes     = array_keys( PhalanxFallback::$typeNames );
$aLanguages = array_keys( $wgPhalanxSupportedLanguages );

function getmicrotime() {
	list( $usec, $sec ) = explode( " ", microtime() );
	return ( (float)$usec + (float)$sec );
}

// Walk through all types...
foreach ( $aTypes as $iType ) {
	// ... and languages.
	foreach ( $aLanguages as $sLanguage ) {
		$time_start = getmicrotime();
		// Fill the cache with the current data from DB_MASTER.
		PhalanxFallback::getFromFilter( $iType, $sLanguage, true, true );
		if ( $iType == Phalanx::TYPE_USER ) {
			PhalanxFallback::getFromFilterShort( $iType, $sLanguage, true, true );
		}
		$time_end = getmicrotime();
		$time = $time_end - $time_start;
		echo "iType = " . PhalanxFallback::$typeNames[ $iType ] . " ( $iType ) , $sLanguage, " . sprintf( "%0.2f", $time ) . " sec \n";
	}
	// Touch.
	PhalanxFallback::setLastUpdate();
}

exit( 0 );
