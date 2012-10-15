<?php
if ( ! defined( 'MEDIAWIKI' ) )
    die();

/**
 * Extension to provide customisable email notification of new user creation
 *
 * @file
 * @author Rob Church <robchur@gmail.com>
 * @ingroup Extensions
 * @copyright © 2006 Rob Church
 * @license GNU General Public Licence 2.0 or later
 */

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name'           => 'New User Email Notification',
	'version'        => '1.5.2',
	'author'         => 'Rob Church',
	'url'            => 'https://www.mediawiki.org/wiki/Extension:New_User_Email_Notification',
	'descriptionmsg' => 'newusernotif-desc',
);

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['NewUserNotifier'] = $dir . 'NewUserNotif.i18n.php';
$wgAutoloadClasses['NewUserNotifier'] = $dir . 'NewUserNotif.class.php';
$wgExtensionFunctions[] = 'efNewUserNotifSetup';

/**
 * Email address to use as the sender
 */
$wgNewUserNotifSender = $wgPasswordSender;

/**
 * Users who should receive notification mails
 */
$wgNewUserNotifTargets[] = 1;

/**
 * Additional email addresses to send mails to
 */
$wgNewUserNotifEmailTargets = array();

/**
 * Extension setup
 */
function efNewUserNotifSetup() {
	global $wgHooks;
	$wgHooks['AddNewAccount'][] = 'efNewUserNotif';
}

/**
 * Hook account creation
 *
 * @param User $user User account that was created
 * @return bool
 */
function efNewUserNotif( $user ) {
	return NewUserNotifier::hook( $user );
}
