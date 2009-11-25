<?php

ini_set( "include_path", dirname(__FILE__)."/.." );
require_once( "commandLine.inc" );

$tables = array(
	"revision"      => "rev_user_text",
	"image"         => "img_user_text",
	"recentchanges" => "rc_user_text",
	"archive"       => "ar_user_text",
	"filearchive"   => "fa_user_text",
	"oldimage"      => "oi_user_text"
);

/**
 * wikicites handler
 */
$dbr = wfGetDB( DB_SLAVE, array(), $wgExternalSharedDB );


/**
 * local database handler
 * @todo do not harcode, use commandline option
 */
$dbw = $dbr = wfGetDB( DB_MASTER, array(), "lyrics" );

/**
 * not very optimal but we cant use join between db clusters
 *
 * we probably could assume that username which is bad in one table is bad
 * in other as well
 */
foreach( $tables as $table => $column ) {

	$sth = $dbr->select(
		array( $table ),
		array( $column ),
		false,
		__METHOD__
	);
	while( $row = $dbw->fetchObject( $sth ) ) {
		/**
		 * for this username check user_id in external shared
		 */
	}
}
