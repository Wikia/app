<?php

/**
* Maintenance script to check if the wiki has default thumbnail
* This is one time use script to be used with runOnCluster.php
* @author Saipetch Kongkatong
*/

class DefaultThumbnail {

	public static function isExist( DatabaseBase $db, $verbose = false, $dryRun = false, $params = array() ) {
		echo "Wiki: $params[dbname] (ID:$params[cityId])\n";

		if ( !$db->tableExists( 'image' ) ) {
			echo "ERROR: $params[dbname] (ID:$params[cityId]): image table not exist.\n\n";
			return;
		}

		if ( $params['dbname'] == F::app()->wg->WikiaVideoRepoDBName ) {
			echo "SKIP: $params[dbname] (ID:$params[cityId])\n\n";
			return;
		}

		$row = $db->selectRow(
			'image',
			'1',
			array(
				'img_media_type' => 'video',
				'img_size' => '66162',
				'img_sha1' => 'm03a6fnvxhk8oj5kgnt11t6j7phj5nh',
				"img_timestamp >= '20131029'",
				"img_timestamp <= '20131110'",
			),
			__METHOD__
		);

		$result = ( $row ) ? "FOUND" : "NOT FOUND";

		echo "$params[dbname] (ID:$params[cityId]): default thumbnail ".$result." \n";
	}

}