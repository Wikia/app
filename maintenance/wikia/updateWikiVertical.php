<?php
/**
 * @package MediaWiki
 * @addtopackage maintenance
 *
 * Probably a one-off script but checking it in anyway
 * update Vertical id for wikis based on contents of CSV file
 *
 * Usage:
 * SERVER_ID=177 php maintenance/wikia/updateWikiVertical.php
 *
 */

ini_set( "include_path", dirname(__FILE__)."/.." );
require_once( "commandLine.inc" );


$dryrun = isset( $options[ "dryrun" ] ) ? $options[ "dryrun" ] : false;
$file = isset( $options["file"] ) ? $options["file"] : false;

if ($file) {
	$csv = file( $file );
	if (!$csv) {
		echo "could not read $file\n";
		exit();
	}
} else {
	echo "filename required";
	exit();
}

$hub = WikiFactoryHub::getInstance();
$reason = "manual categorization";
$mapping = [
	"other" => 0,
	"tv" => 1,
	"games" => 2,
	"books" => 3,
	"comics" => 4,
	"lifestyle" => 5,
	"music" => 6,
	"movies" => 7
];

// print out any non-matching wikis at the end of the script
$not_matched = [];

$dbr = wfGetDB(DB_SLAVE, array(), $wgExternalSharedDB);

foreach($csv as $line) {
	list($city_url, $vertical_name) = explode(",", $line);
	$city_url = trim($city_url);
	$vertical_name = trim($vertical_name);
	$city_id = 0;

	// Figure out what domain this is by the url they have given us
	$oRow = $dbr->selectRow(
		array( "city_domains" ),
		array( "city_id" ),
		array( "city_domain" => $city_url ),
		__METHOD__
	);

	if (!$oRow) {
		echo "id not found for $city_url\n";
		$not_matched[] = $city_url;
		continue;
	} else {
		$city_id = $oRow->city_id;
	}

	$vertical_id = 0; // other
	foreach ($mapping as $name => $id) {
		//echo "checking $name against $vertical_name\n";
		//echo "result: " . var_dump(stristr($name, $vertical_name)) . "\n";
		if (stristr($name, $vertical_name) !== false) {
			$vertical_id = $id;
			//echo "match: $id\n";
			break;
		}
	}

	echo "Changing $city_url ($city_id) to $vertical_id\n";
	if ( !$dryrun ) {
		$hub->setVertical( $city_id, $vertical_id, $reason );
	}

}

if ($not_matched) {
	echo "Could not find a match for these wikis, fix data file\n";
	print_r($not_matched);
}
