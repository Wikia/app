<?php
/**
 * Enables the $wgForceVisualEditor WikiFactory variable for groups of wikis
 * depending on WAM score. The WF variable itself forces the Visual Editor
 * as the preferred editor on a wiki for anonymous and newly-registered users.
 *
 * @author Matt Klucsarits <mattk@wikia-inc.com>
 */
// Enable the WAM API extension so that the controller is loaded
$wgEnableWAMApiExt = true;
ini_set( 'include_path', dirname(__FILE__).'/../' );
require_once( 'commandLine.inc' );

// List of wiki IDs for which the wgForceVisualEditor variable should NOT be enabled
$excludedWikis = array(
	// Values are for description only and just need to be not equal to false
	43339 => 'lyrics',
	2233  => 'marvel',
	3616  => 'it.marvel',
	2237  => 'dc',
	90248 => 'archie',
	4385  => 'darkhorse',
	2446  => 'imagecomics',
);

function getVEForcedValue( $wikiId ) {
	$wikiFactoryVar = WikiFactory::getVarByName( 'wgForceVisualEditor', $wikiId );
	return ( is_object( $wikiFactoryVar ) && $wikiFactoryVar->cv_value ) ?
		unserialize( $wikiFactoryVar->cv_value ) : false;
}

// Use the --disable option to set $wgForceVisualEditor to false
$forceVisualEditor = isset( $options['disable'] ) ? false : true;

if ( !isset( $options['limit'] ) ) {
	exit( "No limit specified. Please specify an integer limit using the --limit option.\n" );
} elseif ( ( $limit = (int)$options['limit'] ) < 1 ) {
	exit( "Invalid limit specified. Please specify an integer limit greater than 0.\n" );
}

// First get the WAM index
$wamWikis = array();
$app = F::app();
$apiOffset = 0;
$apiLimit = WAMApiController::DEFAULT_PAGE_SIZE;
echo "Gathering WAM rankings";
while ( $apiOffset < 5000 ) {
	echo '.';
	$wamData = $app->sendRequest( 'WAMApi', 'getWAMIndex', array( 'offset' => $apiOffset ) )->getData();

	if ( empty( $wamData ) || !is_array( $wamData['wam_index'] ) ) {
		// Unexpected return values -- is something broken?
		echo "\nWarning: Invalid or missing data returned from WAM API.\n";
		break;
	}
	elseif ( empty( $wamData['wam_index'] ) ) {
		// Unexpectedly reached end of list
		echo "\nWarning: Unexpectedly reached end of WAM list (less than 5000 wikis indexed).\n";
		break;
	}

	foreach ( $wamData['wam_index'] as $wikiId => $data ) {
		$wamWikis[$wikiId] = $data['wam_rank'];
	}

	$apiOffset += $apiLimit;
}

echo "\n";
// Get all wiki IDs from the database
$dbr = wfGetDB( DB_SLAVE, array(), $wgExternalSharedDB );

echo "Fetching $limit wikis from database...\n";
$result = $dbr->select( 'city_list', 'city_id, city_title, city_url', '', 'DatabaseMysql::select',
	array( 'LIMIT' => $limit, 'ORDER BY' => 'city_id' ) );

$allWikis = array();
while ( $row = $dbr->fetchObject( $result ) ) {
	$allWikis[] = $row;
}

echo count( $allWikis ) . " wikis found.\n";

$affected = 0;
foreach ( $allWikis as $wiki ) {
	if ( isset( $excludedWikis[$wiki->city_id] ) ) {
		// If the wiki is in the exclusion list, continue
		echo "Skipping ".$wiki->city_title." because it is in exclusion list.\n";
		continue;
	} elseif ( !$forceVisualEditor && isset( $wamWikis[$wiki->city_id] ) ) {
		// if disabling VE and wiki is in WAM, continue
		echo "Skipping ".$wiki->city_title." because it is in WAM list.\n";
		continue;
	}

	$wikiFactoryVar = WikiFactory::getVarByName( 'wgForceVisualEditor', $wiki->city_id );
	if ( (bool)getVEForcedValue( $wiki->city_id ) !== $forceVisualEditor ) {
		echo 'Setting $wgForceVisualEditor to '.( $forceVisualEditor ? 'TRUE' : 'FALSE' ).' for '.$wiki->city_title.' ('.$wiki->city_url.")\n";
		// Safety switch: Uncomment two lines below if you know what you are doing.
		//WikiFactory::setVarByName( 'wgForceVisualEditor', $wiki->city_id, $forceVisualEditor );
		//WikiFactory::clearCache( $wiki->city_id );
		$affected++;
	}
}

echo "Done. $affected of $limit wikis affected.\n";
