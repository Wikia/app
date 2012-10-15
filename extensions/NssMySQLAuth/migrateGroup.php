<?php

require_once( 'commandLine.inc' );

function migrateGroup( $group ) {
	$groups = parseGroupFile();

	if ( !isset( $groups[$group] ) )
		return false;
	$group = $groups[$group];

	global $wgAuth;
	$dbw = $wgAuth->getDB( DB_WRITE );
	if ( false == $dbw->insert( 'groups', array(
			'grp_name' => $group['name'],
			'grp_password' => $group['password'],
			'grp_gid' => $group['gid'],
		), __METHOD__ ) )
		return false;
	foreach ( $group['members'] as $user ) {
		$pwd = posix_getpwnam( $user );
		if ( !$pwd )
			return false;
		print "Migrating {$pwd['name']}\n";
		if ( false == $dbw->insert( 'group_membership', array(
			'gm_group' => $group['name'],
			'gm_user' => $pwd['uid']
			), __METHOD__ ) ) {

			$dbw->rollback();
			return false;
		}
	}

	$dbw->commit();
	wfDoUpdates();
	return true;
}

function parseGroupFile() {
	$file = fopen( '/etc/group', 'r' );
	$groups = array();
	while ( $line = fgets( $file ) ) {
		$entry = explode( ':', trim( $line ) );
		$groups[$entry[0]] = array(
			'name' => $entry[0],
			'password' => $entry[1],
			'gid' => $entry[2],
			'members' => explode( ',', $entry[3] )
		);
	}
	return $groups;
}

if ( !isset( $args ) || count( $args ) < 1 ) {
	print "Usage: php migrateGroup.php <group>\n";
	exit(1);
}

if( migrateGroup( $args[0] ) ) {
	print "Group '{$args[0]}' succesfully migrated!\n";
	exit(0);
} else {
	print "Migration failed!\n";
	exit(1);
}
