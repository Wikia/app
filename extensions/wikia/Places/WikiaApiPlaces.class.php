<?php

/**
 * WikiaApiPlaces
 *
 * This API function allows access to geolocation data
  */

class WikiaApiPlaces extends ApiBase {

	public function __construct( $main, $action ) {
		parent :: __construct( $main, $action);
	}

	public function execute() {
		wfProfileIn(__METHOD__);

		$placesModel = F::build('PlacesModel');
		$params = $this->extractRequestParams();
		$places = array();

		// get geodata from article by its ID
		if (isset($params['pageid'])) {
			$storage = F::build('PlaceStorage', array($params['pageid']), 'newFromId');
			$places = array(
				$storage->getModel()
			);
		}
		// get geodata from article by its title
		elseif (isset($params['title'])) {
			$title = F::build('Title', array($params['title']), 'newFromText');

			if ($title instanceof Title) {
				$storage = F::build('PlaceStorage', array($title), 'newFromTitle');
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
			$title = F::build('Title', array($params['related']), 'newFromText');

			if ($title instanceof Title) {
				$places = $placesModel->getFromCategoriesByTitle($title);
			}
		}
		// get geodata from all tagged articles on this wiki
		else {
			$places = $placesModel->getAll();
		}

		// generate results
		$rows = array();

		foreach($places as $place) {
			$title = Title::newFromID($place->getPageId());

			$rows[] = array(
				'pageid' => $place->getPageId(),
				'title' => ($title instanceof Title) ? $title->getPrefixedText() : '',
				'lat' => $place->getLat(),
				'lan' => $place->getLon(),
			);
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
		);
	}

	public function getParamDescription() {
		return array (
			'pageid' => 'article id (integer)',
			'title' => 'article title (string)',
			'category' => 'articles category (string)',
			'related' => 'get places related to a given title (string)',
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
		);
	}

	public function getVersion() {
		return '$Id$';
	}
}
