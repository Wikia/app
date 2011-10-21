<?php

class PlaceStorage {

	const WPP_TABLE = 'page_wikia_props';
	const CACHE_TTL = 86400; // a day

	private $app;
	private $memc;

	private $pageId;
	private $model;

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

		$this->setModel(F::build('PlaceModel', array($cords), 'newFromAttributes'));

		wfProfileOut(__METHOD__);
	}

	public function store() {
		wfProfileIn(__METHOD__);

		$cords = $this->model->getLatLon();

		$dbw = $this->getDB(DB_MASTER);
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
		$dbw->commit();

		// update the cache
		$this->memc->set($this->getMemcKey(), $cords, self::CACHE_TTL);

		wfProfileOut(__METHOD__);
	}

	private function getDB($type = DB_SLAVE) {
		return $this->app->wf->GetDB($type, array(), $this->app->wg->DBname);
	}

	private function getMemcKey() {
		return $this->app->wf->MemcKey("place::{$this->pageId}");
	}
}
