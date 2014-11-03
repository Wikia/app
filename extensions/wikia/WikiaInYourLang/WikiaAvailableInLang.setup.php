<?php
/**
 * Displays a notification if a wikia is available
 * in a user's native language.
 * The check is based on Geo cookie and a browser's language.
 *
 * @package Wikia\extensions\WikiaInYourLang
 *
 * @version 0.1
 *
 * @author Adam Karminski <adamk@wikia-inc.com>
 *
 * @see https://github.com/Wikia/app/tree/dev/extensions/wikia/WikiaInYourLang/
 */


// Terminate the script when called out of MediaWiki context.
if ( !defined( 'MEDIAWIKI' ) ) {
	echo  'Invalid entry point. '
		. 'This code is a MediaWiki extension and is not meant to be executed standalone. '
		. 'Try vising the main page: /index.php or running a different script.';
	exit( 1 );
}

$dir = __DIR__;

/**
 * @global Array The list of extension credits.
 * @see http://www.mediawiki.org/wiki/Manual:$wgExtensionCredits
 */
$wgExtensionCredits['other'][] = array(
	'path'              => __FILE__,
	'name'              => 'WikiaInYourLang',
	'descriptionmsg'    => 'wikia-in-your-lang-description',
	'version'           => '0.1',
	'author'            => array(
		'Adam Karminski <adamk@wikia-inc.com>'
	),
	'url'               => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/WikiaInYourLang/',
);

$wgExtensionMessagesFiles[ 'WikiaInYourLang' ] = $dir . '/WikiaInYourLang.i18n.php';
