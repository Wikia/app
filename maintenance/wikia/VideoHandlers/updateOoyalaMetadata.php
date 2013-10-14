<?php

/**
* Maintenance script to update Metadata for Ooyala
* This is one time use script
* @author Saipetch Kongkatong
*/

/**
 * Constructs a URL to get assets from Ooyala API
 * @param integer $apiPageSize
 * @param integer $nextPage
 * @param string $extra
 * @return string $url
 */
function getApiAssets( $apiPageSize, $nextPage, $extra ) {
	$cond = array(
		"status = 'live'",
	);

	if ( !empty( $extra ) ) {
		$cond[] = $extra;
	}

	$params = array(
		'limit' => $apiPageSize,
		'where' => implode( ' AND ', $cond ),
	);

	if ( !empty($nextPage) ) {
		$parsed = explode( "?", $nextPage );
		parse_str( array_pop($parsed), $params );
	}

	$method = 'GET';
	$reqPath = '/v2/assets';
	$url = OoyalaApiWrapper::getApi( $method, $reqPath, $params );

	return $url;
}

/**
 * Send request to Ooyala to update metadata
 * @param string $videoId
 * @param array $metadata
 * @return boolean $resp
 */
function updateMetadata( $videoId, $metadata ) {
	$method = 'PATCH';
	$reqPath = '/v2/assets/'.$videoId.'/metadata';

	$reqBody = json_encode( $metadata );

	$url = OoyalaApiWrapper::getApi( $method, $reqPath, array(), $reqBody );
	echo "\tRequest to update metadata: $url\n";

	$options = array(
		'method' => $method,
		'postData' => $reqBody,
	);

	$req = MWHttpRequest::factory( $url, $options );
	$status = $req->execute();
	if ( $status->isGood() ) {
		$meta = json_decode( $req->getContent(), true );
		$resp = true;

		echo "\tUpdated Metadata for $videoId: \n";
		foreach( explode( "\n", var_export( $meta, TRUE ) ) as $line ) {
			echo "\t\t:: $line\n";
		}
	} else {
		$resp = false;
		echo "\tERROR: problem adding metadata (".$status->getMessage().").\n";
	}

	return $resp;
}

/**
 * remove field from Custom Metadata if the field is empty
 * @global integer $skipped
 * @global integer $failed
 * @global boolean $dryRun
 * @param array $video
 * @param string $title
 * @param string $removedField
 * @return type
 */
function removeCustomMetadata( $video, $title, $removedField ) {
	global $skipped, $failed, $dryRun;

	$metadata = array( $removedField => null );
	if ( !array_key_exists( $removedField, $video['metadata'] ) ) {
		echo "\tSKIP: $title - $removedField not found in Custom Metadata.\n";
		$skipped++;
		return;
	}

	if ( !empty( $video['metadata'][$removedField] ) ) {
		echo "\tSKIP: $title - $removedField field not empty in Custom Metadata. (value: {$video['metadata'][$removedField]}).\n";
		$skipped++;
		return;
	}

	if ( !$dryRun ) {
		$resp = updateMetadata( $video['embed_code'], $metadata );
		if ( !$resp ) {
			$failed++;
		}
	}

	return;
}

/**
 * add age_required field to Custom Metadata
 * @global integer $skipped
 * @global integer $failed
 * @global boolean $dryRun
 * @param array $video
 * @param string $title
 * @param integer $ageRequired
 * @return type
 */
function addAgeRequired( $video, $title, $ageRequired ) {
	global $skipped, $failed, $dryRun;

	$metadata = array( 'age_required' => $ageRequired );

	if ( empty( $video['metadata']['agegate'] ) ) {
		echo "\tSKIP: $title - agegate not found in Custom Metadata.\n";
		$skipped++;
		return;
	}

	if ( !empty( $video['metadata']['age_required'] ) ) {
		echo "\tSKIP: $title - age_required is set in Custom Metadata (age_required: {$video['metadata']['age_required']}).\n";
		$skipped++;
		return;
	}

	if ( !$dryRun ) {
		$resp = updateMetadata( $video['embed_code'], $metadata );
		if ( !$resp ) {
			$failed++;
		}
	}

	return;
}

/**
 * set player id
 * @global integer $skipped
 * @global integer $failed
 * @global boolean $dryRun
 * @param array $video
 * @param string $title
 * @param string $playerId
 * @return type
 */
function setPlayerId( $video, $title, $playerId ) {
	global $skipped, $failed, $dryRun;

	$ooyala = new OoyalaAsset();
	$player = $ooyala->getPlayer( $video['embed_code'] );
	if ( $player == false ) {
		$failed++;
		return;
	}

	echo "\tPlayer: $player[name] (ID: $player[id]).\n";
	if ( $player['id'] == $playerId ) {
		echo "\tSKIP: $title already uses the same player.\n";
		$skipped++;
		return;
	}

	if ( !$dryRun ) {
		$resp = $ooyala->setPlayer( $video['embed_code'], $playerId );
		if ( !$resp ) {
			$failed++;
		}
	}

	return;
}

// ----------------------------- Main ------------------------------------

ini_set( "include_path", dirname( __FILE__ )."/../../" );
ini_set( 'display_errors', 1 );

require_once( "commandLine.inc" );

if ( isset( $options['help'] ) ) {
	die( "Usage: php maintenance.php [--help] [--age=123] [--dry-run] [--player=xyz] [extra=abc] [--remove=age_required]
	--age                          set age_required value in metadata
	--player                       set player id
	--remove                       remove field from custom metadata (only if the field is empty)
	--extra                        extra conditions to get video assets from ooyala
	--dry-run                      dry run
	--help                         you are reading it right now\n\n" );
}

$dryRun = isset( $options['dry-run'] );
$ageRequired = isset( $options['age'] ) ? $options['age'] : 0;
$playerId = isset( $options['player'] ) ? $options['player'] : '';
$extra = isset( $options['extra'] ) ? $options['extra'] : '';
$remove = isset( $options['remove'] ) ? $options['remove'] : '';

if ( !is_numeric( $ageRequired ) ) {
	die( "Invalid age.\n" );
}

$apiPageSize = 100;
$nextPage = '';
$page = 1;
$total = 0;
$failed = 0;
$skipped = 0;

// set condition to get age gated videos
if ( !empty( $ageRequired ) ) {
	if ( !empty( $extra ) ) {
		$extra .= ' AND ';
	}
	$extra .= "labels INCLUDES 'Age gated'";
}

do {
	// connect to provider API
	$url = getApiAssets( $apiPageSize, $nextPage, $extra );
	echo "\nConnecting to $url...\n" ;

	$req = MWHttpRequest::factory( $url );
	$status = $req->execute();
	if ( $status->isGood() ) {
		$response = $req->getContent();
	} else {
		die ( "ERROR: problem downloading content (".$status->getMessage().").\n" );
	}

	// parse response
	$response = json_decode( $response, true );

	$videos = empty($response['items']) ? array() : $response['items'] ;
	$nextPage = empty($response['next_page']) ? '' : $response['next_page'] ;

	$total += count( $videos );

	$cnt = 0;
	foreach( $videos as $video ) {
		$cnt++;
		$title = trim( $video['name'] );
		echo "[Page $page: $cnt of $total] Video: $title ({$video['embed_code']})\n";
		echo "\tMetadata for {$video['embed_code']}: \n";
		foreach( explode( "\n", var_export( $video['metadata'], TRUE ) ) as $line ) {
			echo "\t\t:: $line\n";
		}

		if ( !empty( $ageRequired ) ) {
			addAgeRequired( $video, $title, $ageRequired );
		}

		if ( !empty( $playerId ) ) {
			setPlayerId( $video, $title, $playerId );
		}

		if ( !empty( $remove ) ) {
			 removeCustomMetadata( $video, $title, $remove );
		}
	}

	$page++;
} while( !empty( $nextPage ) );

echo "\nTotal videos: ".$total.", Success: ".( $total - $failed - $skipped ).", Failed: $failed, Skipped: $skipped\n\n";
