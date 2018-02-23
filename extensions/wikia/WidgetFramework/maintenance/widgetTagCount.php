<?php

require_once( __DIR__ . '/../../../../maintenance/Maintenance.php' );

class WidgetTagCount extends Maintenance {

	public function __construct() {
		parent::__construct();
		$this->mDescription = "Find <widget> tags and count the type and occurances";
	}

	public function execute() {
		# $this->countTags( [ 32633 ] ); return;

		$pages = $this->getPages();
		$this->countTags( $pages );
	}

	/**
	 * Get all the pages in this wiki that have YouTube tags on them
	 * @return array
	 */
	public function getPages ( ) {
		global $wgCityId, $wgSpecialsDB;

		// Find all pages in this wiki that have YouTube tags
		$dbr = wfGetDB( DB_SLAVE, array(), $wgSpecialsDB );
		$sql = "SELECT ct_page_id FROM city_used_tags WHERE ct_kind = 'widget' AND ct_wikia_id = $wgCityId";
		$result = $dbr->query($sql, __METHOD__);

		// Get an array of pages that have video tags on them
		$pageIDs = array();
		foreach ($result as $row) {
			$pageIDs[] = $row->ct_page_id;
		}

		return $pageIDs;
	}

	/**
	 * @param $pageIDs
	 */
	public function countTags ( $pageIDs ) {
		global $wgCityId;

		foreach ( $pageIDs as $id ) {
			$page = Article::newFromID($id);
			if ( empty($page) ) {
				continue;
			}

			$text = $page->getText();
			if ( preg_match_all("#<widget>([A-Za-z]+)</widget>#", $text, $matches ) ) {
				$tags = $matches[1];
				foreach ( $tags as $type ) {
					echo "$wgCityId,$id,$type\n";
				}
			}
		}
	}
}

$maintClass = WidgetTagCount::class;
require_once( RUN_MAINTENANCE_IF_MAIN );
