<?php

/**
 * Script that migrates non-xwiki promote data to xwiki promote data
 *
 * @ingroup Maintenance
 */

require_once(dirname( __FILE__ ) . '/../../../../maintenance/Maintenance.php');

class MigrateToXWiki extends Maintenance {

	/**
	 * Set script options
	 */
	public function __construct() {
		parent::__construct();
		$this->mDescription = 'Migrate promote data';
	}

	public function execute() {
		global $wgExternalSharedDB;

		$wikis = $this->getCityVisualizationWikis();

		$count = 0;
		$mdb = wfGetDB( DB_MASTER, [], $wgExternalSharedDB );
		foreach ($wikis as $wiki) {
			echo 'Working on ' . $wiki['city_id'] . PHP_EOL;
			$count++;

			if ($this->insertWikiToXwiki( $wiki, $mdb )) {
				echo 'Uploading images...' . PHP_EOL;
				$images = $this->getCityVisualizationImages( $wiki['city_id'] );
				$this->uploadXwikiImages( $images );
			} else {
				echo 'NOT uploading images...' . PHP_EOL;
			}
		}
	}

	/**
	 * @param $wiki
	 * @param $db Database
	 * @return bool
	 */
	private function insertWikiToXwiki( $wiki, $db ) {
		$result = true;
		$oldIgnore = $db->ignoreErrors( false );

		try {
			$db->insert( 'city_visualization_xwiki', $wiki );
		} catch (DBQueryError $e) {
			$result = false;
		}
		$db->ignoreErrors( $oldIgnore );

		return $result;
	}


	private function getCityVisualizationWikis() {
		global $wgExternalSharedDB;

		$sdb = wfGetDB( DB_SLAVE, [], $wgExternalSharedDB );
		$query = "select * from city_visualization";
		$result = $sdb->query( $query );
		$wikis = [];
		while ($row = $result->fetchObject()) {
			$wikis [] = [
				'city_id' => $row->city_id,
				'city_lang_code' => $row->city_lang_code,
				'city_vertical' => $row->city_vertical,
				'city_headline' => $row->city_headline,
				'city_description' => $row->city_description,
				'city_flags' => $row->city_flags
			];
		};

		return $wikis;
	}

	private function getCityVisualizationImages( $city_id ) {
		global $wgExternalSharedDB;

		$images = [];
		$sdb = wfGetDB( DB_SLAVE, [], $wgExternalSharedDB );
		$query = "select * from city_visualization_images where city_id = " . intval( $city_id );
		$result = $sdb->query( $query );
		while ($row = $result->fetchObject()) {
			$images [] = [
				'city_id' => $row->city_id,
				'page_id' => $row->page_id,
				'city_lang_code' => $row->city_lang_code,
				'image_index' => $row->image_index,
				'image_name' => $row->image_name,
				'image_review_status' => $row->image_review_status,
				'last_edited' => $row->last_edited,
				'review_start' => $row->review_start,
				'review_end' => $row->review_end,
				'reviewer_id' => $row->reviewer_id

			];
		};

		return $images;
	}

	private function uploadXwikiImages( $images ) {
		foreach ($images as $image) {
			// todo: implement upload
		}
	}
}

$maintClass = 'MigrateToXWiki';
require_once(RUN_MAINTENANCE_IF_MAIN);
