<?php

# Loader for spam blacklist feature
# Include this from LocalSettings.php

if ( !defined( 'MEDIAWIKI' ) ) {
	exit;
}

$wgExtensionCredits[version_compare($wgVersion, '1.17alpha', '>=') ? 'antispam' : 'other'][] = array(
	'path'           => __FILE__,
	'name'           => 'SpamBlacklist',
	'author'         => array( 'Tim Starling', 'John Du Hart' ),
	'url'            => 'https://www.mediawiki.org/wiki/Extension:SpamBlacklist',
	'descriptionmsg' => 'spam-blacklist-desc',
);

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['SpamBlackList'] = $dir . 'SpamBlacklist.i18n.php';

/**
 * Array of settings for blacklist classes
 */
$wgBlacklistSettings = array(
	'spam' => array(
		'files' => array(),
	),
);

$wgHooks['EditFilterMerged'][] = 'SpamBlacklistHooks::filterMerged';
$wgHooks['APIEditBeforeSave'][] = 'SpamBlacklistHooks::filterAPIEditBeforeSave';
$wgHooks['EditFilter'][] = 'SpamBlacklistHooks::validate';
$wgHooks['ArticleSaveComplete'][] = 'SpamBlacklistHooks::articleSave';
$wgHooks['UserCanSendEmail'][] = 'SpamBlacklistHooks::userCanSendEmail';
$wgHooks['AbortNewAccount'][] = 'SpamBlacklistHooks::abortNewAccount';

$wgAutoloadClasses['BaseBlacklist'] = $dir . 'BaseBlacklist.php';
$wgAutoloadClasses['EmailBlacklist'] = $dir . 'EmailBlacklist.php';
$wgAutoloadClasses['SpamBlacklistHooks'] = $dir . 'SpamBlacklistHooks.php';
$wgAutoloadClasses['SpamBlacklist'] = $dir . 'SpamBlacklist_body.php';
$wgAutoloadClasses['SpamRegexBatch'] = $dir . 'SpamRegexBatch.php';
