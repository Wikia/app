<?php
/**
 * @package MediaWiki
 * @addtopackage maintenance
 *
 * Probably a one-off script but checking it in anyway
 * update Vertical id for wikis based on contents of CSV file
 * Also update Category id for wikis
 *
 * Usage:
 * SERVER_ID=177 php maintenance/wikia/updateWikiVertical.php --file="path" [--dryrun] [--byurl]
 * --dryrun means do not update the database
 * --byurl  means the first column is the url of the wiki.  default is wiki_id.
 */

ini_set( "include_path", dirname(__FILE__)."/.." );
require_once( "commandLine.inc" );


$dryrun = isset( $options[ "dryrun" ] ) ? $options[ "dryrun" ] : false;
$file = isset( $options["file"] ) ? $options["file"] : false;
$byurl = isset( $options["byurl"] ) ? $options["byurl"] : false;

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
	"video games" => 2,
	"games" => 2,
	"books" => 3,
	"comics" => 4,
	"lifestyle" => 5,
	"music" => 6,
	"movies" => 7
];

$cat_map = [
	"humor" => 1,
	"gaming" => 2,
	"entertainment" => 3,
	"wikia" => 4,
	"toys" => 5,
	"food and drink" => 6,
	"travel" => 7,
	"education" => 8,
	"lifestyle" => 9,
	"finance" => 10,
	"politics" => 11,
	"technology" => 12,
	"science" => 13,
	"philosophy" => 14,
	"sports" => 15,
	"music" => 16,
	"creative" => 17,
	"auto" => 18,
	"green" => 19,
	"answers" => 20,
	"wikianswers" => 20,
	"tv" => 21,
	"video games" => 22,
	"books" => 23,
	"comics" => 24,
	"fanon" => 25,
	"home and garden" => 26,
	"movies" => 27,
	"anime" => 28
];

// print out any non-matching wikis at the end of the script
$not_matched = [];

$dbr = wfGetDB(DB_SLAVE, array(), $wgExternalSharedDB);

foreach($csv as $line) {

	$city_id = 0;
	$city_url = "";

	if ( !empty($byurl) ) {
		// 1st column is city_url
		list($city_url, $vertical_name, $cat1, $cat2) = explode(",", $line);

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
	} else {
		// 1st column is wiki_id
		list($city_id, $vertical_name, $cat1, $cat2) = explode(",", $line);
	}

	$city_url = trim($city_url);
	$vertical_name = trim($vertical_name);
	$cat1 = trim($cat1);
	$cat2 = trim($cat2);

	$vertical_id = 0; // other
	$cat1_id = false;
	$cat2_id = false;
	foreach ($mapping as $name => $id) {
		//echo "checking $name against $vertical_name\n";
		//echo "result: " . var_dump(stristr($name, $vertical_name)) . "\n";
		if (stristr($name, $vertical_name) !== false) {
			$vertical_id = $id;
			//echo "match: $id\n";
			break;
		}
	}
	foreach ($cat_map as $name => $id) {
		//echo "checking $name against $cat1 $cat2\n";
		//echo "result: " . var_dump(stristr($name, $cat1)) . "\n";
		//echo "result: " . var_dump(stristr($name, $cat2)) . "\n";
		if ( !empty($cat1) && stristr($name, $cat1) !== false) {
			$cat1_id = $id;
		}
		if ( !empty($cat2) && stristr($name, $cat2) !== false) {
			$cat2_id = $id;
		}
	}

	if ( !$dryrun ) {
		echo "Changing $city_url ($city_id) to $vertical_id\n";
		$hub->setVertical( $city_id, $vertical_id, $reason );
	} else {
		echo "NOT Changing $city_url ($city_id) to $vertical_id\n";
	}

	$categories = [];
	if ( !empty($cat1_id) ) {
		$categories[] = $cat1_id;
	}
	if ( !empty($cat2_id) ) {
		$categories[] = $cat2_id;
	}
	if ( !$dryrun && !empty($categories)) {
		echo "Changing categories to $cat1 ($cat1_id) $cat2 ($cat2_id)\n";
		$hub->updateCategories( $city_id, $categories, $reason );
	} else {
		echo "NOT changing categories to $cat1 ($cat1_id) $cat2 ($cat2_id)\n";
	}

}

if ($not_matched) {
	echo "Could not find a match for these wikis, fix data file\n";
	print_r($not_matched);
}
