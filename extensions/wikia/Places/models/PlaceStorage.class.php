<?php

/**
 * PlaceStorage
 *
 * Class is used to access (read & write) article's geo data stored in page_wikia_props table.
 * PlaceModel class is used to encapsulate geo tag.
 */

class PlaceStorage {

	const WPP_TABLE = 'page_wikia_props';
	const CACHE_TTL = 604800; // a week

	private $app;
	private $memc;

	// ID of page model is stored for
	private $pageId;

	// place model representing geo tag for the page
	private $model;

	// initial value of geo tag (i.e. from the moment it was read from database)
	private $initialCords;

	/**
	 * Construct PlaceStorage model instance
	 *
	 * @param WikiaApp $app Nirvava application instance
	 * @param int $pageId article ID to build model for
	 */
	public function __construct($pageId) {
		$this->app = F::app();
		$this->memc = $this->app->wg->Memc;

		$this->pageId = $pageId;
		$this->model = new PlaceModel();
	}

	/**
	 * Return PlaceStorage model for article with given ID
	 *
	 * @param int $pageId article ID
	 * @return PlaceStorage model object
	 */
	public static function newFromId($pageId) {
		$instance = new PlaceStorage($pageId);

		// read data from database
		$instance->read();
		return $instance;
	}

	/**
	 * Return PlaceStorage model for given article
	 *
	 * @param Page $article article object
	 * @return PlaceStorage model object
	 */
	public static function newFromArticle(Page $article) {
		return self::newFromId($article->getId());
	}

	/**
	 * Return PlaceStorage model for given title
	 *
	 * @param Title $title title object
	 * @return PlaceStorage model object
	 */
	public static function newFromTitle(Title $title) {
		return self::newFromId($title->getArticleID());
	}

	/**
	 * Set place model to be stored
	 *
	 * @param PlaceModel $model model encapsulating geo tag
	 */
	public function setModel(PlaceModel $model) {
		$this->model = $model;
	}

	/**
	 * Return place model
	 *
	 * @return PlaceModel model encapsulating geo tag
	 */
	public function getModel() {
		return $this->model;
	}

	/**
	 * Read geo data from database / memcache when the storage object is constructed
	 */
	private function read() {
		wfProfileIn(__METHOD__);

		$cords = $this->memc->get($this->getMemcKey());

		if (empty($cords)) {
			wfDebug(__METHOD__ . " - memcache miss for #{$this->pageId}\n");

			$dbr = $this->getDB();
			$res = $dbr->select(self::WPP_TABLE, array('propname', 'props'), array(
				'page_id' => $this->pageId,
				'propname' => array(WPP_PLACES_LATITUDE, WPP_PLACES_LONGITUDE),
			), __METHOD__);

			$cords = array(
				'lat' => false,
				'lon' => false,
			);

			while($row = $res->fetchObject()) {
				$value = (float) $row->props;

				switch($row->propname) {
					case WPP_PLACES_LATITUDE:
						$cords['lat'] = $value;
						break;

					case WPP_PLACES_LONGITUDE:
						$cords['lon'] = $value;
						break;
				}
			}

			$this->memc->set($this->getMemcKey(), $cords, self::CACHE_TTL);
		}
		else {
			wfDebug(__METHOD__ . " - memcache hit for #{$this->pageId}\n");
		}
		$cords['pageId'] = $this->pageId;
		$this->setModel(PlaceModel::newFromAttributes($cords));

		// this will be checked in store() method
		$this->initialCords = $this->getModel()->getLatLon();

		if (!$this->getModel()->isEmpty()) {
			wfDebug(__METHOD__ . " - geo data for #{$this->pageId}: " . implode(',', $this->initialCords) ."\n");
		}

		wfProfileOut(__METHOD__);
	}

	/**
	 * Store geo data in database and refresh memcache entry.
	 *
	 * Database will not be updated if geo tag wasn't changed
	 */
	public function store() {
		wfProfileIn(__METHOD__);

		$dbw = $this->getDB(DB_MASTER);
		$cords = $this->model->getLatLon();

		#wfDebug(__METHOD__ . json_encode(array($this->initialCords, $cords)) . "\n");

		// do database queries only if something has changed
		if ($this->initialCords !== $cords) {
			if ($this->model->isEmpty()) {
				// model has no data - remove props entry
				$dbw->delete(self::WPP_TABLE, array(
					'page_id' => $this->pageId,
					'propname' => array(WPP_PLACES_LATITUDE, WPP_PLACES_LONGITUDE)
				), __METHOD__);
			}
			else {
				// model has data - update props entry
				$dbw->replace(self::WPP_TABLE, false /* $uniqueIndexes */, array(
					array(
						'page_id' =>  $this->pageId,
						'propname' => WPP_PLACES_LATITUDE,
						'props' => $cords['lat'],
					),
					array(
						'page_id' =>  $this->pageId,
						'propname' => WPP_PLACES_LONGITUDE,
						'props' => $cords['lon'],
					),
				), __METHOD__);
			}
			$dbw->commit();

			// update the cache
			$this->memc->set($this->getMemcKey(), $cords, self::CACHE_TTL);
		}

		wfProfileOut(__METHOD__);
	}

	private function getDB($type = DB_SLAVE) {
		return wfGetDB($type, array(), $this->app->wg->DBname);
	}

	private function getMemcKey() {
		return wfMemcKey("place::{$this->pageId}");
	}
}
