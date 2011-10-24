<?php

/**
 * PlacesModel
 *
 * Allows to get array of PlaceModel objects representing geo data of:
 *  - all articles on a wiki
 *  - all articles from given categories
 *  - all articles tagged as being "nearby" given place
 */

 class PlacesModel {

	const WPP_TABLE = 'page_wikia_props';

	private $app;

	public function __construct() {
		$this->app = F::app();
	}

	/**
	 * Get geodata for all tagged articles on a wiki
	 *
	 * @return array set of PlaceModel objects
	 */
	public function getAll() {
		$dbr = $this->getDB();
		$attrs = array();

		$res = $dbr->select(self::WPP_TABLE, array('page_id', 'propname', 'props'), array(
			'propname' => array(WPP_PLACES_LATITUDE, WPP_PLACES_LONGITUDE),
		), __METHOD__);

		while($row = $res->fetchObject()) {
			$value = (float) $row->props;
			$pageId = intval($row->page_id);

			$attrs[$pageId]['pageId'] = $pageId;

			switch($row->propname) {
				case WPP_PLACES_LATITUDE:
					$attrs[$pageId]['lat'] = $value;
					break;

				case WPP_PLACES_LONGITUDE:
					$attrs[$pageId]['lon'] = $value;
					break;
			}
		}

		// we now have lat/lon data in $cords array
		// now let's create PlaceModel objects
		$models = array();

		foreach($attrs as $attr) {
			$models[] = F::build('PlaceModel', array($attr), 'newFromAttributes');
		}

		return $models;
	}

	public function getFromCategories($categories) {

	}

	public function getNearby(PlaceModel $center) {

	}

	public function getNearbyByTitle(Title $center) {

	}

	private function getDB($type = DB_SLAVE) {
		return $this->app->wf->GetDB($type, array(), $this->app->wg->DBname);
	}
}