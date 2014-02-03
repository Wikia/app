<?php

/**
* Maintenance script to update Thumbnail on ooyala and video wiki for IVA videos
* This is one time use script
* @author Saipetch Kongkatong
*/

/**
 * Get thumbnail from IVA
 * @global integer $failed
 * @global string $msg
 * @param string $sourceId
 * @return string|false $thumbnail
 */
function getVideoThumbnailIva( $sourceId ) {
	global $failed, $msg;
	$apiUrl = 'http://api.internetvideoarchive.com/1.0/DataService/VideoAssets($1)?$expand=$2&developerid=$3&$format=json';

	$expand = array(
		'VideoAssetScreenCapture',
	);

	$url = str_replace( '$1', $sourceId, $apiUrl );
	$url = str_replace( '$2', implode( ',', $expand ), $url );
	$url = str_replace( '$3', F::app()->wg->IvaApiConfig['DeveloperId'], $url );


	print( "Connecting to $url...\n" );

	$resp = Http::request( 'GET', $url, array( 'noProxy' => true ) );
	if ( $resp === false ) {
		$failed++;
		print( "$msg...FAILED (Error: Problem getting thumbnail from IVA. url:$url).\n" );
		return false;
	}

	// parse response
	$response = json_decode( $resp, true );
	if ( empty( $response['d']['VideoAssetScreenCapture']['URL'] ) ) {
		$thumbnail = '';
	} else {
		$thumbnail = $response['d']['VideoAssetScreenCapture']['URL'];
	}

	return $thumbnail;
}

/**
 * Update thumbnail in the wiki
 * @global integer $failed
 * @global boolean $dryRun
 * @global string $msg
 * @param string $videoTitle - video title on the wiki
 * @param string $thumbnailUrl
 * @return boolean
 */
function updateThumbnailWiki( $videoTitle, $thumbnailUrl ) {
	global $failed, $dryRun, $msg;

	$title = $videoTitle;
	$file = WikiaFileHelper::getVideoFileFromTitle( $title );
	if ( empty( $file ) ) {
		$failed++;
		print( "$msg...FAILED (Error: File not found in the wiki. Title: $videoTitle).\n" );
		return false;
	}

	$helper = new VideoHandlerHelper();
	if ( !$dryRun ) {
		$status = $helper->resetVideoThumb( $file, $thumbnailUrl );
		if ( !$status->isGood() ) {
			$failed++;
			print( "$msg...FAILED (Error: Cannot reset video thumbnail in the wiki. Title: $videoTitle).\n" );
			return false;
		}
	}

	return true;
}

/**
 * Remove thumbnail field from Custom Metadata
 * @global integer $skipped
 * @global integer $failed
 * @global boolean $dryRun
 * @global string $msg
 * @param array $video
 * @return boolean
 */
function removeThumbnailFromMetadata( $video ) {
	global $failed, $dryRun, $msg;

	if ( !$dryRun ) {
		$metadata = array( 'thumbnail' => null );
		$resp = OoyalaAsset::updateMetadata( $video['embed_code'], $metadata );
		if ( !$resp ) {
			$failed++;
			echo "$msg...FAILED (Error: Cannot remove thumbnail field from Custom Metadata).\n";
			return false;
		}
	}

	return true;
}


// ----------------------------- Main ------------------------------------

ini_set( "include_path", dirname( __FILE__ )."/../../" );
ini_set( 'display_errors', 1 );

require_once( "commandLine.inc" );

if ( isset( $options['help'] ) ) {
	die( "Usage: php updateOoyalaThumbnail.php [--help] [--dry-run] [extra=abc]
	--extra              extra conditions to get video assets from ooyala
	--dry-run            dry run
	--help               you are reading it right now\n\n" );
}

$dryRun = isset( $options['dry-run'] );
$extra = isset( $options['extra'] ) ? $options['extra'] : '';

$ooyala = new OoyalaAsset();

$extraCond = [
	"asset_type='remote_asset'",
	"metadata.source='iva'",
	"metadata.thumbnail='1'",
];

if ( !empty( $extra ) ) {
	$extraCond[] = $extra;
}

$provider = 'ooyala';
$apiPageSize = 100;
$nextPage = '';
$page = 1;
$total = 0;
$failed = 0;
$skipped = 0;

do {
	// connect to provider API
	$url = OoyalaAsset::getApiUrlAssets( $apiPageSize, $nextPage, $extraCond );
	echo "\nConnecting to $url...\n" ;

	$response = OoyalaAsset::getApiContent( $url );
	if ( $response === false ) {
		exit();
	}

	$videos = empty( $response['items'] ) ? array() : $response['items'];
	$nextPage = empty( $response['next_page'] ) ? '' : $response['next_page'];

	$total += count( $videos );

	$cnt = 0;
	foreach ( $videos as $video ) {
		$cnt++;
		$videoTitle = trim( $video['name'] );
		$msg = "[Page $page: $cnt of $total] Video: $videoTitle ({$video['embed_code']})";

		if ( empty( $video['metadata']['sourceid'] ) ) {
			$skipped++;
			echo "$msg...SKIPPED (Empty sourceid).\n";
			continue;
		}

		if ( !empty( $video['preview_image_url'] ) ) {
			$skipped++;
			echo "$msg...SKIPPED (Thumbnail url already exists).\n";
			continue;
		}

		// get wiki title
		$duplicates = WikiaFileHelper::findVideoDuplicates( $provider, $video['embed_code'] );
		if ( count( $duplicates ) < 1 ) {
			$skipped++;
			echo "$msg...SKIPPED (Cannot find the file).\n";
			continue;
		}

		$wikiVideoTitle = $duplicates[0]['img_name'];

		// get thumbnail from IVA
		$resp = getVideoThumbnailIva( $video['metadata']['sourceid'] );
		if ( $resp === false ) {
			continue;
		}

		$data['thumbnail'] = $resp;

		if ( empty( $data['thumbnail'] ) ) {
			$skipped++;
			echo "$msg...SKIPPED (No thumbnail found).\n";
			continue;
		}

		echo "$msg\n";
		echo "\tMetadata for {$video['embed_code']}: \n";
		foreach( explode( "\n", var_export( $video['metadata'], TRUE ) ) as $line ) {
			echo "\t\t:: $line\n";
		}

		// set thumbnail to Ooyala
		if ( !$dryRun ) {
			$resp = $ooyala->setThumbnail( $video['embed_code'], $data );
			if ( !$resp ) {
				$failed++;
				print( "$msg...FAILED (Error: Cannot setting thumbnail for $videoTitle. Embed code:$video[embed_code]).\n" );
				continue;
			}
		}

		// update thumbnail on the wiki
		if ( !updateThumbnailWiki( $wikiVideoTitle, $data['$thumbnail'] ) ) {
			continue;
		}

		// remove thumbnail field from ooyala
		if ( !removeThumbnailFromMetadata( $video ) ) {
			continue;
		}
	}

	$page++;
} while( !empty( $nextPage ) );

echo "\nTotal videos: ".$total.", Success: ".( $total - $failed - $skipped ).", Failed: $failed, Skipped: $skipped\n\n";
