<?php
/**
 * Sends push updates to ExactTarget.com on various hooks
 * Aim is to keep data in ExactTarget mailing tool fresh
 *
 * @package Wikia\extensions\ExactTargetUpdates
 *
 * @version 0.1
 *
 * @author Kamil Koterba <kamil@wikia-inc.com>
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
$wgAutoloadClasses['ExactTargetSetupHooks'] =  $dir . '/hooks/ExactTargetSetup.hooks.php' ;
$wgAutoloadClasses['ExactTargetUserHooks'] =  $dir . '/hooks/ExactTargetUser.hooks.php' ;
$wgAutoloadClasses['ExactTargetUserHooksHelper'] =  $dir . '/hooks/ExactTargetUserHooksHelper.php' ;
/* Add tasks classes */
$wgAutoloadClasses['Wikia\ExactTarget\Tasks\ExactTargetUserTaskHelper'] =  $dir . '/tasks/ExactTargetUserTaskHelper.php' ;
$wgAutoloadClasses['Wikia\ExactTarget\Tasks\ExactTargetCreateUserTask'] =  $dir . '/tasks/ExactTargetCreateUserTask.php' ;
$wgAutoloadClasses['Wikia\ExactTarget\Tasks\ExactTargetRetrieveUserHelper'] =  $dir . '/tasks/ExactTargetRetrieveUserHelper.php' ;
$wgAutoloadClasses['Wikia\ExactTarget\Tasks\ExactTargetUpdateUserTask'] =  $dir . '/tasks/ExactTargetUpdateUserTask.php' ;
$wgAutoloadClasses['Wikia\ExactTarget\Tasks\ExactTargetDeleteUserTask'] =  $dir . '/tasks/ExactTargetDeleteUserTask.php';
/* Add API classes */
$wgAutoloadClasses['Wikia\ExactTarget\Api\ExactTargetApiDataExtension'] =  $dir . '/api/ExactTargetApiDataExtension.php' ;
$wgAutoloadClasses['Wikia\ExactTarget\Api\ExactTargetApiHelper'] =  $dir . '/api/ExactTargetApiHelper.php' ;
/* Add ExactTarget classes (the rest of ExactTarget classes are loaded internally by ExactTargetSoapClient */
$wgAutoloadClasses['ExactTargetSoapClient'] =  $dir . '/lib/exacttarget_soap_client.php' ;

/**
 * Registering hooks
 */
$wgExtensionFunctions[] = 'ExactTargetSetupHooks::setupHooks';
