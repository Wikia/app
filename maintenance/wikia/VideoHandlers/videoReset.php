<?php
/**
 * @usage: sudo -u www-data SERVER_ID=177 php videoReset.php --conf /usr/wikia/conf/current/wiki.factory/LocalSettings.php --aconf /usr/wikia/conf/current/AdminSettings.php
 * @usage: sudo -u www-data SERVER_ID=177 php videoReset.php --conf /usr/wikia/conf-current/wiki.factory/LocalSettings.php --aconf /usr/wikia/conf-current/AdminSettings.php
 *  */
ini_set( 'display_errors', 'stdout' );
$options = array('help');

@require_once( '../../commandLine.inc' );

global $IP, $wgCityId;
#$IP = '/home/pbablok/video/VideoRefactor/'; // HACK TO RUN ON SANDBOX
#echo( "$IP\n" );

echo( "Reset script running for $wgCityId\n" );

if( isset( $options['help'] ) && $options['help'] ) {
	echo( "Usage: php videoReset.php\n" );
	exit( 0 );
}

//include( "$IP/extensions/wikia/VideoHandlers/VideoHandlers.setup.php" );

WikiFactory::setVarByName('wgVideoHandlersVideosMigrated', $wgCityId, false);



global $wgExternalDatawareDB;
$dbw_dataware = wfGetDB( DB_MASTER, array(), $wgExternalDatawareDB );

$dbw_dataware->query("DELETE FROM video_premigrate WHERE wiki_id='$wgCityId'");
$dbw_dataware->query("DELETE FROM video_migration_sanitization WHERE city_id='$wgCityId'");
$dbw_dataware->query("DELETE FROM video_sanitization_failededit WHERE city_id='$wgCityId'");


echo "Done\n";


?>
