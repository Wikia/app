<?php

ini_set( 'display_errors', 'stdout' );
$options = array('help');

require_once( '../../commandLine.inc' );

global $wgCityId, $wgExternalDatawareDB;

echo( "Fixing image uploads as 127.0.0.1 for wiki: $wgCityId\n" );

$dbw = wfGetDB( DB_MASTER );

$dbw->query('UPDATE image       SET img_user = 4663069, img_user_text = "WikiaBot" WHERE img_user = 0 AND img_user_text = "127.0.0.1" AND img_media_type = "VIDEO"');
$num = $dbw->affectedRows();
echo "Updated $num rows in image table\n";
$dbw->query('UPDATE oldimage    SET oi_user  = 4663069, oi_user_text  = "WikiaBot" WHERE oi_user  = 0 AND oi_user_text  = "127.0.0.1" AND oi_media_type  = "VIDEO"');
$num = $dbw->affectedRows();
echo "Updated $num rows in oldimage table\n";
$dbw->query('UPDATE filearchive SET fa_user  = 4663069, fa_user_text  = "WikiaBot" WHERE fa_user  = 0 AND fa_user_text  = "127.0.0.1" AND fa_media_type  = "VIDEO"');
$num = $dbw->affectedRows();
echo "Updated $num rows in filearchive table\n";

wfWaitForSlaves( 3 );