<?php
if ( ! defined( 'MEDIAWIKI' ) )
    die();

/**
 * Extension to provide customisable email notification of new user creation
 *
 * @author Rob Church <robchur@gmail.com>
 * @addtogroup Extensions
 * @copyright © 2006 Rob Church
 * @license GNU General Public Licence 2.0 or later
 */

$wgExtensionCredits['other'][] = array(
	'name'           => 'New User Email Notification',
	'version'        => '1.5.1',
	'author'         => 'Rob Church',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:New_User_Email_Notification',
	'description'    => 'Sends email notification when user accounts are created',
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
