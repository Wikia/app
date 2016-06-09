<?php

/**
 * WikiaApiPlaces
 *
 * This API function allows access to geolocation data
  */

class WikiaApiPlaces extends ApiBase {

	/**
	 * Title::newFromText + follow redirects
	 *
	 * @param string $text
	 * @return null|Title
	 * @throws MWException
	 */
	private static function getTitleFromText($text) {
		$title = Title::newFromText($text);

		if ($title instanceof Title) {
			if ($title->isRedirect()) {
				$target = $title->getLinksFrom()[0];

				if ($target instanceof Title) {
					$title = $target;
				}
			}

			return $title;
		}

		return null;
	}

	public function execute() {
		wfProfileIn(__METHOD__);

		$placesModel = new PlacesModel();
		$params = $this->extractRequestParams();
		$places = array();

		// get geodata from article by its ID
		if (isset($params['pageid'])) {
			$storage = PlaceStorage::newFromId($params['pageid']);
			$places = array(
				$storage->getModel()
			);
		}
		// get geodata from article by its title
		elseif (isset($params['title'])) {
			$title = self::getTitleFromText($params['title']);

			if ($title instanceof Title) {
				$storage = PlaceStorage::newFromTitle($title);
				$places = array(
					$storage->getModel()
				);
			}
		}
		// get geodata from articles from given categories (list of categories can be pipe separated)
		elseif (isset($params['category'])) {
			$categories = explode('|', $params['category']);
			$places = $placesModel->getFromCategories($categories);
		}
		// get geodata from articles from given categories (list of categories can be pipe separated)
		elseif (isset($params['related'])) {
			$title = self::getTitleFromText($params['related']);

			if ($title instanceof Title) {
				$places = $placesModel->getFromCategoriesByTitle($title);
			}
		}
		// get geodata from articles that are near by a given article
		elseif (isset($params['nearby'])) {
			$title = self::getTitleFromText($params['nearby']);

			if ($title instanceof Title) {
				$model = PlaceStorage::newFromTitle($title)->getModel();
				$places = $placesModel->getNearby($model, $params['dist'], 250 /* $limit */);
			}
		}
		// get geodata from articles that are near by a given location
		elseif (isset($params['nearbygeo'])) {
			list($lat, $lon) = array_map(
				function($item) {
					return (float) $item;
				},
				explode(',', $params['nearbygeo'], 2)
			);

			$model = PlaceModel::newFromAttributes([
				'lat' => $lat,
				'lon' => $lon,
			]);

			$places = $placesModel->getNearby($model, $params['dist'], 250 /* $limit */);
		}
		// get geodata from all tagged articles on this wiki
		else {
			$all = true;
			$places = $placesModel->getAll();
		}

		// apply limit parameter
		if (empty($all)) {
			$places = array_slice($places, 0, $params['limit']);
		}

		// generate results
		$rows = array();

		foreach($places as $place) {
			$title = Title::newFromID($place->getPageId());

			if ( is_null( $title ) ) {
				continue;
			}

			$row = [
				'pageid' => $place->getPageId(),
				'title' => $title->getPrefixedText(),
				'lat' => $place->getLat(),
				'lan' => $place->getLon(),
			];

			if ( is_int( $place->getDistance() ) ) {
				$row['distance'] = $place->getDistance(); // in meters
			}

			$rows[] = $row;
		}

		$results = $this->getResult();
		$results->setIndexedTagName($rows, 'place');
		$results->addValue('query', 'places', $rows);

		wfProfileOut(__METHOD__);
	}

	public function getAllowedParams() {
		return array (
			'pageid' => array(
				ApiBase :: PARAM_TYPE => 'integer'
			),
			'title' => array(
				ApiBase :: PARAM_TYPE => 'string'
			),
			'category' => array(
				ApiBase :: PARAM_TYPE => 'string'
			),
			'related' => array(
				ApiBase :: PARAM_TYPE => 'string'
			),
			'nearby' => array(
				ApiBase :: PARAM_TYPE => 'string'
			),
			'nearbygeo' => array(
				ApiBase :: PARAM_TYPE => 'string'
			),
			'dist' => array(
				ApiBase :: PARAM_TYPE => 'integer',
				ApiBase :: PARAM_DFLT => 5, // [km]
				ApiBase :: PARAM_MAX => 50, // [km]
			),
			'limit' => array(
				ApiBase :: PARAM_ISMULTI => 0,
				ApiBase :: PARAM_TYPE => 'integer',
				ApiBase :: PARAM_DFLT => 25,
				ApiBase :: PARAM_MIN => 25,
			),
		);
	}

	public function getParamDescription() {
		return array (
			'pageid' => 'article id (integer)',
			'title' => 'article title (string)',
			'category' => 'articles category (string)',
			'related' => 'get places related to a given title (string)',
			'nearby' => 'get places that are near by given title (string)',
			'nearbygeo' => 'get places that are near by given a given geolocation (string)',
			'dist' => 'distance to use when finding near by places [in km] (integer)',
			'limit' => 'limit number of records returned',
		);
	}

	public function getDescription() {
		return array('This module provides geolocation data from articles');
	}

	/**
	 * Examples
	 */
	public function getExamples() {
		return array (
			'api.php?action=places',
			'api.php?action=places&title=Bamberka',
			'api.php?action=places&category=Ulice|Place',
			'api.php?action=places&related=Ratusz',
			'api.php?action=places&nearby=Ratusz',
			'api.php?action=places&nearbygeo=52.41124,16.948202', // Ostrów Tumski in Poznań
		);
	}

	public function getVersion() {
		return '$Id$';
	}
}
