<?php
/**
 * send Confirmation Reminder Mail
 *
 * @package MediaWiki
 * @subpackage Maintanance
 *
 * @author:  Tomasz Odrobny (Tomek) tomek@wikia-inc.com
 *
 * @copyright Copyright (C) 2008 Tomasz Odrobny (Tomek), Wikia, Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 *
 */

require_once('../commandLine.inc');

if (isset($options['help'])) {
	die( "send Confirmation Reminder Mail");
}

$from = wfTimestamp( TS_MW, mktime(0, 0, 0, date("m")  , date("d"), date("Y")) );
$to = wfTimestamp( TS_MW,  mktime(0, 0, 0, date("m")  , date("d")+1, date("Y")) );		

$con = '1
		and user_email is not null 
		and user_email_authenticated is null 
		and user_email_token_expires >= '.$from.' 
		and user_email_token_expires < '.$to;  

$db = WikiFactory::db( DB_SLAVE );
$res = $db->select(array( 'user' ), array( 'user_id'), $con);
$countAll = $countNoEmpty = 0;
$sql = '';
$countNoEmpty = 0;

while ($row = $db->fetchRow($res)) {
	$user = User::newFromId( $row['user_id'] );
	echo $user->getName()." exptime:".$user->mEmailTokenExpires."\n";
	if($user->sendConfirmationReminderMail()) {
		wfDebug( "sendConfirmationReminderMail for ". $user->getName()." exptime:".$user->mEmailTokenExpires."\n" );
	} else {
		wfDebug( "sendConfirmationReminderMail allready done for ". $user->getName()." exptime:".$user->mEmailTokenExpires."\n" );
	} 
}