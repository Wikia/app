<?php

/*
 * Maintenance script to remove blacklisted videos
 * This is one time use script
 * @author Saipetch Kongkatong
 */

function printText( $text ) {
	global $quiet;

	if ( !$quiet ) {
		echo $text;
	}
}

// ----------------------------- Main ------------------------------------

ini_set( "include_path", dirname( __FILE__ )."/../../" );

require_once( "commandLine.inc" );

if ( isset($options['help']) ) {
	die( "Usage: php removeBlacklistedVideos.php [--help] [--dry-run] [--quiet]
	--dry-run                      dry run (for setupVideoInfo, copyRVtoGlobalList)
	--quiet                        show summary result only (for setupVideoInfo, copyRVtoGlobalList)
	--help                         you are reading it right now\n\n" );
}

$dryRun = ( isset($options['dry-run']) );
$quiet = ( isset($options['quiet']) );

if ( empty($wgCityId) ) {
	die( "Error: Invalid wiki id.\n" );
}

echo "Wiki: ".$wgCityId."\n";

if ( empty($wgVideoBlacklist) ) {
	die( "Empty video blacklist.\n" );
}

echo "VideoBlacklist: ".$wgVideoBlacklist."\n";

$keywords = str_replace( ',', '|', $wgVideoBlacklist );
$lower = strtolower( $keywords );
$ucword = ucwords( $keywords );

$db = wfGetDB( DB_SLAVE, array() );

$sql = <<<SQL
	SELECT img_name
	FROM image
	WHERE lower(replace(img_name,'_',' ')) REGEXP '[[:<:]]($lower)[[:>:]]'
		OR img_metadata REGEXP '[[:<:]]($lower)[[:>:]]'
		OR img_metadata REGEXP '[[:<:]]($ucword)[[:>:]]'
SQL;

$result = $db->query( $sql, __METHOD__ );

$cnt = 0;
$success = 0;
while( $row = $db->fetchObject($result) ) {
	$name = $row->img_name;
	printText("\tVideo: $name\n" );

	$title = Title::newFromText( $name, NS_FILE );
	$file = wfFindFile( $title );
	if ( !empty( $file ) ) {
		$metadata = unserialize( $file->getMetadata() );

		if ( !array_key_exists( 'titleName', $metadata) ) {
			$metadata['titleName'] = $title->getText();
		}

		$feedIngester = VideoFeedIngester::getInstance( $file->getProviderName() );
		if ( $feedIngester->isBlacklistVideo( $metadata ) ) {
			$file = dirname( __FILE__ ).'/../deleteOn.php';
			$cmd = "SERVER_ID={$wgCityId} php {$file} --conf=/usr/wikia/docroot/wiki.factory/LocalSettings.php -t 'File:{$name}'";
			printText ( "\tCommand: $cmd\n" );
			if ( !$dryRun ) {
				$result = wfShellExec( $cmd, $retval );
				if ( $retval ) {
					echo "Error code $retval: $result \n";
				} else {
					echo "$result \n";
				}
			}

			$success++;
		}
	}

	$cnt++;
}

echo "Total Videos: $cnt, SUCCESS: $success, FAILED: ".($cnt-$success)."\n";