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
	 * Perform database query to get geo data
	 *
	 * @param array $filters additional statements to filter geo data by
	 * @return array set of PlaceModel objects
	 */
	private function query(Array $filters = array()) {
		wfProfileIn(__METHOD__);
		$dbr = $this->getDB();

		// build query
		$tables = array(self::WPP_TABLE);
		$fields = array('page_id', 'propname', 'props');
		$where = array(
			'propname' => array(WPP_PLACES_LATITUDE, WPP_PLACES_LONGITUDE),
		);

		// apply filters
		if (isset($filters['categories'])) {
			// spaces are replaced by underscores (_) in cl_to
			foreach($filters['categories'] as &$category) {
				$category = str_replace(' ', '_', $category);
			}

			$tables[] = 'categorylinks';
			$where[] = 'cl_from = page_id';
			$where['cl_to'] = $filters['categories'];
		}

		// perform the query
		$res = $dbr->select($tables , $fields, $where, __METHOD__);

		// get data from table rows
		$attrs = array();

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

		wfProfileOut(__METHOD__);
		return $models;
	}

	/**
	 * Get geo data for all tagged articles on a wiki
	 *
	 * @return array set of PlaceModel objects
	 */
	public function getAll() {
		wfProfileIn(__METHOD__);

		$models = $this->query();

		wfProfileOut(__METHOD__);
		return $models;
	}

	/**
	 * Get geo data for all tagged articles from gives categorie(s)
	 *
	 * @param mixed $categories can be a single category (string) or an array of categories
	 * @return array set of PlaceModel objects
	 */
	public function getFromCategories($categories) {
		wfProfileIn(__METHOD__);

		if (is_string($categories)) {
			$categories = array($categories);
		}

		$models = $this->query(array(
			'categories' => $categories
		));

		wfProfileOut(__METHOD__);
		return $models;
	}

	public function getNearby(PlaceModel $center) {

	}

	public function getNearbyByTitle(Title $center) {

	}

	private function getDB($type = DB_SLAVE) {
		return $this->app->wf->GetDB($type, array(), $this->app->wg->DBname);
	}
}