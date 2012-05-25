<?php
/**
 * @file PiggyQuick.php
 * @brief The PiggyQuick MediaWiki extension setup.
 * @author Michał Roszka (Mix) <michal@wikia-inc.com>
 * @date Friday, 25 May 2012 (created)
 */

// Protect the code of the extension to be executed via a direct request.
if ( !defined( 'MEDIAWIKI' ) ) {
	echo "This is a MediaWiki extension and cannot be used standalone.\n";
	exit( 1 );
}

/**
 * @var array $wgExtensionCredits
 * @brief Basic human language information about the extension.
 * @see http://www.mediawiki.org/wiki/Manual:$wgExtensionCredits
 */
$wgExtensionCredits['other'][] = array(
	'path'			=> __FILE__,
	'name'			=> 'PiggyQuick',
	'description'		=> 'Piggyback on steroids. Appears on user profile pages.',
	'descriptionmsg'	=> 'piggyquick-desc',
	'version'		=> '1.0',
	'author'		=> array( '[http://community.wikia.com/wiki/User:Mroszka Michał Roszka (Mix)]' ),
	'url'			=> 'http://trac.wikia-code.com/browser/wikia/trunk/extensions/wikia/PiggyQuick/',
);

/**
 * @var array $wgExtensionMessagesFiles
 * @brief Mapping the extension name to the filename where i18n could be found.
 * @see http://www.mediawiki.org/wiki/Manual:$wgExtensionMessagesFiles
 */
$wgExtensionMessagesFiles['PiggyQuick'] = __DIR__ . '/PiggyQuick.i18n.php';
