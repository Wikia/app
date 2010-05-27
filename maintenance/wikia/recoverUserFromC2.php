<?php
/**
 * Remove unused user accounts from the database
 * An unused account is one which has made no edits
 *
 * @file
 * @ingroup Maintenance
 * @author Rob Church <robchur@gmail.com>
 */

ini_set( "include_path", dirname(__FILE__)."/.." );
$IP = $GLOBALS["IP"];
require_once( "commandLine.inc" );
$fname = 'recoverUserFromC2';

# Do an initial scan for inactive accounts and report the result
echo( "Checking for unused user accounts...\n" );
$del = array();
$db2 = wfGetDB( DB_SLAVE, array(), 'wikicities_c2' );
$db3 = wfGetDB( DB_MASTER, array(), 'wikicities_c2' );
$db1 = wfGetDB( DB_SLAVE, 'stats', $wgExternalSharedDB );
$res = $db2->select( 'user', array( '*' ), 'user_id > 2080000', $fname );
while( $row = $db2->fetchObject( $res ) ) {
	# Check the account, but ignore it if it's within a $excludedGroups group or if it's touched within the $touchedSeconds seconds.
	echo "check " . $row->user_name . " ";
	$row2 = $db1->selectRow( '`wikicities`.`user`', array( '*' ), array('user_id' => $row->user_id) , $fname );
	if ( $row2 ) {
		if ( $row2->user_name != $row->user_name ) {
			echo "diff! \n";
			$db3->insert(
				"recover_user",
				array(
				  'user_id' => $row->user_id,
				  'user_name' => $row->user_name,
				  'user_real_name' => $row->user_real_name,
				  'user_password' => $row->user_password,
				  'user_newpassword' => $row->user_newpassword,
				  'user_email' => $row->user_email,
				  'user_options' => $row->user_options,
				  'user_touched' => $row->user_touched,
				  'user_token' => $row->user_token,
				  'user_email_authenticated' => $row->user_email_authenticated,
				  'user_email_token' => $row->user_email_token,
				  'user_email_token_expires' => $row->user_email_token_expires,
				  'user_registration' => $row->user_registration,
				  'user_newpass_time' => $row->user_newpass_time,
				  'user_editcount' => $row->user_editcount,
				  'user_birthdate' => $row->user_birthdate,
				)
			);
		}
	} else {
		echo " the same \n";
	}

}

echo "end \n";
