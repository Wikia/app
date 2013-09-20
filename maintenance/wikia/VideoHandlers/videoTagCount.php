<?php
/**
 * Created by JetBrains PhpStorm.
 * User: garth
 * Date: 7/3/13
 * Time: 3:52 PM
 * To change this template use File | Settings | File Templates.
 *
 * @ingroup Maintenance
 */

ini_set('display_errors', 'stderr');
ini_set('error_reporting', E_NOTICE);

require_once( dirname( __FILE__ ) . '/../../Maintenance.php' );

class VideoTagCount extends Maintenance {

	public function __construct() {
		parent::__construct();
		$this->mDescription = "Find video tags and count the type and occurances";
	}

	public function execute() {

		$pages = $this->getPages();

		$this->countTags( $pages );

		exit( 0 );
	}

	/**
	 * Get all the pages in this wiki that have YouTube tags on them
	 * @return array
	 */
	public function getPages ( ) {
		global $wgCityId, $wgStatsDB;

		// Find all pages in this wiki that have YouTube tags
		$dbr = wfGetDB( DB_SLAVE, array(), $wgStatsDB );
		$sql = "SELECT ct_page_id FROM city_used_tags WHERE ct_kind = 'youtube' AND ct_wikia_id = $wgCityId";
		$result = $dbr->query($sql);

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
			if ( preg_match_all("/(<youtube[^>]*>|<gvideo[^>]*>|<aovideo[^>]*>|<aoaudio[^>]*>|<wegame[^>]*>|<tangler>|<gtrailer>|<nicovideo>|<ggtube>|<cgamer>|<longtail>)/", $text, $matches ) ) {
				$tags = $matches[1];
				foreach ( $tags as $t ) {
					$t2 = preg_replace('/<([^> ]+).*>/', '$1', $t);
					echo "-,$wgCityId,$id,$t2\n";
				}
			}
		}
	}
}

$maintClass = "VideoTagCount";
require_once( RUN_MAINTENANCE_IF_MAIN );

