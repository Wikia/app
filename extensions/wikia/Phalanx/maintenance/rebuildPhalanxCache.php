<?php
/**
 * A maintenance script to rebuild Phalanx's cache. Rebuilding the cache
 * during regular HTTP requests has become too resource-consuming.
 * 
 * @file extensions/wikia/Phalanx/maintenance/rebuildPhalanxCache.php
 * @author Michał Roszka (Mix) <michal@wikia-inc.com>
 */

// MediaWiki
include __DIR__ . '/../../../../maintenance/commandLine.inc';

// Phalanx caches its blocks by the type and by the language. Let's
// get supported types and languages.
$aTypes     = array_keys( Phalanx::$typeNames );
$aLanguages = array_keys( $wgPhalanxSupportedLanguages );

// Walk through all types...
foreach ( $aTypes as $iType ) {
	// ... and languages.
	foreach ( $aLanguages as $sLanguage ) {
		// Fill the cache with the current data from DB_MASTER.
		Phalanx::getFromFilter( $iType, $sLanguage, true, true );
	}
	// Touch.
	Phalanx::setLastUpdate();
}

exit( 0 );
