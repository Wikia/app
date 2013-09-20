<?php

/**
* Maintenance script to delete video for Ooyala
* This is one time use script
* @author Saipetch Kongkatong
*/

/**
 * Constructs a URL to get live remote assets from Ooyala API
 * @param integer $apiPageSize
 * @param integer $page
 * @param string $provider
 * @param string $keyword
 * @return string $url
 */
function getApiAssets( $apiPageSize, $page, $provider, $keyword ) {
	$cond = array(
		"status = 'live'",
		"asset_type = 'remote_asset'",
		"metadata.source = '$provider'",
	);

	if ( !empty( $keyword ) ) {
		$cond[] = "metadata.keywords = '$keyword'";
	}

	$params = array(
		'limit' => $apiPageSize,
		'where' => implode( ' AND ', $cond ),
	);

	if ( !empty( $page ) ) {
		$parsed = explode( "?", $page );
		parse_str( array_pop($parsed), $params );
	}

	$method = 'GET';
	$reqPath = '/v2/assets';
	$url = OoyalaApiWrapper::getApi( $method, $reqPath, $params );

	return $url;
}

// ----------------------------- Main ------------------------------------

ini_set( "include_path", dirname( __FILE__ )."/../../" );
ini_set( 'display_errors', 1 );

require_once( "commandLine.inc" );

if ( isset( $options['help'] ) ) {
	die( "Usage: php deleteOoyalaVideo.php [--help] [--keyword=xyz] [--provider=xyz] [--dry-run]
	--keyword                      case sensitive keyword in metadata (required)
	--provider                     provider name set in source field in metadata (required)
	--dry-run                      dry run
	--help                         you are reading it right now\n\n" );
}

$dryRun = isset( $options['dry-run'] );
$provider = isset( $options['provider'] ) ? $options['provider'] : '';
$keyword = isset( $options['keyword'] ) ? $options['keyword'] : '';

if ( empty( $provider ) ) {
	die( "ERROR: Invalid provider.\n" );
}

if ( empty( $keyword ) ) {
	die( "ERROR: Invalid keyword.\n" );
}

$apiPageSize = 100;
$nextPage = '';
$page = 1;
$total = 0;
$failed = 0;
$skipped = 0;

$ooyala = new OoyalaAsset();

do {
	// connect to provider API
	$url = getApiAssets( $apiPageSize, $nextPage, $provider, $keyword );
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

		if ( empty( $video['metadata']['source'] ) ) {
			echo "\tSKIP: $title - source not found in Custom Metadata.\n";
			$skipped++;
			continue;
		}

		if ( $video['metadata']['source'] != 'iva' ) {
			echo "\tSKIP: $title - source not IVA in Custom Metadata.\n";
			$skipped++;
			continue;
		}

		if ( empty( $video['metadata']['keywords'] ) ) {
			echo "\tSKIP: $title - keywords not found in Custom Metadata.\n";
			$skipped++;
			continue;
		}

		$keywords = explode(',', $video['metadata']['keywords'] );
		if ( !in_array( $keyword, $keywords ) ) {
			echo "\tSKIP: $title - '$keyword' not found in keywords set in Custom Metadata.\n";
			$skipped++;
			continue;
		}

		if ( !$dryRun ) {
			$resp = $ooyala->deleteAsset( $video['embed_code'] );
			if ( !$resp ) {
				$failed++;
			}
		}
	}

	$page++;
} while( !empty( $nextPage ) );

echo "\nTotal videos: ".$total.", Success: ".( $total - $failed - $skipped ).", Failed: $failed, Skipped: $skipped\n\n";
