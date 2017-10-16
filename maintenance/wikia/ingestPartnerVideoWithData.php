<?php
/**
 * ingestPartnerVideoWithData.php
 *
 * Ingest video from all premium partners using WikiFactory data
 *
 * @author William Lee (wlee@wikia-inc.com)
 * @author Saipetch Kongkatong
 * @author Garth Webb
 */

ini_set( 'display_errors', 'stdout' );

// This global array is used by commandLine.inc included below. Without this line,
// arguments passed to this script are not processed correctly.
$optionsWithArgs = [ 's', 'e' ];

ini_set( "include_path", dirname(__FILE__)."/.." );
require_once( 'commandLine.inc' );

use \Wikia\Logger\WikiaLogger;

// commandLine.inc transforms -h and --help into 'help'
if ( isset( $options['help'] ) ) {
	print <<<EOT
Import video from a partner

Usage: php ingestPartnerVideoWithData.php [options...] <partner>

Options:
  -s <date>         Start date for searching videos by date (Unix timestamp)
  -e <date>         End date for searching videos by date (Unix timestamp)
  -d                Debug mode
  -r				Reingest videos (overwrite existing)
  -a				get all videos
  --ra				use ooyala remote asset to ingest video
  --summary			show summary information

Args:
  provider          Partner to import video from. Int defined in VideoPage.php.
                    If none is specified, script will ingest content from all supported premium providers.


EOT;
	exit( 1 );
}

// Calculate default date range - start: yesterday, end: tomorrow
$di = new DateInterval( 'P1D' );
$defaultStart = date_create();
$defaultEnd   = date_create();
date_add( $defaultEnd, $di );
date_sub( $defaultStart, $di );

// Read input parameters
$endDateTS    = isset( $options['e'] ) ? $options['e'] : date_timestamp_get( $defaultEnd );
$startDateTS  = isset( $options['s'] ) ? $options['s'] : date_timestamp_get( $defaultStart );
$getAllVideos = isset( $options['a'] );
$remoteAsset  = isset( $options['ra'] );
$showSummary  = isset( $options['summary'] );
$provider     = empty( $args[0] ) ? '' : strtolower( $args[0] );

$ingesterParams = [
	'debug' => isset( $options['d'] ),
	'reupload' => isset( $options['r'] ),
];

// check if allow to upload file
if ( $wgEnableUploads === false ) {
	die( "File upload is disabled.\n" );
}

// check for read only mode
if ( wfReadOnly() ) {
	die( "Read only mode.\n" );
}

// Make it clear when we're in debug mode
if ( $ingesterParams['debug'] ) {
	echo( "== DEBUG MODE ==\n" );
}

// Populate $wgUser with Wikia Video Library
loadUser( 'Wikia Video Library' );

// Determine which providers to pull from
$providersVideoFeed = loadProviders( $provider );

// Loop through each provider and ingest video metadata
foreach ( $providersVideoFeed as $provider ) {
	print( "Starting import for provider $provider...\n" );

	/** @var VideoFeedIngester $feedIngester */
	$feedIngester = FeedIngesterFactory::getIngester( $provider, $ingesterParams );

	// get WikiFactory data
	$ingestionData = $feedIngester->getWikiIngestionData();
	if ( empty( $ingestionData ) ) {
		die( "No ingestion data found in wikicities. Aborting." );
	}

	// When necessary download a list of resources into $file and reformat
	// the start and end date for each provider
	$file = '';
	$startDate = $endDate = '';
	switch ( $provider ) {
		case FeedIngesterFactory::PROVIDER_SCREENPLAY:
			// no file needed
			$startDate = date( 'm/d/y', $startDateTS );
			$endDate = date( 'm/d/y', $endDateTS );
			break;
		case FeedIngesterFactory::PROVIDER_IGN:
			$startDate = date( 'Y-m-d', $startDateTS ).'T00:00:00-0800';
			$endDate = date( 'Y-m-d', $endDateTS ).'T00:00:00-0800';
			$file = $feedIngester->downloadFeed( $startDate, $endDate );
			break;
		case FeedIngesterFactory::PROVIDER_ANYCLIP:
			$file = $feedIngester->downloadFeed( $getAllVideos );
			break;
		case FeedIngesterFactory::PROVIDER_OOYALA:
			// no file needed
			$startDate = date( 'Y-m-d', $startDateTS ).'T00:00:00Z';
			$endDate = date( 'Y-m-d', $endDateTS ).'T00:00:00Z';
			break;
		case FeedIngesterFactory::PROVIDER_IVA:
			// no file needed
			$startDate = date( 'Y-m-d', $startDateTS );
			$endDate = date( 'Y-m-d', $endDateTS );
			break;
		case FeedIngesterFactory::PROVIDER_CRUNCHYROLL:
			// No file needed
			break;
		case FeedIngesterFactory::PROVIDER_MAKER_STUDIOS:
			$file = $feedIngester->downloadFeed();
			break;
		default:
	}

	$importParams = [
		'startDate'    => $startDate,
		'endDate'      => $endDate,
	];

	if ( !empty( $ingestionData['keyphrases'] ) ) {
		$importParams['keyphrasesCategories'] = $ingestionData['keyphrases'];
	}

	$numCreated = $feedIngester->import( $file, $importParams );

	$summary[$provider] = $feedIngester->getResultSummary();

	// show ingested videos by vertical
	displaySummary( $showSummary, getContentIngestedVideosByCategory( $feedIngester, $provider ), 'vertical' );

	print "\nCreated $numCreated articles!\n\n";
}

// show summary
displaySummary( $showSummary, getContentSummary( $summary ) );


function loadUser( $userName ) {
	global $wgUser;

	$wgUser = User::newFromName( $userName );
	if ( !$wgUser ) {
		die("Invalid username\n");
	}
	$wgUser->load();
}

function loadProviders ( $provider ) {

	if ( empty( $provider ) ) {
		// If no provider was specified, assume all active providers
		$providersVideoFeed = FeedIngesterFactory::getActiveProviders();
	} elseif ( array_search( $provider, FeedIngesterFactory::getAllProviders() ) !== false ) {
		// If a provider was specified, check it against the list of legal providers
		$providersVideoFeed = [ $provider ];
	} else {
		// If a provider was given but was not found, die.
		die( "unknown provider $provider. aborting.\n" );
	}

	return $providersVideoFeed;
}

function getContentSummary( $summary ) {
	$log = WikiaLogger::instance();

	$width = 20;
	$now = date( 'Y-m-d H:i:s' );
	$content = "Run Date: $now\n";

	// get header
	$keys = array_keys( current( $summary ) );
	$content .= sprintf( "%-{$width}s", 'Provider' );
	foreach( $keys as $field ) {
		$content .= sprintf( "%{$width}s", ucwords( $field ) );
	}
	$content .= "\n";

	// Create the summary body
	$totals = array_fill_keys( $keys, 0 );
	foreach ( $summary as $provider => $result ) {
		$content .= sprintf( "%-{$width}s", strtoupper( $provider ) );
		foreach ( $result as $key => $value ) {
			$totals[$key] += $value;
			$content .= sprintf( "%{$width}s", $value );
		}
		$content .= "\n";

		// Make provider data available to kibana
		$result['provider'] = $provider;
		$log->info( "Video ingestion complete: $provider", $result );
	}

	// Write the totals line
	$content .= sprintf( "%-{$width}s", 'TOTAL' );
	foreach ( $totals as $key => $value ) {
		$content .= sprintf( "%{$width}s", $value );
	}
	$content .= "\n";

	// Make the summary data available to kibana
	$log->info("Video ingestion totals", $totals);

	return $content;
}

/**
 * @param VideoFeedIngester $feedIngester
 * @param string $provider
 * @return string
 */
function getContentIngestedVideosByCategory( $feedIngester, $provider ) {
	$content = "\n\nProvider: ".strtoupper( $provider )."\n";
	foreach ( $feedIngester->getResultIngestedVideos() as $category => $msgs ) {
		$content .= "\nCategory: $category\n";
		if ( !empty( $msgs ) ) {
			$content .= implode( '', $msgs );
			$content .= "\n";
		}
	}

	return $content;
}

function displaySummary( $showSummary, $content, $type = 'summary' ) {
	if ( empty( $showSummary ) ) {
		echo $content;
	} else {
		$fileVertical = '/tmp/ingestion_vertical';
		if ( $type == 'summary' ) {
			// write summary to file
			$filename = '/tmp/ingestion_summary';
			file_put_contents( $filename, $content );

			// write ingested videos by vertical to file
			$content = file_get_contents( $fileVertical );
			file_put_contents( $filename, $content, FILE_APPEND );

			// delete vertical file
			unlink( $fileVertical );
		} else {
			file_put_contents( $fileVertical, $content, FILE_APPEND );
		}
	}
}
