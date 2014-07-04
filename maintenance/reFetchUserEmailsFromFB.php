<?php

/**
 * Script for fetching emails of users which have connected Facebook accounts
 * (doing this only for users, which don't have e-mails in our database)
 *
 * For more detailed description see: https://wikia-inc.atlassian.net/browse/CE-587
 */

include( 'commandLine.inc' );

$usersWithoutEmails = fetchUsersWithoutEmails();
$fbIdToUser = getFBIdToUser( $usersWithoutEmails );
$fbIdToEmail = getFBIdToEmail( getFBIds( $fbIdToUser ) );
updateEmails( $fbIdToUser, $fbIdToEmail );

function fetchUsersWithoutEmails() {
	$usersWithoutEmails = [ ];

	global $wgExternalSharedDB;
	$db = wfGetDB( DB_SLAVE, array(), $wgExternalSharedDB );

	$cursor = $db->query(
		'select u.user_name as user_name '.
		'from user as u '.
		'inner join user_fbconnect as fb on u.user_id=fb.user_id '.
		'where u.user_email = \'\' '.
		'and not u.user_name like "TempUser%" '.
		'and u.user_real_name != "Account Disabled"');

	while($row = $db->fetchObject($cursor)) {
		$userName = $row->user_name;

		echo "User without email:\t".$userName."\n";

		$user = User::newFromName( $userName );
		$usersWithoutEmails[ ] = $user;
	}

	return $usersWithoutEmails;
}

function getFBIdToUser( &$users ) {
	$fbIdToUser = [ ];

	foreach ( $users as $user ) {
		$fbIds = FBConnectDB::getFacebookIDs( $user );
		foreach ( $fbIds as $fbId ) {
			$fbIdToUser[ $fbId ] = $user;
		}
	}

	return $fbIdToUser;
}

function getFBIds( &$fbIdToUser ) {
	$fbIds = [ ];

	foreach ( $fbIdToUser as $fbId => $user ) {
		$fbIds[ ] = $fbId;
	}

	return $fbIds;
}

function getFBIdToEmail( &$fbIds ) {
	$fbIdToEmail = [ ];

	$fb = new FBConnectAPI();
	$usersInfo = $fb->Facebook()->api_client->users_getInfo( $fbIds, [ 'contact_email' ] );

	foreach ( $usersInfo as $userInfo ) {
		$fbId = $userInfo[ 'uid' ];
		$email = $userInfo[ 'contact_email' ];
		if ( !empty( $email ) ) {
			$fbIdToEmail[ $fbId ] = $email;
		}
	}

	return $fbIdToEmail;
}

function updateEmails( &$fbIdToUser, &$fbIdToEmail ) {
	$updatedUsersIds = [ ];

	foreach ( $fbIdToEmail as $fbId => $email ) {
		$user = $fbIdToUser[ $fbId ];
		$userId = $user->getId();

		if ( !empty( $updatedUsersIds[ $userId ] ) ) {
			// log warn
			echo "Fetched more than one email for user with id = " . $userId . "\n";
			continue;
		}

		echo "Fetched email:\t".$email."\n";

		$user->setEmail( $email );
		$user->saveSettings();
		$updatedUsersIds[ ] = $userId;
	}
}