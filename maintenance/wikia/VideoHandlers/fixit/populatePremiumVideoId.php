<?php

$db = wfGetDB(DB_SLAVE, array(), 'video151');

echo "Building ID list ... ";
global $titleInfo;
$titleInfo = [];
$result = $db->query('select video_title as title, video_id, provider from video_info where premium = 0');
while ( $row = $db->fetchObject( $result ) ) {
	$titleInfo[$row->title] = ['id'       => $row->video_id,
							   'provider' => $row->provider];
}

$db->freeResult($result);
echo "done\n";

/**
 * Class PopulatePremiumVideoId
 *
 * This script is no longer necessary after we've added all
 */
class PopulatePremiumVideoId {
	public static function run( DatabaseBase $db, $dbname, $test = false, $verbose = false ) {
		global $titleInfo;

		// Don't process the video wiki
		if ( $dbname == 'video151' ) {
			return true;
		}

		$sql = "select video_title as title, provider from video_info where premium = 1 and (video_id = '' or provider is null)";
		$result = $db->query($sql);

		$numRows = 0;
		$numFound = 0;
		$update = array();
		while ( $row = $db->fetchObject( $result ) ) {
			$numRows++;
//			echo "Checking ".$row->title." from ".$row->provider."\n";
			if ( isset( $titleInfo[$row->title] ) ) {
				$numFound++;

				$info = $titleInfo[$row->title];
				$provider = $row->provider ? null : $info['provider'];
				$update[] = [ $row->title, $provider, $info['id'] ];
			}
		}
		$db->freeResult($result);

		if ( $numRows ) {
			echo "[$dbname] Found video IDs for $numFound of $numRows videos\n";
		}

		foreach ( $update as $info ) {
			list($title, $provider, $id) = $info;
			$sql = "update video_info
                       set video_id='$id' ".
			         ($provider ? ", provider=".$db->addQuotes($provider) : '').' '.
                     "where video_title = ".$db->addQuotes($title);

			if ( $verbose ) {
				echo "Running SQL on $dbname: $sql\n";
			}

			if ( empty($test) ) {
				$db->query($sql);
			}
		}
	}
}
