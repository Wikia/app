<?php
// BugzId:38283
$optionsWithArgs = array( "db" );

ini_set( "include_path", dirname(__FILE__)."/.." );
require_once( "commandLine.inc" );

$dbw = wfGetDB( DB_MASTER, array() );

$res = $dbw->select(
	array( "image" ),
	array( "img_minor_mime", "img_name" ),
	array( "img_minor_mime != 'png'", "img_name LIKE 'Badge-%.png'" ),
	__METHOD__
);

while( $row = $dbw->fetchRow( $res ) ) {
	if ( $dbw->update(
		"image",
		array( "img_minor_mime" => "png" ),
		array( "img_name" => $row['img_name'] )
	) ) {
		echo "Updated: {$wgDBname} / {$row['img_name']}\n";
	} else {
		echo "Can't update: {$wgDBname} / {$row['img_name']}\n";
	}
}

$dbw->commit();