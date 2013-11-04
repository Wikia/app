<?php

/**
* Maintenance script to remove duplicate videos from ooyala for IVA videos only
* This is one time use script
* @author Saipetch Kongkatong
*/

/**
 * Get duplicate videos
 * @param DB $db
 * @return array $duplicateVideos
 */
function getDuplicateVideos( $db, $videoTitle = '' ) {
	$sqlWhere = empty( $videoTitle ) ? '' : 'and img_name like '.$db->addQuotes( $videoTitle.'%' );
	$sql = <<<SQL
		SELECT GROUP_CONCAT(img_name SEPARATOR '|') names,
			GROUP_CONCAT(substring_index(SUBSTRING_INDEX(img_metadata, 's:7:"videoId";s:32:"', -1), '";s:10:"altVideoId"', 1) SEPARATOR '|') videoIds,
			GROUP_CONCAT(substring_index(SUBSTRING_INDEX(img_metadata, 's:8:"sourceId";', -1), ';s:14:"pageCategories"', 1) SEPARATOR '|') sourceIds,
			substring_index(SUBSTRING_INDEX(img_metadata, 's:2:"hd";', -1), 's:4:"name";', 1) as data, count(*) cnt
		FROM image
		WHERE img_media_type = 'video' and img_minor_mime = 'ooyala' and img_metadata like '%s:8:"provider";s:10:"ooyala/iva";%' $sqlWhere
		GROUP BY data
		HAVING cnt > 1
SQL;

	$result = $db->query( $sql, __METHOD__ );

	$duplicateVideos = array();
	while ( $row = $db->fetchObject( $result ) ) {
		$duplicateVideos[] = array(
			'names' => $row->names,
			'videoIds' => $row->videoIds,
			'sourceIds' => $row->sourceIds,
		);
	}

	return $duplicateVideos;
}

/**
 * Check if the video is embedded to other wikis or not
 * @param DB $db
 * @param string $name
 * @return boolean
 */
function isEmbedded( $db, $name ) {
	$name = $db->addQuotes( $name );

	$sql = <<<SQL
		SELECT 1
		FROM globalimagelinks
		WHERE not exists (SELECT 1 FROM image WHERE img_media_type = 'video' AND img_name = gil_to) AND gil_to = $name
		limit 1;
SQL;

	$result = $db->query( $sql, __METHOD__ );
	$cnt = $result->numRows();

	return empty( $cnt ) ? false : true;
}

/**
 * Get asset by id
 * @param type $videoId
 * @return boolean
 */
function getAssetById( $videoId ) {
	$params = array(
		'include' => 'metadata',
	);

	$method = 'GET';
	$reqPath = '/v2/assets/'.$videoId;

	$url = OoyalaApiWrapper::getApi( $method, $reqPath, $params );
	print( "Connecting to $url...\n" );

	$req = MWHttpRequest::factory( $url );
	$status = $req->execute();
	if ( $status->isGood() ) {
		$result = json_decode( $req->getContent(), true );
		if ( !empty( $result ) ) {
			foreach( explode( "\n", var_export( $result, TRUE ) ) as $line ) {
				print ":: $line\n";
			}
		}
	} else {
		$result = false;
		print( "Error: problem checking video (".$status->getMessage().").\n" );
	}

	return $result;
}


// ----------------------------- Main ------------------------------------

ini_set( "include_path", dirname( __FILE__ )."/../../" );

require_once( "commandLine.inc" );

if ( isset( $options['help'] ) ) {
	die( "Usage: php mapOoyalaMetadata.php [--help] [--dry-run]
	--dry-run            dry run
	--name               video title (optional)
	--help               you are reading it right now\n\n" );
}

if ( empty( $wgCityId ) ) {
	die( "Error: Invalid wiki id.\n" );
}

$dryRun = isset( $options['dry-run'] );
$videoTitle = isset( $options['name'] ) ? $options['name'] : '';

echo "Wiki: $wgCityId ($wgDBname)\n";

$db = wfGetDB( DB_SLAVE );
$ooyala = new OoyalaAsset();

$duplicateVideos = getDuplicateVideos( $db, $videoTitle );

echo "Total duplicate videos: ".count( $duplicateVideos )."\n";

$total = 0;
$all = 0;
$failed = 0;
$skipped = 0;

foreach ( $duplicateVideos as $video ) {
	$total++;

	$names = explode( '|', $video['names'] );
	$videoIds = explode( '|', $video['videoIds'] );
	$sourceIds = explode( '|', $video['sourceIds'] );

	foreach ( $names as $key => $name ) {
		$sourceId = '';
		if ( !empty( $sourceIds[$key] ) ) {
			if ( preg_match( '/s:\d:"(\d+)"/', $sourceIds[$key], $matches ) ) {
				if ( !empty( $matches[1] ) ) {
					$sourceId = $matches[1];
				}
			}
		}

		$videoId = ( empty( $videoIds[$key] ) || strlen( $videoIds[$key] ) != 32 ) ? '' : $videoIds[$key];

		$possibleName = ( $key == 0 ) ? $name.'_2' : rtrim( $name, '_2');
		if ( ( $key == 0 && strtolower( $possibleName ) == strtolower( $names[1] ) )
			|| ( $key == 1 && strtolower( $possibleName ) == strtolower( $names[0] ) )
			|| strtolower( $names[0] ) == strtolower( $names[1] ) ) {
			$isMatched = 'matched';
		} else {
			$isMatched = 'not matched';
		}

		$isEmbedded = 'not embedded';
		if ( $isMatched == 'matched' ) {
			if ( isEmbedded( $db, $name ) ) {
				$isEmbedded = 'embedded';
			}
		}

		echo "Set: ".$total."\t[".( $key + 1 )." of ".count( $names )."]\t$name\t$sourceId\t$videoId\t$possibleName\t$isMatched\t$isEmbedded\n";

		$msg = "\t$name [Id: $videoId]";
		if ( $key != 0 ) {
			$msg .= " (Orig: {$names[0]})";
		}

		if ( $isEmbedded != 'embedded' && $isMatched == 'matched' && !empty( $videoId ) && $key == 1 ) {
			$videoData = getAssetById( $videoId );
			if ( !empty( $videoData ) ) {
				if ( $dryRun ) {
					$resp = true;
				} else {
					$resp = $ooyala->deleteAsset( $videoId );
				}

				if ( $resp ) {
					echo $msg." .... DELETED\n";
				} else {
					echo $msg." .... FAILED\n";
					$failed++;
				}
			}
		} else {
			$msg .= " .... SKIPPED ($isMatched, $isEmbedded";
			if ( empty( $videoId ) ) {
				$msg .= ', Empty videoId';
			}
			echo "$msg)\n";
			$skipped++;
		}

		$all++;
	}

}

echo "\nTotal videos: $total (All=$all), Success: ".( $all - $failed - $skipped ).", Failed: $failed, Skipped: $skipped \n\n";
