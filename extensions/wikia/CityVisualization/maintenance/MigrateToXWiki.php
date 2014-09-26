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

		$mdb = wfGetDB( DB_MASTER, [], $wgExternalSharedDB );
		foreach ($wikis as $wiki) {
			echo 'Working on ' . $wiki['city_id'] . PHP_EOL;

			if ($this->insertWikiToXwiki( $wiki, $mdb )) {
				echo $wiki['city_id'] . ' inserted to DB' . PHP_EOL;
			} else {
				echo $wiki['city_id'] . ' FAILED at insert to DB' . PHP_EOL;
			}

			echo 'Uploading images...' . PHP_EOL;
			$images = $this->getCityVisualizationImages( $wiki['city_id'] );
			$this->uploadXwikiImages( $images, $wiki['city_id'], $mdb );
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


	/**
	 * @param $images
	 * @param $wiki_id
	 * @param $db Database
	 */
	private function uploadXwikiImages( $images, $wiki_id, $db ) {
		foreach ($images as $image) {
			$file = GlobalFile::newFromText( $image['image_name'], $image['city_id'] );
			$image_name = implode( '.', [$wiki_id, time(), uniqid()] );

			if ($file->exists()) {
				$this->uploadSingleXwikiImage( $db, $file, $image, $image_name );
			} else {
				echo $image['image_name'] . ' does not exist' . PHP_EOL;
			}

		}
	}

	/**
	 * @param $update
	 * @param $db Database
	 */
	private function insertImageToXwiki( $update, $db ) {
		$result = true;
		$oldIgnore = $db->ignoreErrors( false );

		try {
			$db->insert( 'city_visualization_images_xwiki', $update );
		} catch (DBQueryError $e) {
			$result = false;
		}
		$db->ignoreErrors( $oldIgnore );

		return $result;
	}

	/**
	 * @param $db Database storing visualization images table
	 * @param $file File source file object
	 * @param $image array
	 * @param $image_name string Destination file name
	 */
	public function uploadSingleXwikiImage( $db, $file, $image, $image_name ) {
		$source_url = $file->getUrl();

		echo $image['image_name'] . ' from ' . $source_url . ' is being uploaded as ' . $image_name . ' ...', PHP_EOL;

		$xwiki_file = new PromoXWikiImage($image_name);

		$update = [
			'city_id' => $image['city_id'],
			'city_lang_code' => $image['city_lang_code'],
			'image_type' => (mb_ereg_match( '.*Wikia-Visualization-Main.*', $image['image_name'] ) > 0 ? 0 : 1),
			'image_index' => $image['image_index'],
			'image_name' => $image_name,
			'image_review_status' => $image['image_review_status'],
			'last_edited' => $image['last_edited'],
			'review_start' => $image['review_start'],
			'review_end' => $image['review_end'],
			'reviewer_id' => $image['reviewer_id'],
		];

		$uploadResult = $xwiki_file->uploadByUrl( $source_url );
		if ($uploadResult == 0) {
			echo $image_name . ' finished uploading' . PHP_EOL;
			echo $image_name . ' access url: ' . $xwiki_file->getUrl() . PHP_EOL;
			$updateResult = $this->insertImageToXwiki( $update, $db );
			if ($updateResult) {
				echo $image_name . ' stored in DB' . PHP_EOL;
			} else {
				echo $image_name . ' storing in DB failed' . PHP_EOL;
			}
		} else {
			echo $image_name . ' returned error code ' . $uploadResult . PHP_EOL;
		}
	}
}

$maintClass = 'MigrateToXWiki';
require_once(RUN_MAINTENANCE_IF_MAIN);
