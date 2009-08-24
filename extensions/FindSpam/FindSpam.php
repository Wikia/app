<?php
/**
 * FindSpam extension - a special page for finding recently added spam
 *
 * @file
 * @ingroup Extensions
 * @version 1.0
 * @author Tim Starling
 * @link http://www.mediawiki.org/wiki/Extension:Find_Spam Documentation
 */
if ( !defined( 'MEDIAWIKI' ) ) {
	die( "Not a valid entry point\n" );
}

// Extension credits that will show up on Special:Version
$wgExtensionCredits['specialpage'][] = array(
	'name' => 'FindSpam',
	'version' => '1.0',
	'author' => 'Tim Starling',
	'description' => 'Adds a special page that allows to find recently added spam.',
	'descriptionmsg' => 'findspam-desc',
	'url' => 'http://www.mediawiki.org/wiki/Extension:Find_Spam',
);

// New user right
$wgAvailableRights[] = 'findspam';
$wgGroupPermissions['sysop']['findspam'] = true;
$wgGroupPermissions['staff']['findspam'] = true;

// Set up the new special page
$dir = dirname(__FILE__) . '/';
$wgAutoloadClasses['FindSpamPage'] = $dir . 'FindSpam_body.php';
$wgExtensionMessagesFiles['FindSpam'] = $dir . 'FindSpam.i18n.php';
$wgExtensionAliasesFiles['FindSpam'] = $dir . 'FindSpam.alias.php';
$wgSpecialPages['FindSpam'] = 'FindSpamPage';
// Special page group for MW 1.13+
$wgSpecialPageGroups['FindSpam'] = 'spam';