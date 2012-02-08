<?php
/**
 * @usage: SERVER_ID=177 php videoSanitize.php --conf /usr/wikia/conf/current/wiki.factory/LocalSettings.php --aconf /usr/wikia/conf/current/AdminSettings.php
 * @usage: SERVER_ID=177 php videoSanitize.php --conf /usr/wikia/conf-current/wiki.factory/LocalSettings.php --aconf /usr/wikia/conf-current/AdminSettings.php
 *  */
ini_set( "include_path", dirname(__FILE__)."/.." );
require_once( 'commandLine.inc' );

ini_set( 'display_errors', 'stdout' );
$options = array('help');
@require_once( '../commandLine.inc' );
// $IP = '/home/pbablok/video/VideoRefactor/'; // HACK TO RUN ON SANDBOX
// echo( "$IP\n" );
echo( "Video name sanitizer script running for $wgCityId\n" );

if( isset( $options['help'] ) && $options['help'] ) {
	echo( "Usage: php VideoSanitizer.php\n" );
	exit( 0 );
}

require_once( "$IP/extensions/wikia/VideoHandlers/VideoHandlers.setup.php" );

$dbw = wfGetDB( DB_MASTER );

$i = 0;
$timeStart = microtime( true );
$aTranslation = array();
$aAllFiles = array();
$timeStart = microtime( true );

$rows = $dbw->query( "	SELECT img_name
			FROM image");

$rowCount = $rows->numRows();
echo( ": {$rowCount} videos found\n" );

if ( $rowCount ) {
	// before processing videos prepare 'status cache'
	// which contains information about previously processed
	// videos on this wiki
	//echo "Fetching data about previously processed videos\n";
	
	while( $file = $dbw->fetchObject( $rows ) ) {
		$aAllFiles[] = $file->img_name;
	}
	echo "[".intval( microtime( true ) - $timeStart)." s] table created \n";

	foreach( $aAllFiles as $sFile ) {
		if ( strpos ( $sFile, ':' ) === 0 ) {
			$response = F::app()->sendRequest(
				'VideoHandlerController',
				'getSanitizedOldVideoTitleString',
				array(
					'videoText' => $sFile
				)
			)->getData();
			if( isset( $response['error'] ) ) continue;

			if ( ( $response['result'] != $sFile ) || ( in_array( substr( $response['result'], 1), $aAllFiles ) ) ){
				$found = false;
				$sufix = 0;
				$newNameCandidate = $response['result'];
				$continue = true;
				while ( $continue == true ) {
					$sNewTitle = $newNameCandidate . ( empty( $sufix ) ? '' : ' '.$sufix );
					if ( 	!in_array( substr( $sNewTitle, 1), $aAllFiles ) &&
						!in_array( $sNewTitle, $aAllFiles ) 
					) {
						$continue = false;
					} else {
					}
					$sufix++;
				};
				$aTranslation[ $sFile ] = $newNameCandidate;
			}
		}
	}
}

echo "[".intval( microtime( true ) - $timeStart)." s] DONE!\n";

$dbw->freeResult( $rows );


echo(": {$rowCount} videos processed.\n");
/*
 * wywala nam sie upload
 * check if new name will be available
 * change in page
 * upload
 * success -> change in all backlinking articles
 */

?>