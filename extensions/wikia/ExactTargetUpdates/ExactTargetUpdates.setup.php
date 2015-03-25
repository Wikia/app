<?php
/**
 * Sends push updates to ExactTarget.com on various hooks.
 * The goal is to keep the data in ExactTarget mailing tool fresh.
 *
 * @package Wikia\extensions\ExactTargetUpdates
 *
 * @version 0.1
 *
 * @author Kamil Koterba <kamil@wikia-inc.com>
 * @author Adam Karmiński <adamk@wikia-inc.com>
 *
 * @see https://github.com/Wikia/app/tree/dev/extensions/wikia/ExactTargetUpdates/
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
	'name'              => 'ExactTargetUpdates',
	'descriptionmsg'    => 'exacttarget-updates-description',
	'version'           => '0.1',
	'author'            => array(
		'Kamil Koterba <kamil@wikia-inc.com>',
		'Adam Karminski <adamk@wikia-inc.com>',
	),
	'url'               => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/ExactTargetUpdates/'
);

$wgExtensionMessagesFiles[ 'ExactTargetUpdates' ] = $dir . '/ExactTargetUpdates.i18n.php';

/**
 * Load classes
 */

/* Add hooks classes */
$wgAutoloadClasses['Wikia\ExactTarget\ExactTargetSetupHooks'] =  $dir . '/hooks/ExactTargetSetup.hooks.php' ;
$wgAutoloadClasses['Wikia\ExactTarget\ExactTargetUserHooks'] =  $dir . '/hooks/ExactTargetUser.hooks.php' ;
$wgAutoloadClasses['Wikia\ExactTarget\ExactTargetUserHooksHelper'] =  $dir . '/hooks/ExactTargetUserHooksHelper.php' ;
$wgAutoloadClasses['Wikia\ExactTarget\ExactTargetWikiHooks'] =  $dir . '/hooks/ExactTargetWiki.hooks.php' ;
$wgAutoloadClasses['Wikia\ExactTarget\ExactTargetWikiHooksHelper'] =  $dir . '/hooks/ExactTargetWikiHooksHelper.php' ;
/* Add base task class */
$wgAutoloadClasses['Wikia\ExactTarget\ExactTargetTask'] =  $dir . '/tasks/ExactTargetTask.php' ;
/* Add user-related tasks classes */
$wgAutoloadClasses['Wikia\ExactTarget\ExactTargetUserDataVerificationTask'] =  $dir . '/tasks/ExactTargetUserDataVerificationTask.php';
$wgAutoloadClasses['Wikia\ExactTarget\ExactTargetUserTaskHelper'] =  $dir . '/tasks/ExactTargetUserTaskHelper.php' ;
$wgAutoloadClasses['Wikia\ExactTarget\ExactTargetCreateUserTask'] =  $dir . '/tasks/ExactTargetCreateUserTask.php' ;
$wgAutoloadClasses['Wikia\ExactTarget\ExactTargetRetrieveUserHelper'] =  $dir . '/tasks/ExactTargetRetrieveUserHelper.php' ;
$wgAutoloadClasses['Wikia\ExactTarget\ExactTargetUpdateUserTask'] =  $dir . '/tasks/ExactTargetUpdateUserTask.php' ;
$wgAutoloadClasses['Wikia\ExactTarget\ExactTargetDeleteUserTask'] =  $dir . '/tasks/ExactTargetDeleteUserTask.php';
/* Add wiki-related tasks classes */
$wgAutoloadClasses['Wikia\ExactTarget\ExactTargetWikiTaskHelper'] =  $dir . '/tasks/ExactTargetWikiTaskHelper.php' ;
$wgAutoloadClasses['Wikia\ExactTarget\ExactTargetCreateWikiTask'] =  $dir . '/tasks/ExactTargetCreateWikiTask.php' ;
$wgAutoloadClasses['Wikia\ExactTarget\ExactTargetUpdateWikiTask'] =  $dir . '/tasks/ExactTargetUpdateWikiTask.php' ;
$wgAutoloadClasses['Wikia\ExactTarget\ExactTargetUpdateCityCatMappingTask'] =  $dir . '/tasks/ExactTargetUpdateCityCatMappingTask.php' ;
$wgAutoloadClasses['Wikia\ExactTarget\ExactTargetDeleteWikiTask'] = $dir . '/tasks/ExactTargetDeleteWikiTask.php' ;

/* Add API classes */
$wgAutoloadClasses['Wikia\ExactTarget\ExactTargetApi'] =  $dir . '/api/ExactTargetApi.php' ;
$wgAutoloadClasses['Wikia\ExactTarget\ExactTargetApiDataExtension'] =  $dir . '/api/ExactTargetApiDataExtension.php' ;
$wgAutoloadClasses['Wikia\ExactTarget\ExactTargetApiSubscriber'] =  $dir . '/api/ExactTargetApiSubscriber.php' ;
$wgAutoloadClasses['Wikia\ExactTarget\ExactTargetApiHelper'] =  $dir . '/api/ExactTargetApiHelper.php' ;
$wgAutoloadClasses['ExactTargetSoapClient'] =  $dir . '/lib/exacttarget_soap_client.php' ;

/**
 * Registering hooks
 */
$wgExtensionFunctions[] = 'Wikia\ExactTarget\ExactTargetSetupHooks::setupHooks';
