<?php

class PlaceStorage {

	const WPP_TABLE = 'page_wikia_props';

	private $pageId;
	private $app;
	private $model;

	public function __construct(WikiaApp $app, PlaceModel $model) {
		$this->app = $app;
		$this->model = $model;
	}

	public static function newFromArticle(Article $article) {

	}

	public function setModel(PlaceModel $model) {
		$this->model = $model;
	}

	public function getModel(PlaceModel $model) {
		$this->model = $model;
	}

	private function read() {
		$db = $this->getDB();
		$res = $db->select(self::WPP_TABLE, array('propname', 'props'), array(
			'page_id' => $this->pageId,
			'propname' => array(WPP_PLACES_LATITUDE, WPP_PLACES_LONGITUDE),
		), __METHOD__);

		while($row = $res->fetchObject()) {
			$value = (float) $row->props;

			switch($row->propname) {
				case WPP_PLACES_LATITUDE:
					$this->model->setLat($value);
					break;

				case WPP_PLACES_LONGITUDE:
					$this->model->setLon($value);
					break;
			}
		}
	}

	public function store() {
		$db = $this->getDB(DB_MASTER);
		$db->replace(self::WPP_TABLE, false /* $uniqueIndexes */, array(
			array(
				'page_id' =>  $this->pageId,
				'propname' => WPP_PLACES_LATITUDE,
				'props' => $this->model->getLat()
			),
			array(
				'page_id' =>  $this->pageId,
				'propname' => WPP_PLACES_LONGITUDE,
				'props' => $this->model->getLon()
			),
		), __METHOD__);
		$db->commit();
	}

	private function getDB($type = DB_SLAVE) {
		return $this->app->wf->GetDB($type);
	}

}
