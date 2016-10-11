<?php

class EmbeddableDiscussionsApiController extends WikiaApiController {
	const SORT_BY_WIKIFACTORY = 'wgEmbeddableDiscussionsSortBy';
	const SELECTED_CATEGORIES_WIKIFACTORY = 'wgEmbeddableDiscussionsSelectedCategories';

	const SORT_BY_KEY = "sortBy";
	const ALL_CATEGORIES_KEY = 'allCategories';
	const SELECTED_CATEGORIES_KEY = 'selectedCategories';

	const SORT_BY_LATEST = "latest";
	const SORT_BY_TRENDING = "trending";

	private $categories;

	public function __construct() {
		global $wgCityId;

		parent::__construct();

		$this->categories = ( new DiscussionsThreadModel( $wgCityId ) )->getAllCategories();
	}

	public function readSortBy() {
		$savedValue = empty( $GLOBALS[self::SORT_BY_WIKIFACTORY] ) ? false : $GLOBALS[self::SORT_BY_WIKIFACTORY];

		if ( !$savedValue ||  $savedValue === self::SORT_BY_LATEST ) {
			return self::SORT_BY_LATEST;
		} elseif ( $savedValue === self::SORT_BY_TRENDING ) {
			return self::SORT_BY_TRENDING;
		}

		return self::SORT_BY_LATEST;
	}

	private function saveSortBy( $sortBy ) {
		WikiFactory::setVarByName( self::SORT_BY_WIKIFACTORY, $this->wg->CityId, $sortBy );
	}

	public function readSelectedCategories() {
		$savedValue = empty( $GLOBALS[self::SELECTED_CATEGORIES_WIKIFACTORY] ) ?
			false : $GLOBALS[self::SELECTED_CATEGORIES_WIKIFACTORY];

		if ( !$savedValue ) {
			return [];
		}

		return $savedValue;
	}

	private function saveSelectedCategories( $selectedCategories ) {
		WikiFactory::setVarByName( self::SELECTED_CATEGORIES_WIKIFACTORY, $this->wg->CityId, $selectedCategories );
	}

	public function getCommunityPageSettings() {
		$this->response->setData( [
			self::SORT_BY_KEY => $this->readSortBy(),
			self::ALL_CATEGORIES_KEY => $this->categories,
			self::SELECTED_CATEGORIES_KEY => $this->readSelectedCategories(),
		] );
	}

	public function saveCommunityPageSettings() {
		$params = $this->request->getParams();

		if ( !empty( $params[self::SORT_BY_KEY] ) ) {
			$this->saveSortBy( $params[self::SORT_BY_KEY] );
		}

		if ( empty( $params[self::SELECTED_CATEGORIES_KEY] ) ) {
			$this->saveSelectedCategories( [] );
		} else {
			$this->saveSelectedCategories( $params[self::SELECTED_CATEGORIES_KEY] );
		}

		$this->response->setData( [
			'error' => false,
		] );
	}
}
