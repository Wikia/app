<?php
// The messages are in modules/ve-mw/i18n and modules/ve-wmf/i18n
$messages = array();
$GLOBALS['wgHooks']['LocalisationCacheRecache'][] = function ( $cache, $code, &$cachedData ) {
	global $wgMessagesDirs;
	$codeSequence = array_merge( array( $code ), $cachedData['fallbackSequence'] );
	foreach ( (array)$wgMessagesDirs['VisualEditor'] as $dir ) {
		foreach ( $codeSequence as $csCode ) {
			$fileName = "$dir/$csCode.json";
			if ( !is_readable( $fileName ) ) {
				continue;
			}
			$data = FormatJson::decode( file_get_contents( $fileName ), true );
			foreach ( $data as $key => $unused ) {
				if ( $key === '' || $key[0] === '@' ) {
					unset( $data[$key] );
				}
			}
			$cachedData['messages'] = array_merge( $data, $cachedData['messages'] );
			$cachedData['deps'][] = new FileDependency( $fileName );
		}
	}
	return true;
};
