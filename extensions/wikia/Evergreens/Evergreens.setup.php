<?php
/**
 * Logging entry point for the Wikia Evergreens extension for Google Chrome
 *
 * Wikia Evergreens is a stale page cache detection and reporting tool.
 *
 * @author Michał ‘Mix’ Roszka <mix@wikia-inc.com>
 * @date Tuesday, 10 June 2014 (created)
 */

/**
 * Terminate if executed outside of MediaWiki.
 */
if( !defined( 'MEDIAWIKI' ) ) {
	exit( 1 );
}

/**
 * Extension credits.
 */
$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'Evergreens',
	'descriptionmsg' => 'evergreens-desc',
	'author' => 'Michał ‘Mix’ Roszka <mix@wikia-inc.com>',
	'license-name' => 'MIT',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/Evergreens'
);

/**
 * The actual extension class.
 */
$wgAutoloadClasses['EvergreensController'] = __DIR__ . '/EvergreensController.class.php';

/**
 * Internationalisation.
 */
$wgExtensionMessagesFiles['Evergreens'] = __DIR__ . '/Evergreens.i18n.php';
