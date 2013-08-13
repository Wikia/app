<?php

/**
* Maintenance script to map video metadata by provider
* This is one time use script
* @author Saipetch Kongkatong
*/

/**
 * map metadata
 * @global int $skip
 * @global array $categories
 * @param string $videoTitle
 * @param VideoFeedIngester $ingester
 * @param array $data
 * @return array|false $metadata
 */
function mapMetadata( $videoTitle, $ingester, $data ) {
	global $skip, $categories;

	// default page categories
	if ( empty( $data['pageCategories'] ) ) {
		$pageCategories = array();
	} else {
		$pageCategories = array_map( 'trim', explode( ',', $data['pageCategories'] ) );
	}

	// get name
	if ( empty( $data['name'] ) && !empty( $data['keywords'] ) ) {
		$keywords = array();
		foreach ( explode( ',' , $data['keywords'] ) as $key => $keyword ) {
			$keyword = trim( $keyword );
			$keywords[] = $keyword;

			// remove page categories from keywords (for ooyala, iva)
			foreach ( $categories as $category) {
				if ( strcasecmp( $keyword, $category ) == 0 ) {
					array_pop( $keywords );
					if ( !in_array( $category, $pageCategories ) ) {
						$pageCategories[] = $category;
					}
					break;
				}
			}
		}

		if ( count($keywords) == 1 ) {
			$data['name'] = array_pop( $keywords );
		} else {
			$skip++;
			echo "$videoTitle...SKIPPED. (cannot map keywords to name (Keywords: $data[keywords])).\n";
			return false;
		}
	}

	// get page categories
	if ( !empty( $pageCategories ) ) {
		$data['pageCategories'] = implode( ', ', $ingester->getUniqueArray( $pageCategories ) );
	}

	// get keywords
	if ( !empty( $data['tags'] ) ) {
		if ( !empty( $keywords ) ) {
			$tags = array_map( 'trim', explode( ',', $data['tags'] ) );
			$keywords = array_merge( $keywords, $tags );
			$data['keywords'] = implode( ', ', $keywords );
		} else {
			$data['keywords'] = preg_replace( '/,([^\s])/', ', $1', $data['tags'] );
		}
	} else {
		$data['keywords'] = '';
	}

	// get rating
	if ( !empty( $data['trailerRating'] ) && strcasecmp( $data['trailerRating'], 'not rated') != 0 && strcasecmp( $data['trailerRating'], 'nr') != 0 ) {
		$data['industryRating'] = $ingester->getIndustryRating( $data['trailerRating'] );
	} else if ( !empty( $data['industryRating'] ) ) {
		$data['industryRating'] = $ingester->getIndustryRating( $data['industryRating'] );
	}

	// get age required
	if ( empty( $data['ageRequired'] ) && !empty( $data['ageGate'] ) && is_numeric( $data['ageGate'] ) ) {
		if ( $data['ageGate'] > 10 ) {
			$data['ageRequired'] = $data['ageGate'];
		} else if ( !empty( $data['industryRating'] ) ) {
			$data['ageRequired'] = $ingester->getAgeRequired( $data['industryRating'] );
		} else {
			$data['ageRequired'] = 18;	// default value for age required
		}
	}

	// get age gate
	$data['ageGate'] = empty( $data['ageRequired'] ) ? 0 : 1;

	// get language
	if ( !empty( $data['language'] ) ) {
		$data['language'] = $ingester->getCldrCode( $data['language'] );
	}

	// get subtitle
	if ( !empty( $data['subtitle'] ) ) {
		$data['subtitle'] = $ingester->getCldrCode( $data['subtitle'] );
	}

	// get country code
	if ( !empty( $data['targetCountry'] ) ) {
		$data['targetCountry'] = $ingester->getCldrCode( $data['targetCountry'], 'country' );
	}

	$errorMsg = '';
	$metadata = $ingester->generateMetadata( $data, $errorMsg );
	if ( !empty( $errorMsg ) ) {
			$skip++;
			echo "$videoTitle...SKIPPED. ($errorMsg).\n";
			return false;
	}

	// add required fields
	$metadata['title'] = $data['title'];
	$metadata['canEmbed'] = $data['canEmbed'];

	return $metadata;
}

// ----------------------------- Main ------------------------------------

ini_set( "include_path", dirname( __FILE__ )."/../../" );

require_once( "commandLine.inc" );

if ( isset($options['help']) ) {
	die( "Usage: php mapVideoMatadata.php [--help] [--dry-run] [--provider=abc] [--limit=123]
	--dry-run                      dry run
	--provider                     video provider
	--limit                        limit number of videos
	--help                         you are reading it right now\n\n" );
}

if ( empty($wgCityId) ) {
	die( "Error: Invalid wiki id.\n" );
}

$dryRun = isset( $options['dry-run'] );
$provider = isset( $options['provider'] ) ? $options['provider'] : '';
$limit = isset( $options['limit'] ) ? $options['limit'] : 0 ;

if ( empty( $provider ) ) {
	die( "Error: Invalid provider.\n" );
}

if ( !is_numeric( $limit ) ) {
	die( "Error: Invalid limit.\n" );
}

echo "Wiki: $wgCityId ($wgDBname)\n";

$ingester = VideoFeedIngester::getInstance( $provider );
// get WikiFactory data
$ingestionData = $ingester->getWikiIngestionData();
if ( empty( $ingestionData ) ) {
	die( "No ingestion data found in wikicities. Aborting.\n" );
}

// keywords for page categories
$categories = array( 'International', 'Foreign', 'Movies', 'TV', 'Gaming' );

$dbw = wfGetDB( DB_MASTER );

$result = $dbw->select(
	array( 'image' ),
	array( 'img_name', 'img_metadata' ),
	array(
		'img_media_type' => 'VIDEO',
		'img_minor_mime' => $provider,
	),
	__METHOD__,
	array( 'LIMIT' => $limit )
);

$total = $result->numRows();
$success = 0;
$failed = 0;
$skip = 0;
while ( $row = $dbw->fetchObject($result) ) {
	$name = $row->img_name;
	echo "Name: $name";

	$title = Title::newFromText( $name, NS_FILE );
	if ( !$title instanceof Title ) {
		$failed++;
		echo "...FAILED. (Error: Title NOT found)\n";
		continue;
	}

	$file = wfFindFile( $title );
	if ( empty($file) ) {
		$failed++;
		echo "...FAILED. (Error: File NOT found)\n";
		continue;
	}

	$metadata = unserialize( $row->img_metadata );
	if ( !$metadata ) {
		$failed++;
		echo "...FAILED. (Error: Cannot unserialized metadata)\n";
		continue;
	}

	// check for videoId
	if ( empty( $metadata['videoId'] ) ) {
		$skip++;
		echo "...SKIPPED. (empty videoId in metadata).\n";
		continue;
	}

	// check for title
	if ( empty( $metadata['title'] ) ) {
		$skip++;
		echo "...SKIPPED. (empty title in metadata).\n";
		continue;
	}

	// check for title
	if ( !isset( $metadata['canEmbed'] ) ) {
		$skip++;
		echo "...SKIPPED. (canEmbed field NOT found in metadata).\n";
		continue;
	}

	// check if the metadata already mapped
	if ( isset( $metadata['name'] ) ) {
		$skip++;
		echo "...SKIPPED. ('name' field found in metadata. metadata already mapped).\n";
		continue;
	}

	// map metadata
	$newMetadata = mapMetadata( $name, $ingester, $metadata );
	if ( $newMetadata === false ) {
		continue;
	}

	echo "\n\tMetadata:\n";
	foreach ( $metadata as $key => $value ) {
		echo "\t\t$key: $value\n";
	}

	echo "\n\tNEW Metadata:\n";
	$fields = array_unique( array_merge( array_keys( $newMetadata ), array_keys( $metadata ) ) );
	foreach ( $fields as $field ) {
		if ( !isset( $newMetadata[$field] ) ) {
			echo "\t\t[DELETED] $field: $metadata[$field]\n";
		} else if ( !isset( $metadata[$field] ) ) {
			echo "\t\t[NEW] $field: $newMetadata[$field]\n";
		} else if ( strcasecmp( $metadata[$field], $newMetadata[$field] ) == 0 ) {
			echo "\t\t$field: $newMetadata[$field]\n";
		} else {
			echo "\t\t$field: $newMetadata[$field] (Old value: $metadata[$field])\n";
		}
	}

	if ( !$dryRun ) {
		$newMetadata = serialize( $newMetadata );

		if ( wfReadOnly() ) {
			die( "Read only mode.\n" );
		}

		$dbw->begin();

		// update database
		$dbw->update( 'image',
			array( 'img_metadata' => $newMetadata ),
			array( 'img_name' => $name ),
			__METHOD__
		);

		$dbw->commit();

		// clear cache
		$file->purgeEverything();
	}

	$success++;
	echo "Name: $name...DONE.\n";
}

echo "Total Videos: $total, Success: $success, Failed: $failed, Skipped: $skip.\n\n";