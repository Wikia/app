<?php

$optionsWithArgs = array( "db" );

ini_set( "include_path", dirname(__FILE__)."/.." );
require_once( "commandLine.inc" );

$tables = array(
	"revision"      => array( "rev_user_text", "rev_user", "rev_id" ),
	"image"         => array( "img_user_text", "img_user", "img_name" ),
	"recentchanges" => array( "rc_user_text",  "rc_user",  "rc_id" ),
	"filearchive"   => array( "fa_user_text",  "fa_user",  "fa_id" ),
	"archive"       => array( "ar_user_text",  "ar_user",  "ar_namespace", "ar_title", "ar_timestamp" ),
	"oldimage"      => array( "oi_user_text",  "oi_user",  "oi_name", "oi_timestamp" )
);

/**
 * wikicites handler
 */
$central = wfGetDB( DB_SLAVE, array(), $wgExternalSharedDB );


/**
 * local database handler
 * @todo do not harcode, use commandline option
 */
$db    = isset( $options[ "db" ] ) ? $options[ "db" ] : "lyricwiki";
$write = isset( $options[ "write" ] ) ? true : false;
$dbw   = wfGetDB( DB_MASTER, array(), $db );

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
		$text = $columns[ 0 ];
		$id   = $columns[ 1 ];
		$text_val = $row[ 0 ];
		$id_val   = $row[ 1 ];

		if( empty( $cachedUsers[ $id_val ] ) ) {
			$user = $central->selectRow(
				array( "user" ),
				array( "user_id", "user_name"),
				array( "user_id" => $id_val ),
				__METHOD__
			);
			if( !empty( $user ) ) {
				$cachedUsers[ $user->user_id ] = $user->user_name;
			}
		}

		$username = str_replace( " ", "_", $cachedUsers[ $id_val ] );
		if( $username != $text_val && !empty( $id_val ) && !empty( $username ) ) {
			Wikia::log( "log", false, "inconsistency in $table, for {$id_val} local = {$text_val}, global = {$username}" );
			$sql = sprintf(
				"UPDATE %s SET %s = %s WHERE %s = %d AND %s <> %s AND %s <> 0",
				$table,
				$text,
				$dbw->addQuotes( $username ),
				$id,
				$id_val,
				$text,
				$dbw->addQuotes( $username ),
				$id
			);

			foreach( array_slice( $columns, 2, 4, true ) as $index => $column ) {
				$sql .= " AND $column = ". $dbw->addQuotes( $row[ $index ] );
			}
			if( $write ) {
				wfWaitForSlaves(3);
				$dbw->begin( );
				$dbw->query( $sql, __METHOD__ );
				$dbw->commit( );
			}
			else {
				echo $sql . "\n";
			}
		}
		$central->ping();
	}
}
