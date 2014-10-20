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

/* Load classes */
$wgAutoloadClasses['ExactTargetMainHelper'] = $dir . '/ExactTargetMainHelper.php';
/* Add hooks classes */
$wgAutoloadClasses['ExactTargetUserHooks'] =  $dir . '/hooks/ExactTargetUser.hooks.php' ;
$wgAutoloadClasses['ExactTargetUserHooksParamsHelper'] =  $dir . '/hooks/ExactTargetUserHooksParamsHelper.php' ;
$wgAutoloadClasses['ExactTargetUserHooksTaskInstanceHelper'] =  $dir . '/hooks/ExactTargetUserHooksTaskInstanceHelper.php' ;
/* Add tasks classes */
$wgAutoloadClasses['ExactTargetCreateUserTask'] =  $dir . '/tasks/ExactTargetUserTaskHelper.php' ;
$wgAutoloadClasses['ExactTargetCreateUserTask'] =  $dir . '/tasks/ExactTargetCreateUserTask.php' ;
$wgAutoloadClasses['ExactTargetUpdateUserTask'] =  $dir . '/tasks/ExactTargetUpdateUserTask.php' ;
$wgAutoloadClasses['ExactTargetDeleteUserTask'] =  $dir . '/tasks/ExactTargetDeleteUserTask.php' ;
/* Add ExactTarget classes (the rest of ExactTarget classes are loaded internally by ExactTargetSoapClient */
$wgAutoloadClasses['ExactTargetSoapClient'] =  $dir . '/lib/exacttarget_soap_client.php' ;

/**
 * Registering hooks
 */
$wgExtensionFunctions[] = 'ExactTargetUserHooks::setupHooks';
