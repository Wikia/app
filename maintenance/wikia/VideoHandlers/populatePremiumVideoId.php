<?php

$filename = './video-info.tsv';
if ( !file_exists($filename) ) {
	die("Could not find $filename\n");
}

echo "Reading file of IDs ...";
$handle = fopen($filename, 'r');
$contents = fread($handle, filesize($filename));
fclose($handle);
echo " done\n";

echo "Building ID list ... ";
global $titleIDs;
$titleIDs = array();
foreach ( explode("\n", $contents) as $line ) {
	list($title, $provider, $id) = explode("\t", $line);

	$titleIDs[$title][$provider] = $id;
}
echo " done\n";

/**
 * Class PopulatePremiumVideoId
 *
 * This script is no longer necessary after we've added all
 */
class PopulatePremiumVideoId {
	public static function run( DatabaseMysql $db, $dbname, $test = false, $verbose = false ) {
		global $titleIDs;

		$sql = "select video_title, provider from video_info where premium = 1 and video_id = ''";
		$result = $db->query($sql);

		$numRows = 0;
		$numFound = 0;
		$update = array();
		while ( $row = $db->fetchObject( $result ) ) {
			$numRows++;
			if ( isset( $titleIDs[$row->title][$row->provider] ) ) {
				$numFound++;
				$update[] = [ $row->title, $row->provider, $titleIDs[$row->title][$row->provider] ];
			}
		}
		$db->freeResult($result);

		echo "Found video IDs for $numFound of $numRows videos\n";

		foreach ( $update as $info ) {
			list($title, $provider, $id) = $info;
			$sql = "update video_info
                       set video_id='$id'
                     where video_title = ".$db->addQuotes($title)."
				       and provider = ".$db->addQuotes($provider);

			if ( isset($verbose) ) {
				echo "Running SQL on $dbname: $sql\n";
			}

			if ( empty($test) ) {
				$db->query($sql);
			}
		}
	}
}
