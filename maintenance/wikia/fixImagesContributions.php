<?php

$optionsWithArgs = array( "db" );

ini_set( "include_path", dirname(__FILE__)."/.." );
require_once( "commandLine.inc" );


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
$sth = $dbw->select(
	array( "image" ),
	array( "img_user_text", "img_user", "img_name" ),
	array( "img_user_text" => "0", "img_timestamp <= 20090927200647" ),
	__METHOD__
);

while( $row = $dbw->fetchRow( $sth ) ) {
	/**
	 * check local user name first
	 */
#	$localUser = $dbw->selectRow(
#				     array( '`user`' ),
#		array( "user_id", "user_name"),
#		array( "user_id" => $row->img_user ),
#		__METHOD__
#	);
	print_r( $row->img_user );
#	print_r( $localUser );
	if( !empty( $localUser->user_name ) ) {

		/**
		 * for this username check user_id in external shared
		 */
		$text_val = $row[ 0 ];
		$id_val   = $row[ 1 ];

		if( empty( $cachedUsers[ $text_val ] ) ) {
			$user = $central->selectRow(
				array( "user" ),
				array( "user_id", "user_name"),
				array( "user_name" => $localUser->user_name ),
			__METHOD__
			);
			if( !empty( $user ) ) {
				$cachedUsers[ $user->user_name ] = $user->user_id;
			}
		}

		$userid = $cachedUsers[ $text_val ];
		if( $userid != $id_val && !empty( $id_val ) ) {
			Wikia::log( "log", false, "inconsistency in image, for {$text_val} local = {$id_val}, global = {$userid}" );
			$sql = sprintf(
				"UPDATE image SET img_user = %d, img_user_text = %d WHERE img_user_text = '0' and img_timestamp <= '20090927200647'",
				$userid,
				$dbw->addQuotes( $text_val ),
				$id_val
			);


	#			if( $write ) {
	#				$dbw->begin( );
	#				$dbw->query( $sql, __METHOD__ );
	#				$dbw->commit( );
	#			}
	#			else {
				echo $sql . "\n";
	#			}
		}
		$central->ping();
	}
}
