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
	 * @param array $filters additional statements to filter geo data by (can be categories, pages, nearby)
	 * @return PlaceModel[] set of PlaceModel objects
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
		if (isset($filters['pages'])) {
			$where['page_id'] = $filters['pages'];
		}
		else if (isset($filters['categories'])) {
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
	 * @return PlaceModel[] set of PlaceModel objects
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
	 * Get geo data for all articles provided as a list
	 *
	 * @param string $text the list of articles
	 * @return PlaceModel[] set of PlaceModel objects
	 */
	public function getFromText($text) {
		wfProfileIn(__METHOD__);

		// parse the list
		$items = explode("\n", trim($text));

		/* @var int[] $pages */
		$pages = array_map(
			function($item) {
				$item = trim($item, '* ');

				// get page ID from the title
				$title = Title::newFromText($item);
				return $title instanceof Title ? $title->getArticleID() : 0;
			},
			$items
		);

		$models = $this->query(array(
			'pages' => $pages
		));

		wfProfileOut(__METHOD__);
		return $models;
	}

	/**
	 * Get geo data for all tagged articles from gives categorie(s)
	 *
	 * @param array|string $categories single category (string) or an array of categories (without namespace prefix)
	 * @return PlaceModel[] set of PlaceModel objects
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
	 * @return PlaceModel[] set of PlaceModel objects
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
	 * * We'll use MySQL to fetch the points within a given square and then use PHP to calculate the distance
	 *
	 * @param PlaceModel $center place to find nearby places for
	 * @param int $range define nearby distance (in km)
	 * @param int $limit how many places to return at most
	 * @return PlaceModel[] set of PlaceModel objects
	 */
	public function getNearby(PlaceModel $center, $range = 10 /* km */, $limit = 50) {
		wfProfileIn(__METHOD__);

		$limit = min($limit, 250);

		// convert to miles (1 mile = 1.609344 km)
		$range_miles = $range * 0.621371192;

		/**
		 * Calculate latitude and longitude boundaries
		 * @see https://blog.fedecarg.com/2009/02/08/geo-proximity-search-the-haversine-equation/
		 *
		 * Haversine equation
		 */
		$lon_diff = $range_miles / abs( cos( $center->getLat() * M_PI / 180 * 69 ) );

		$lon = [
			$center->getLon() - $lon_diff,
			$center->getLon() + $lon_diff
		];

		$lat_diff = $range_miles / 69;

		$lat = [
			$center->getLat() - $lat_diff,
			$center->getLat() + $lat_diff,
		];

		$dbr = self::getDB();

		$sql_lat = self::getNearbySql( $dbr, WPP_PLACES_LATITUDE, $lat, $limit );
		$sql_lon = self::getNearbySql( $dbr, WPP_PLACES_LONGITUDE, $lon, $limit );

		$res = $dbr->query( sprintf( '(%s) UNION (%s)', $sql_lat, $sql_lon ), __METHOD__ );

		/**
		 * Now get points coordinates, calculate distance from $center for each of them
		 * and filter out those too far away.
		 */
		$points = [];
		foreach($res as $row) {
			$id = intval( $row->page_id );

			if (empty($points[$id])) {
				$points[$id] = [
					'pageId' => $id,
					'lat' => null,
					'lon' => null,
				];
			}

			if ($row->lat) $points[$id]['lat'] = $row->lat;
			if ($row->lon) $points[$id]['lon'] = $row->lon;
		}

		// keep points that have both latitude and longitude within required range
		$points = array_filter($points, function(Array $point) {
			return !is_null($point['lat']) && !is_null($point['lon']);
		});

		// now calculate distance and remove points that do not meet this criterion
		$points = array_filter(array_map(function(Array $point) use ($center, $range) {
			$model = PlaceModel::newFromAttributes($point);
			$distance = $center->getDistanceTo($model);

			// do not include the place we want to find points nearby
			if ($center->getPageId() && $distance === 0) {
				return false;
			}

			if ( $distance /* m */ < $range /* km */ * 1000 ) {
				$model->setDistance($distance);
				return $model;
			}
			else {
				return false;
			}
		}, $points));

		// order by distance
		uasort($points, function(PlaceModel $a, PlaceModel $b) {
			return $a->getDistance() < $b->getDistance() ? -1 : 1;
		});

		$points = array_values($points);

		wfProfileOut(__METHOD__);
		return $points;
	}

	 /**
	  * @param DatabaseBase $dbr
	  * @param string $propname
	  * @param array $boudaries
	  * @param int $limit
	  * @return string
	  */
	private static function getNearbySql(DatabaseBase $dbr, $propname, Array $boudaries, $limit) {
		return $dbr->selectSQLText(
			self::WPP_TABLE,
			[
				'page_id',
				$propname === WPP_PLACES_LATITUDE
					?
					'props AS lat, NULL AS lon'
					:
					'NULL AS lat, props AS lon'
			],
			[
				'propname' => $propname,
				sprintf('props BETWEEN %.6f AND %.6f', $boudaries[0], $boudaries[1])
			],
			__METHOD__,
			[
				'LIMIT' => $limit
			]
		);
	}

	/**
	 * Get geo data of all "nearby" articles (within given distance in kilometres)
	 *
	 * @param Title $title article title to find nearby places for
	 * @param int $range define nearby distance (in km)
	 * @param int $limit how many places to return at most
	 * @return PlaceModel[] set of PlaceModel objects
	 */
	public function getNearbyByTitle(Title $title, $range = 10 /* km */, $limit = 50) {
		wfProfileIn(__METHOD__);

		$storage = PlaceStorage::newFromTitle($title);
		$models = $this->getNearby($storage->getModel(), $range, $limit);

		wfProfileOut(__METHOD__);
		return $models;
	}

	 /**
	  * @param int $type
	  * @return DatabaseBase
	  */
	private function getDB($type = DB_SLAVE) {
		return wfGetDB($type);
	}
}