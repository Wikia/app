<?php

/**
 * An extension that adds an upload blacklist functionality
 *
 * @file
 * @ingroup Extensions
 */

if( !defined( 'MEDIAWIKI' ) )
	die();

$wgExtensionCredits['other'][] = array(
	'path'           => __FILE__,
	'name'           => 'UploadBlacklist',
	'descriptionmsg' => 'uploadblacklist-desc',
	'author'         => 'Brion Vibber',
	'url'            => 'https://www.mediawiki.org/wiki/Extension:UploadBlacklist',
);

$wgExtensionMessagesFiles['UploadBlacklist'] = dirname( __FILE__ ) . '/UploadBlacklist.i18n.php';

$ubUploadBlacklist = array();
$wgHooks['UploadVerification'][] = 'ubVerifyHash';

/**
 * Callback for UploadVerification hook; calculates the file's
 * MD5 hash and checks it against a list of blacklisted files.
 * If it matches, the upload will be denied.
 *
 * @param string $saveName Destination filename
 * @param string $tempName Filesystem path to temporary upload file
 * @param string $error Set to HTML message if failure
 * @return bool true if passes this check, false if blocked
 */
function ubVerifyHash( $saveName, $tempName, &$error ) {
	$error = '';

	wfSuppressWarnings();
	$hash = sha1_file( $tempName );
	wfRestoreWarnings();

	if( $hash === false ) {
		$error = "Failed to calculate file hash; may be missing or damaged.";
		$error .= " Filename: " . htmlspecialchars( $tempName );
		ubLog( 'ERROR', $hash, $saveName, $tempName );
		return false;
	}

	global $ubUploadBlacklist;
	if( in_array( $hash, $ubUploadBlacklist ) ) {
		$error = "File appears to be corrupt.";
		ubLog( 'HIT', $hash, $saveName, $tempName );
		return false;
	} else {
		ubLog( 'MISS', $hash, $saveName, $tempName );
		return true;
	}
}

/**
 * Set $wgDebugLogGroups['UploadBlacklist'] to direct logging to a particular
 * file instead of the debug log.
 *
 * @param string $action
 * @param string $hash
 * @param string $saveName
 * @param string $tempName
 * @access private
 */
function ubLog( $action, $hash, $saveName, $tempName ) {
	global $wgUser;
	$user = $wgUser->getName();
	$ip = wfGetIP();
	$ts = wfTimestamp( TS_DB );
	wfDebugLog( 'UploadBlacklist', "$ts $action [$hash] name:$saveName file:$tempName user:$user ip:$ip" );
}
