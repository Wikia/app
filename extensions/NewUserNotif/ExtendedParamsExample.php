<?php
/**
 * Example Extension to provide additional parameters to the subject line and message body for NewUserNotif
 *
 * @file
 * @author Jack D. Pond <jack.pond@psitex.com>
 * @ingroup Extensions
 * @copyright 2011 Jack D. pond
 * @url http://www.mediawiki.org/wiki/Manual:Extensions
 * @licence GNU General Public Licence 2.0 or later
 */

if (!defined('MEDIAWIKI')) die('Not an entry point.');

$wgExtensionFunctions[] = 'efNewUserNotifSetupExtension';
$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'AdditionalNewUserNotifParams',
	'author' => array( 'Jack D. Pond' ),
	'version' => '1.0',
	'url' => 'https://www.mediawiki.org/wiki/Extension:NewUserNotif',
);

/**
 * Set up hooks for Additional NewUserNotif Parameters
 *
*/
function efNewUserNotifSetupExtension() {
	global $wgHooks;
	$wgHooks['NewUserNotifSubject'][] =  'efNewUserNotifSubject';
	$wgHooks['NewUserNotifBody'][] = 'efNewUserNotifBody';
	return true;
}


/**
 * This function creates additional parameters which can be used in the email notification Subject Line for new users
 *
 * @param $callobj NewUserNotifier object (this).
 * @param $subjectLine String: Returns the message subject line
 * @param $siteName Site Name of the Wiki
 * @param $recipient Email/User Name of the Message Recipient.
 * @param $user User name of the added user
 * @return  true
 */

function efNewUserNotifSubject ( $callobj , $subjectLine , $siteName , $recipient , $user )
{
	$subjectLine = wfMsgForContent(
				'newusernotifsubj',
				$siteName,										// $1 Site Name
				$user->getName()								// $2 User Name
	);
	return ( true );
}

/**
 * This function creates additional parameters which can be used in the email notification message body for new users
 *
 * @param $callobj NewUserNotifier object (this).
 * @param $messageBody String: Returns the message body.
 * @param $siteName Site Name of the Wiki
 * @param $recipient Email/User Name of the Message Recipient.
 * @param $user User name of the added user
 * @return  true
 */

function efNewUserNotifBody ( $callobj , $messageBody , $siteName , $recipient , $user )
{
	global $wgContLang;
	$messageBody = wfMsgForContent(
				'newusernotifbody',
				$recipient,										// $1 Recipient (of notification message) 
				$user->getName(),								// $2 User Name
				$siteName,										// $3 Site Name
				$wgContLang->timeAndDate( wfTimestampNow() ),	// $4 Time and date stamp
				$wgContLang->date( wfTimestampNow() ),			// $5 Date Stamp
				$wgContLang->time( wfTimestampNow() ),			// $6 Time Stamp
				$user->getEmail(),			                    // $7 email
				rawurlencode($siteName),						// $8 Site name encoded for email message link
				wfGetIP(),										// $9 Submitter's IP Address
				rawurlencode($user->getName())					// $10 User Name encoded for email message link
	);
	return ( true );
}
