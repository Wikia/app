<?php

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

	public function __construct(WikiaApp $app, $pageId) {
		$this->app = $app;
		$this->memc = $this->app->wg->Memc;

		$this->pageId = $pageId;
		$this->model = F::build('PlaceModel');
	}

	public static function newFromId($pageId) {
		$instance = F::build('PlaceStorage', array('app' => F::app(), 'pageId' => $pageId));

		// read data from database
		$instance->read();
		return $instance;
	}

	public static function newFromArticle(Article $article) {
		return self::newFromId($article->getID());
	}

	public static function newFromTitle(Title $title) {
		return self::newFromId($title->getArticleID());
	}

	public function setModel(PlaceModel $model) {
		$this->model = $model;
	}

	public function getModel() {
		return $this->model;
	}

	private function read() {
		wfProfileIn(__METHOD__);

		$cords = $this->memc->get($this->getMemcKey());

		if (empty($cords)) {
			$this->app->wf->Debug(__METHOD__ . " - memcache miss for #{$this->pageId}\n");

			$dbr = $this->getDB();
			$res = $dbr->select(self::WPP_TABLE, array('propname', 'props'), array(
				'page_id' => $this->pageId,
				'propname' => array(WPP_PLACES_LATITUDE, WPP_PLACES_LONGITUDE),
			), __METHOD__);

			$cords = array();

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
			$this->app->wf->Debug(__METHOD__ . " - memcache hit for #{$this->pageId}\n");
		}

		$this->setModel(F::build('PlaceModel', array($cords), 'newFromAttributes'));

		// this will be checked in store() method
		$this->initialCords = $this->getModel()->getLatLon();

		if (!$this->getModel()->isEmpty()) {
			$this->app->wf->Debug(__METHOD__ . " - geo data for #{$this->pageId}: " . implode(',', $this->initialCords) ."\n");
		}

		wfProfileOut(__METHOD__);
	}

	public function store() {
		wfProfileIn(__METHOD__);

		$dbw = $this->getDB(DB_MASTER);
		$cords = $this->model->getLatLon();

		#$this->app->wf->Debug(__METHOD__ . json_encode(array($this->initialCords, $cords)) . "\n");

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
		return $this->app->wf->GetDB($type, array(), $this->app->wg->DBname);
	}

	private function getMemcKey() {
		return $this->app->wf->MemcKey("place::{$this->pageId}");
	}
}
