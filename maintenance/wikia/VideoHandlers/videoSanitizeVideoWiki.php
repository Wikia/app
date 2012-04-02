<?php
/**
 * @usage: SERVER_ID=177 php videoSanitize.php --conf /usr/wikia/conf/current/wiki.factory/LocalSettings.php --aconf /usr/wikia/conf/current/AdminSettings.php
 * @usage: SERVER_ID=177 php videoSanitize.php --conf /usr/wikia/conf-current/wiki.factory/LocalSettings.php --aconf /usr/wikia/conf-current/AdminSettings.php
 *  */


function get_regexp( $title, $replacement, &$wsc ) {
	$wsc = 0;
	$symbols = array(
		array(' ','_','-','+','/'),
	);
	$refs = array();
	foreach( $symbols as $id => $val ) {
		foreach( $val as $id2 => $symbol ) {
			$imp = implode('\\',$val);
			$refs[$symbol] = '[\\' . $imp .']';
		}
	}

	$regexp = '';

	$j = mb_strlen($title);
	for ($k = 0; $k < $j; $k++) {
		$char = mb_substr($title, $k, 1);
		if(isset($refs[$char])) {
			$wsc++;
			$regexp .= '('.$refs[$char] . "|%20){1,}";
		} else {
			if(ctype_alnum($char)) {
				if ( $k == 0 ) {
					$regexp .= '['.strtolower($char).strtoupper($char).']';
				} else {
					$regexp .= $char;
				}
			} else {
				//$int = ord($char);
				//echo "-------------- Escaping $char ($int)\n";
				if( $char == '?') {
					$regexp .= '(\\' . $char . '|%3f|%3F)';
					$wsc++;
				} else {
					$regexp .= '\\' . $char;
				}
			}
		}
	}
	#echo "Part of regexp: $regexp\n";
	return $regexp;
}

function title_replacer( $title, $replacement, $fulltext  ) {

	$wsc = 0;
	$regexp = get_regexp( $title, $replacement, $wsc );
	$regexp = '/(\\[\\[Video\\:)[ ]{0,}' . $regexp . '[ ]{0,}(( *)?#.*?)?'.'(\\]\\]|\\|[^]]+\\]\\])/';
	$new = preg_replace( $regexp, '$1' . $replacement . '$'.(4+$wsc), $fulltext );
	if( $new === null ) return $fulltext;
	return $new;
}

ini_set( "include_path", dirname(__FILE__)."/.." );
//require_once( 'commandLine.inc' );

ini_set( 'display_errors', 'stdout' );
$options = array('help');
@require_once( '../../commandLine.inc' );
require_once ('videoSanitizerMigrationHelper.class.php');
require_once( 'videolog.class.php' );

global $IP, $wgCityId, $wgDBname, $wgExternalDatawareDB, $wgVideoHandlersVideosMigrated, $wgDBname;

$wgVideoHandlersVideosMigrated = false; // be sure we are working on old files

$devboxuser = exec('hostname');
$sanitizeHelper = new videoSanitizerMigrationHelper($wgCityId, $wgDBname, $wgExternalDatawareDB);
$botUser = User::newFromName( 'WikiaBot' );

// echo( "$IP\n" );
echo( "Video name sanitizer script running for $wgCityId\n" );
videoLog( 'sanitize', 'START', '');


// $IP = '/home/release/video_refactoring/trunk'; // HACK TO RUN ON CRON-S3
require_once( "$IP/extensions/wikia/VideoHandlers/VideoHandlers.setup.php" );

$dbw = wfGetDB( DB_MASTER );
$dbw_dataware = wfGetDB( DB_MASTER, array(), $wgExternalDatawareDB );

$i = 0;
$aTranslation = array();
$aAllFiles = array();

$rows = $dbw->query( "SELECT img_name FROM image" );

$rowCount = $rows->numRows();
echo( ": {$rowCount} videos found\n" );

if ( $rowCount ) {
	// before processing videos prepare 'status cache'
	// which contains information about previously processed
	// videos on this wiki
	//echo "Fetching data about previously processed videos\n";

	while( $file = $dbw->fetchObject( $rows ) ) {
		$aAllFiles[ $file->img_name ] = 1;
	}

	$i = 0;
	foreach( $aAllFiles as $sFile => $val ) {
		wfWaitForSlaves( 2 );
		if ( strpos ( $sFile, ':' ) === 0 ) {
			// var_dump(':');

			if ( !empty( $previouslyProcessed[$sFile] ) ) {
				continue;
			}

			$response = F::app()->sendRequest(
				'VideoHandlerController',
				'getSanitizedOldVideoTitleString',
				array(
					'videoText' => $sFile
				)
			)->getData();

			if( isset( $response['error'] ) ) continue;

			$newNameCandidate = $response['result'];
			$sNewTitle = $newNameCandidate;

			if ( $sFile === $sNewTitle ||
				 isset ( $aAllFiles[ substr($sNewTitle, 1 ) ] ) ||
				 isset ( $aAllFiles[ $sNewTitle ] )
			) {
				// on video wiki we only need to make sure that all videos have their "migrated" counterparts
				// so everything should be duplicated, at no point do we create _2 _3 videos (we assume
				// that name conflicts are for the same video just pre-sanitized vs post-sanitized)
				continue;
			}

			echo "Going to make a duplicate for $sFile as $sNewTitle \n";
			$aTranslation[ $sFile ] = $sNewTitle;
			$aAllFiles[ substr($sNewTitle, 1 ) ] = 1;

			$oldtitle = Title::newFromText( substr($sFile, 1 ), NS_LEGACY_VIDEO );

			if( $oldtitle && $oldtitle->exists() ) {
				$oldarticle = new Article( $oldtitle );
				$content = $oldarticle->getContent();

				$title = Title::newFromText( substr($sNewTitle, 1 ), NS_LEGACY_VIDEO );
				$article = new Article( $title );
				$article->doEdit( $content, 'duplicating Video (sanitization)', EDIT_FORCE_BOT, false, $botUser );
				echo "Video duplicated\n";
			}

		}
	}
}
$dbw->freeResult( $rows );

print_r( $aTranslation );

$botUser = User::newFromName( 'WikiaBot' );

$i=0;

$count = count( $aTranslation );
foreach ( $aTranslation as $key => $val ) {
	wfWaitForSlaves( 2 );
	echo "aTranslation[$key]=$val\n";

	$strippedNew = ( substr( $val, 0, 1 ) == ':' ) ? substr( $val, 1 ) : $val;
	$strippedOld = ( substr( $key, 0, 1 ) == ':' ) ? substr( $key, 1 ) : $key;

	$oRow = $dbw->selectRow( 'image', '*', array('img_name'=>$key) );
	$row = (array)$oRow;
	$row['img_name'] = $val;

	$res = $dbw->insert(
		'image',
		$row,
		__METHOD__
	);
	$num = $dbw->affectedRows();
	if( $num ) {
		echo "duplicated entry in image table (changes:$num, image: $val)\n";
		$i++;
	}


}

echo(": {$rowCount} videos processed.\n");
videoLog( 'sanitize', 'DUPLICATED', "duplicated:$i");

videoLog( 'sanitize', 'STOP', "");


?>