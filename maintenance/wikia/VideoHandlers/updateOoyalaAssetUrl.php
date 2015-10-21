<?php

/**
* Maintenance script to update Remote Asset Url for Ooyala
* This is one time use script
* @author Saipetch Kongkatong
*/

/**
 * Compare metadata
 * @param array $oldMeta
 * @param array $newMeta
 */
function compareMetadata( $oldMeta, $newMeta ) {
	$fields = array_unique( array_merge( array_keys( $newMeta ), array_keys( $oldMeta ) ) );
	foreach ( $fields as $field ) {
		if ( ( !isset( $newMeta[$field] ) || is_null( $newMeta[$field] ) ) && isset( $oldMeta[$field] ) ) {
			echo "\t\t[DELETED] $field: ".$oldMeta[$field]."\n";
		} elseif ( isset( $newMeta[$field] ) && !isset( $oldMeta[$field] ) ) {
			echo "\t\t[NEW] $field: $newMeta[$field]\n";
		} elseif ( strcasecmp( $oldMeta[$field], $newMeta[$field] ) == 0 ) {
			echo "\t\t$field: $newMeta[$field]\n";
		} else {
			echo "\t\t[UPDATED]$field: $newMeta[$field] (Old value: ".$oldMeta[$field].")\n";
		}
	}
}

/**
 * Update asset urls for remote asset
 * @param $ingester
 * @param array $video
 */
function updateRemoteAssetUrls( $ingester, $source, $video ) {
	global $dryRun, $skipped, $failed;

	if ( empty( $video['metadata']['sourceid'] ) ) {
		echo "\tSKIP: $video[name] (Id: $video[embed_code]) - Empty source id.\n";
		$skipped++;
		return;
	}

	if ( $video['metadata']['source'] != $source ) {
		echo "\tSKIP: $video[name] (Id: $video[embed_code]) - Invalid source (source=".$video['metadata']['source'].").\n";
		$skipped++;
		return;
	}

	if ( !empty( $video['metadata']['updateAssetUrls'] ) && $video['metadata']['updateAssetUrls'] == 9 ) {
		echo "\tSKIP: $video[name] (Id: $video[embed_code]) - Already updated.\n";
		$skipped++;
		return;
	}

	if ( $video['asset_type'] != 'remote_asset' ) {
		echo "\tSKIP: $video[name] (Id: $video[embed_code]) - Invalid asset_type (source=$video[asset_type]).\n";
		$skipped++;
		return;
	}

	$video['videoId'] = $video['metadata']['sourceid'];
	$ingester->setVideoData( $video );
	$urls = $ingester->getRemoteAssetUrls();

	// for debugging
	echo "\n\tNEW URLs (".$video['embed_code']."):\n";
	foreach ( $video['stream_urls'] as $key => &$value ) {
		if ( is_null( $value ) ) {
			unset( $video['stream_urls'][$key] );
		}
	}
	compareMetadata( $video['stream_urls'], $urls );
	echo "\n";

	$resp = true;
	if ( !$dryRun ) {
		$resp = OoyalaAsset::updateRemoteAssetUrls( $video['embed_code'], $urls );
		if ( $resp ) {
			$metadata = [ 'updateAssetUrls' => 9 ];
			$resp = OoyalaAsset::updateMetadata( $video['embed_code'], $metadata );
			if ( !$resp ) {
				"ERROR: $video[name] (Id: $video[embed_code]) - Cannot set updateAssetUrls to 9 in metadata.\n";
			}
		} else {
			$failed++;
		}
	}

	if ( $resp ) {
		echo "\tUPDATED: $video[name] (Id: $video[embed_code]) ... DONE.\n";
	}
}

// ----------------------------- Main ------------------------------------

ini_set( "include_path", dirname( __FILE__ )."/../../" );
ini_set( 'display_errors', 1 );

require_once( "commandLine.inc" );

if ( isset( $options['help'] ) ) {
	die( "Usage: php updateOoyalaAssetUrl.php [--help] [--dry-run] [extra=abc] [limit=1234] [source=xyz]
	--extra            extra conditions to get video assets (use ' AND ' to separate each condition)
	--limit            limit. Default: 50000
	--source           provider. Default: iva
	--dry-run          dry run
	--help             you are reading it right now\n\n" );
}

$dryRun = isset( $options['dry-run'] );
$extra = isset( $options['extra'] ) ? explode( ' AND ', $options['extra'] ) : array();
$limit = empty( $options['limit'] ) ? 50000 : $options['limit'];
$source = empty( $options['source'] ) ? 'iva' : $options['source'];

$sources = [ 'iva', 'screenplay' ];
if ( !in_array( $source, $sources ) ) {
	die( "Invalid source.\n" );
}

$apiPageSize = 500;
if ( !empty( $limit ) && $limit < $apiPageSize ) {
	$apiPageSize = $limit;
}

$ingester = FeedIngesterFactory::getIngester( $source );

$nextPage = '';
$page = 1;
$total = 0;
$failed = 0;
$skipped = 0;

do {
	// connect to provider API
	$url = OoyalaAsset::getApiUrlAssets( $apiPageSize, $nextPage, $extra );
	echo "\nConnecting to $url...\n" ;

	$response = OoyalaAsset::getApiContent( $url );
	if ( $response === false ) {
		exit();
	}

	$videos = empty( $response['items'] ) ? array() : $response['items'] ;
	$nextPage = empty( $response['next_page'] ) ? '' : $response['next_page'] ;

	$total += count( $videos );

	$cnt = 0;
	foreach ( $videos as $video ) {
		$newValues = false;
		$cnt++;
		$title = trim( $video['name'] );
		echo "[Page $page: $cnt of $total] Video: $title ({$video['embed_code']})\n";
		echo "\tMetadata for {$video['embed_code']} [$title]: \n";
		foreach( explode( "\n", var_export( $video['metadata'], TRUE ) ) as $line ) {
			echo "\t\t:: $line\n";
		}

		echo "\tAsset URLs for {$video['embed_code']} [$title]: \n";
		foreach( explode( "\n", var_export( $video['stream_urls'], TRUE ) ) as $line ) {
			echo "\t\t:: $line\n";
		}

		updateRemoteAssetUrls( $ingester, $source, $video );
	}
	$page++;
} while ( !empty( $nextPage ) && $total < $limit );

echo "\nTotal videos: ".$total.", Success: ".( $total - $failed - $skipped ).", Failed: $failed, Skipped: $skipped\n\n";
