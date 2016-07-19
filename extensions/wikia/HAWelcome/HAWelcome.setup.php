<?php
/**
 * Sends a welcome message to users after their first edits.
 *
 * @package Wikia\extensions\HAWelcome
 *
 * @version 1010
 *
 * @author Krzysztof 'Eloy' Krzyżaniak <eloy@wikia-inc.com>
 * @author Maciej 'Marooned' Błaszkowski <marooned@wikia-inc.com>
 * @author Michał 'Mix' Roszka <mix@wikia-inc.com>
 *
 * @see https://github.com/Wikia/app/tree/dev/extensions/wikia/HAWelcome/
 */


// Terminate the script when called out of MediaWiki context.
if ( !defined( 'MEDIAWIKI' ) ) {
	echo  'Invalid entry point. '
		. 'This code is a MediaWiki extension and is not meant to be executed standalone. '
		. 'Try vising the main page: /index.php or running a different script.';
	exit( 1 );
}


$dir = dirname( __FILE__ ) . '/';

/**
 * @global Array The list of extension credits.
 * @see http://www.mediawiki.org/wiki/Manual:$wgExtensionCredits
 */
$wgExtensionCredits['other'][] = array(
	'path'              => __FILE__,
	'name'              => 'HAWelcome',
	'descriptionmsg'    => 'welcome-description',
	'version'           => 1009,
	'author'            => array(
		"Krzysztof 'Eloy' Krzyżaniak <eloy@wikia-inc.com>",
		"Maciej 'Marooned' Błaszkowski <marooned@wikia-inc.com>",
		"Michał 'Mix' Roszka <mix@wikia-inc.com>"
	),
	'url'               => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/HAWelcome/'
);

$wgExtensionMessagesFiles[ 'HAWelcome' ] = $dir . '/HAWelcome.i18n.php';

$wgAutoloadClasses['HAWelcomeHooks'] =  $dir . 'HAWelcomeHooks.php' ;
$wgAutoloadClasses['HAWelcomeTask'] =  $dir . 'HAWelcomeTask.php' ;
$wgAutoloadClasses['HAWelcomeTaskHooks'] =  $dir . 'HAWelcomeTaskHooks.php' ;
$wgAutoloadClasses['HAWelcomeTaskHookDispatcher'] =  $dir . 'HAWelcomeTaskHookDispatcher.php' ;


/**
 * @global Array The list of hooks.
 * @see http://www.mediawiki.org/wiki/Manual:$wgHooks
 * @see http://www.mediawiki.org/wiki/Manual:Hooks/ArticleSaveComplete
 */
$wgHooks['ArticleSaveComplete'][] = 'HAWelcomeTaskHooks::onArticleSaveComplete';
$wgHooks['UserRights'][] = 'HAWelcomeHooks::onUserRightsChange';

/**
 * @type String Command name for the job aka type of the job.
 * @see http://www.mediawiki.org/wiki/Manual:RunJobs.php
 */
define( 'HAWELCOME_JOB_IDENTIFIER', 'HAWelcome' );
