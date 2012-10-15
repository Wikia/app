<?php
/**
 * EmailCapture extension
 *
 * @file
 * @ingroup Extensions
 * @version 0.3.0
 * @author Trevor Parscal <trevor@wikimedia.org>
 * @license GPL v2 or later
 * @link http://www.mediawiki.org/wiki/Extension:EmailCapture Documentation
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( "This is not a valid entry point to MediaWiki.\n" );
}

/* Configuration */
$wgEmailCaptureSendAutoResponse = true;
$wgEmailCaptureAutoResponse = array(
	'from' => $wgPasswordSender,
	'from-name' => $wgSitename,
	'subject-msg' => 'emailcapture-response-subject',
	'body-msg' => 'emailcapture-response-body',
	'reply-to' => null,
	'content-type' => null,
);

// Extension credits that will show up on Special:Version
$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'EmailCapture',
	'author' => 'Trevor Parscal',
	'version' => '0.3.0',
	'url' => 'https://www.mediawiki.org/wiki/Extension:EmailCapture',
	'descriptionmsg' => 'emailcapture-desc',
);

/* Setup */
$dir = dirname( __FILE__ ) . '/';
$wgExtensionMessagesFiles['EmailCapture'] = $dir . 'EmailCapture.i18n.php';
$wgExtensionMessagesFiles['EmailCaptureAlias'] = $dir . 'EmailCapture.alias.php';
// API
$wgAutoloadClasses['ApiEmailCapture'] = $dir . 'api/ApiEmailCapture.php';
$wgAPIModules['emailcapture'] = 'ApiEmailCapture';
// Schema
$wgAutoloadClasses['EmailCaptureHooks'] = $dir . 'EmailCaptureHooks.php';
$wgHooks['LoadExtensionSchemaUpdates'][] = 'EmailCaptureHooks::loadExtensionSchemaUpdates';
$wgHooks['ParserTestTables'][] = 'EmailCaptureHooks::parserTestTables';
// Special page
$wgAutoloadClasses['SpecialEmailCapture'] = $dir . 'SpecialEmailCapture.php';
$wgSpecialPages['EmailCapture'] = 'SpecialEmailCapture';