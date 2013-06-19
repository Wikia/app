<?php

/**
 * PlacesModel
 *
 * Allows to get array of PlaceModel objects representing geo data of:
 *  - all articles on a wiki
 *  - all articles from given categories
 *  - all articles tagged as being "nearby" given place
 *
 * TODO: add caching
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
			$tables[] = 'categorylinks';
			$where[] = 'cl_from = page_id';
			$where['cl_to'] = $filters['categories'];
		}
		else if (isset($filters['nearby'])) {
			$lat = $filters['nearby']['lat'];
			$lon = $filters['nearby']['lon'];

			wfDebug(__METHOD__ . "::nearby - {$lat},{$lon}\n");
		}

		// apply rows limit
		$options = array();
		if (!empty($filters['limit'])) {
			$options['LIMIT'] = $filters['limit'] * 2;
		}

		// perform the query
		$res = $dbr->select($tables , $fields, $where, __METHOD__, $options);

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
			$models[] = PlaceModel::newFromAttributes($attr);
		}

		wfProfileOut(__METHOD__);
		return $models;
	}

	/**
	 * Get geo data for all tagged articles on a wiki
	 *
	 * @param $limit integer limit the number of places returned
	 * @return array set of PlaceModel objects
	 */
	public function getAll($limit = 0) {
		wfProfileIn(__METHOD__);

		$models = $this->query(array(
			'limit' => $limit
		));

		wfProfileOut(__METHOD__);
		return $models;
	}

	/**
	 * Get geo data for all tagged articles from gives categorie(s)
	 *
	 * @param mixed $categories single category (string) or an array of categories (without namespace prefix)
	 * @return array set of PlaceModel objects
	 */
	public function getFromCategories($categories) {
		wfProfileIn(__METHOD__);

		if (is_string($categories)) {
			$categories = array($categories);
		}

		foreach($categories as &$category) {
			$category = str_replace(' ', '_', $category);
		}

		$models = $this->query(array(
			'categories' => $categories
		));

		wfProfileOut(__METHOD__);
		return $models;
	}

	/**
	 * Get geo data for articles from categories given title belongs to
	 *
	 * @param Title $title page title to get places from categories this title belongs to
	 * @return array set of PlaceModel objects
	 */
	public function getFromCategoriesByTitle( Title $title ) {
		wfProfileIn(__METHOD__);

		// get article categories
		$dbr = $this->getDB();
		$res = $dbr->select('categorylinks' , 'cl_to', array('cl_from' => $title->getArticleID()), __METHOD__);

		$categories = array();

		while($row = $res->fetchObject()) {
			$categories[] = $row->cl_to;
		}

		$models = $this->getFromCategories( $categories );

		wfProfileOut(__METHOD__);
		return $models;
	}

	/**
	 * Get geo data of all "nearby" articles (within given distance in kilometres)
	 *
	 * TODO: implement
	 *
	 * @param PlaceModel $center place to find nearby places for
	 * @param int $distance define nearby distance (in km)
	 * @return array set of PlaceModel objects
	 */
	public function getNearby(PlaceModel $center, $distance = 10 /* km */) {
		wfProfileIn(__METHOD__);

		$models = $this->query(array(
			'nearby' => $center->getLatLon(),
			'distance' => intval($distance)
		));

		wfProfileOut(__METHOD__);
		return $models;
	}

	/**
	 * Get geo data of all "nearby" articles (within given distance in kilometres)
	 *
	 * TODO: implement
	 *
	 * @param Title $title article title to find nearby places for
	 * @param int $distance define nearby distance (in km)
	 * @return array set of PlaceModel objects
	 */
	public function getNearbyByTitle(Title $title, $distance = 10 /* km */) {
		wfProfileIn(__METHOD__);

		$storage = PlaceStorage::newFromTitle($title);
		$models = $this->getNearby($storage->getModel(), $distance);

		wfProfileOut(__METHOD__);
		return $models;
	}

	private function getDB($type = DB_SLAVE) {
		return wfGetDB($type, array(), $this->app->wg->DBname);
	}
}