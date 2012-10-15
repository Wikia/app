<?php

require_once( 'commandLine.inc' );

function migrateUser( $username, $email ) {
	$pwd = posix_getpwnam( $username );
	if ( !$pwd ) return false;

	// PHP sucks
	list( $password, $password_lastchange ) = getspwd( $username );
	if ( is_null( $password ) || is_null( $password_lastchange ) )
		return false;

	global $wgAuth;
	$dbw = $wgAuth->getDB( DB_WRITE );
	if ( false == $dbw->insert( 'passwd', array(
			'pwd_uid' => $pwd['uid'],
			'pwd_name' => $pwd['name'],
			'pwd_password' => $password,
			'pwd_password_lastchange' => $password_lastchange,
			'pwd_gid' => $pwd['gid'],
			'pwd_home' => $pwd['dir'],
			'pwd_shell' => $pwd['shell'],
			'pwd_active' => 'active',
			'pwd_email' => $email
		), __METHOD__ ) )
		return false;
	if ( false == $dbw->insert( 'user_props',  array(
			'up_timestamp' => $dbw->timestamp(),
			'up_user' => $username,
			'up_name' => 'email',
			'up_value' => $email
		), __METHOD__ ) )
		return false;

	$dbw->commit();
	wfDoUpdates();
	return true;
}

function getspwd( $username ) {
	$shadow = fopen( '/etc/shadow', 'r' );
	while( $line = fgets( $shadow ) ) {
		$entry = explode( ':', trim( $line ) );
		if ( $entry && $entry[0] == $username )
			return array( $entry[1], $entry[2] );
	}
	fclose( $shadow );
	return array( null, null );
}

if ( !isset( $args ) || count( $args ) < 2 ) {
	print "Usage: php migrateUser.php <username> <email>\n";
	exit(1);
}

if( migrateUser( $args[0], $args[1] ) ) {
	print "User '{$args[0]}' succesfully migrated!\n";
	exit(0);
} else {
	print "Migration failed!\n";
	exit(1);
}
