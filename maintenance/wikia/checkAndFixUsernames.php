<?php

$optionsWithArgs = array( "db" );

ini_set( "include_path", dirname(__FILE__)."/.." );
require_once( "commandLine.inc" );

$tables = array(
	"revision"      => array( "rev_user_text", "rev_user", "rev_id" ),
	"image"         => array( "img_user_text", "img_user", "img_name" ),
	"recentchanges" => array( "rc_user_text",  "rc_user",  "rc_id" ),
	"archive"       => array( "ar_user_text",  "ar_user" ),
	"filearchive"   => array( "fa_user_text",  "fa_user", "fa_id" ),
	"oldimage"      => array( "oi_user_text",  "oi_user" )
);

/**
 * wikicites handler
 */
$central = wfGetDB( DB_SLAVE, array(), $wgExternalSharedDB );


/**
 * local database handler
 * @todo do not harcode, use commandline option
 */
$db = isset( $options[ "db" ] ) ? $options[ "db" ] : "lyricwiki";
$dbw = $dbr = wfGetDB( DB_MASTER, array(), $db );

/**
 * not very optimal but we cant use join between db clusters
 *
 * we probably could assume that username which is bad in one table is bad
 * in other as well
 */
$cachedUsers = array();
foreach( $tables as $table => $columns ) {
	Wikia::log( "log", "table", $table );
	$sth = $dbw->select(
		array( $table ),
		$columns,
		false,
		__METHOD__
	);
	while( $row = $dbw->fetchRow( $sth ) ) {
		/**
		 * for this username check user_id in external shared
		 */
		if( empty( $cachedUsers[ $row[ 0 ] ] ) ) {
			$user = $central->selectRow(
				array( "user" ),
				array( "user_id", "user_name"),
				array( "user_name" => $row[ 0 ] ),
				__METHOD__
			);
			if( !empty( $user ) ) {
				$cachedUsers[ $user->user_name ] = $user->user_id;
			}
		}
		$userid = $cachedUsers[ $row[ 0 ] ];
		if( $userid != $row[ 1 ] && !empty( $row[ 1 ] ) ) {
			Wikia::log( "log", false, "inconsistency in $table, for {$row[ 0 ]} local = {$row[ 1 ]}, global = {$userid}" );
			echo "UPDATE $table SET {$columns[ 1 ]} = {$userid} WHERE {$columns[ 0 ]} = '{$row[ 0 ]}' AND {$columns[ 1 ]} <> {$userid} AND {$columns[ 1 ]} <> 0 LIMIT 1;\n";
		}
		$central->ping();
	}
}
