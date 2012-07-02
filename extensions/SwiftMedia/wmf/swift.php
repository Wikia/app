<?php
/**
 * Helper functions for Swift related image thumbnail purging.
 * The functions here should only be called after MediaWiki setup.
 *
 * The SwiftCloudFiles extensions must be installed.
 * $wmfSwiftConfig must reside in PrivateSettings.php. It should also
 * be extracted in CommonSettings.php to set any swift backend settings.
 *
 * This file belongs under wmf-config/ and should be included by CommonSettings.php.
 */

/**
 * Handler for the LocalFilePurgeThumbnails hook.
 * To avoid excess inclusion of cloudfiles.php, a hook handler can be added
 * to CommonSettings.php which includes this file and calls this function.
 *
 * @param $file File
 * @param $archiveName string|false
 * @return true
 */
function wmfPurgeBackendThumbCache( File $file, $archiveName ) {
	global $site, $lang; // CommonSettings.php

	// Get thumbnail dir relative to thumb zone
	if ( $archiveName !== false ) {
		$thumbRel = $file->getArchiveThumbRel( $archiveName ); // old version
	} else {
		$thumbRel = $file->getRel(); // current version
	}

	// Get the container for the thumb zone and delete the objects
	$container = wmfGetSwiftThumbContainer( $site, $lang, "$thumbRel/" );
	if ( $container ) { // sanity
		$files = $container->list_objects( 0, NULL, "$thumbRel/" );
		foreach ( $files as $file ) {
			try {
				$container->delete_object( $file );
			} catch ( NoSuchObjectException $e ) { // probably a race condition
				wfDebugLog( 'swiftThumb', "Could not delete `{$file}`; object does not exist." );
			}
		}
	}

	return true;
}

/**
 * Get the Swift thumbnail container for this wiki.
 *
 * @param $site string
 * @param $lang string
 * @param $relPath string Path relative to container
 * @return CF_Container|null
 */
function wmfGetSwiftThumbContainer( $site, $lang, $relPath ) {
	global $wmfSwiftConfig; // from PrivateSettings.php

	$auth = new CF_Authentication(
		$wmfSwiftConfig['user'],
		$wmfSwiftConfig['key'],
		NULL,
		$wmfSwiftConfig['authUrl']
	);

	try {
		$auth->authenticate();
	} catch ( Exception $e ) {
		wfDebugLog( 'swiftThumb', "Could not establish a connection to Swift." );
		return null;
	}

	$conn = new CF_Connection( $auth );

	$wikiId = "{$site}-{$lang}";

	// Get the full swift container name, including any shard suffix
	$name = "{$wikiId}-local-thumb";
	if ( in_array( $wikiId, array( 'wikipedia-commons', 'wikipedia-en' ) ) ) {
		// Code stolen from FileBackend::getContainerShard()
		if ( preg_match( "!^(?:[^/]{2,}/)*[0-9a-f]/(?P<shard>[0-9a-f]{2})(?:/|$)!", $relPath, $m ) ) {
			$name .= '.' . $m['shard'];
		} else {
			throw new MWException( "Can't determine shard of path '$relPath' for '$wikiId'." );
		}
	}

	try {
		$container = $conn->get_container( $name );
	} catch ( NoSuchContainerException $e ) { // container not created yet
		$container = null;
		wfDebugLog( 'swiftThumb', "Could not access `{$name}`; container does not exist." );
	}

	return $container;
}
