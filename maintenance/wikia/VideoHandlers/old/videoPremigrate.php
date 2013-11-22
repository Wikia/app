<?php
/**
 * @usage: sudo -u www-data SERVER_ID=177 php videoPremigrate.php --conf /usr/wikia/conf/current/wiki.factory/LocalSettings.php --aconf /usr/wikia/conf/current/AdminSettings.php
 * @usage: sudo -u www-data SERVER_ID=177 php videoPremigrate.php --conf /usr/wikia/conf-current/wiki.factory/LocalSettings.php --aconf /usr/wikia/conf-current/AdminSettings.php
 *  */
ini_set( 'display_errors', 'stdout' );
$options = array('help');

require_once( '../../commandLine.inc' );
require_once( 'premigrate.class.php' );
require_once( 'videolog.class.php' );

global $IP, $wgCityId, $wgExternalDatawareDB;
#$IP = '/home/pbablok/video/VideoRefactor/'; // HACK TO RUN ON SANDBOX


echo( "Premigration script running for $wgCityId\n" );

videoLog( 'premigration', 'START', '');

if( isset( $options['help'] ) && $options['help'] ) {
	echo( "Usage: php videoPremigrate.php\n" );
	exit( 0 );
}


$dbr = wfGetDB( DB_SLAVE );
$dbw = wfGetDB( DB_MASTER );
$dbw_dataware = wfGetDB( DB_MASTER, array(), $wgExternalDatawareDB );

echo( "Loading list of videos to process\n" );

$rows = $dbw->select('image', 
		array( 'img_name' ),
		array( "img_name LIKE ':%'" ),
		__METHOD__
	);

$rowCount = $rows->numRows();
echo(": {$rowCount} videos found\n");



$i = 0;
$j = 0;
$timeStart = microtime( true );
if($rowCount) {
	Premigrate::initialize();
	
	while($video = $dbw->fetchObject($rows)) {
		$i++;

		if( !Premigrate::needsProcessing($video->img_name) ) {
			continue;
		}

		$j++;

		// debugging info
		$timeEnd = microtime( true );
		$time = intval( $timeEnd - $timeStart);
		$vps = intval($i / ($timeEnd - $timeStart) * 60);
		$timeString = "[$time s, $vps vpm]";
		echo( "- [$i / $rowCount]\t $timeString \tVideo: {$video->img_name} \n" );


		Premigrate::ProcessVideo($video->img_name);

	}

	echo("\nDone\n");
}
else {
	echo("Nothing to do\n");
}

$dbw->freeResult($rows);
videoLog( 'premigration', 'STOP', "processed:$j,total:$i");

echo(": {$rowCount} videos processed.\n");


?>
