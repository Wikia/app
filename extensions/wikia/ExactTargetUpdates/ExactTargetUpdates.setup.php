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
		"Kamil Koterba <kamil@wikia-inc.com>"
	),
	'url'               => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/ExactTargetUpdates/'
);

$wgExtensionMessagesFiles[ 'ExactTargetUpdates' ] = $dir . '/ExactTargetUpdates.i18n.php';

$wgAutoloadClasses['ExactTargetBaseTask'] =  $dir . '/ExactTargetBaseTask.php' ;
$wgAutoloadClasses['ExactTargetAddUserTask'] =  $dir . '/ExactTargetAddUserTask.php' ;
$wgAutoloadClasses['ExactTargetRemoveUserTask'] =  $dir . '/ExactTargetRemoveUserTask.php' ;
$wgAutoloadClasses['ExactTargetUpdateUserTask'] =  $dir . '/ExactTargetUpdateUserTask.php' ;
$wgAutoloadClasses['ExactTargetUpdatesHooks'] =  $dir . '/ExactTargetUpdatesHooks.php' ;
$wgAutoloadClasses['ExactTargetSoapClient'] =  $dir . '/lib/exacttarget_soap_client.php' ;

/**
 * @global Array The list of hooks.
 * @see http://www.mediawiki.org/wiki/Manual:$wgHooks
 */
$wgHooks['ArticleSaveComplete'][] = 'ExactTargetUpdatesHooks::onArticleSaveComplete';
$wgHooks['EditAccountClosed'][] = 'ExactTargetUpdatesHooks::onEditAccountClosed';
$wgHooks['EmailChangeConfirmed'][] = 'ExactTargetUpdatesHooks::onEmailChangeConfirmed';
$wgHooks['SignupConfirmEmailComplete'][] = 'ExactTargetUpdatesHooks::onSignupConfirmEmailComplete';
$wgHooks['UserSaveSettings'][] = 'ExactTargetUpdatesHooks::onUserSaveSettings';
$wgHooks['UserRename::AfterAccountRename'][] = 'ExactTargetUpdatesHooks::onAfterAccountRename';
