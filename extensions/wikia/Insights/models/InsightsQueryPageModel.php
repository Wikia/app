<?php

/**
 * Abstract class that defines necessary set of methods for Insights QueryPage models
 */
abstract class InsightsQueryPageModel extends InsightsPageModel {

	private
		$sortingArray;

	protected
		$queryPageInstance;

	public
		$sorting = [
			'pv7' => [
				'sortType' => SORT_NUMERIC,
			],
			'pv28' => [
				'sortType' => SORT_NUMERIC,
			],
			'pvDiff' => [
				'sortType' => SORT_NUMERIC,
				'metadata' => 'pv7',
			]
		],
		$loopNotificationConfig = [
			'displayFixItMessage' => true,
		];

	abstract function getDataProvider();

	public function getDefaultSorting() {
		return self::INSIGHTS_DEFAULT_SORTING;
	}

	/**
	 * @return QueryPage An object of a QueryPage's child class
	 */
	protected function getQueryPageInstance() {
		return $this->queryPageInstance;
	}

	public function wlhLinkMessage() {
		return 'insights-wanted-by';
	}

	public function purgeCacheAfterUpdateTask() {
		return true;
	}

	/**
	 * Returns a whole config for loop notification mechanism or its single property
	 * @param string $singleProperty
	 * @return string|array
	 */
	public function getLoopNotificationConfig( $singleProperty = '' ) {
		if ( !empty( $singleProperty )
			&& isset( $this->loopNotificationConfig[$singleProperty] )
		) {
			return $this->loopNotificationConfig[$singleProperty];
		}

		return $this->loopNotificationConfig;
	}

	/**
	 * Get list of articles related to the given QueryPage category
	 *
	 * @return array
	 */
	public function getContent( $params ) {
		global $wgMemc;

		$this->queryPageInstance = $this->getDataProvider();
		$content = [];

		/**
		 * 1. Prepare data of articles - title, last revision, link etc.
		 */
		$articlesData = $this->fetchArticlesData();

		if ( !empty( $articlesData ) ) {
			$this->setTotal( count( $articlesData ) );

			/**
			 * 2. Slice a sorting table to retrieve a page
			 */
			$this->prepareParams( $params );
			if ( !isset( $this->sortingArray ) ) {
				if ( $this->arePageViewsRequired() ) {
					$this->sortingArray = $wgMemc->get($this->getMemcKey( self::INSIGHTS_DEFAULT_SORTING ) );
				} else {
					$this->sortingArray = array_keys( $articlesData );
				}
			}
			$ids = array_slice( $this->sortingArray, $this->getOffset(), $this->getLimitResultsNum(), true );

			/**
			 * 3. Populate $content array with data for each article id
			 */
			foreach ( $ids as $id ) {
				$content[] = $articlesData[$id];
			}
		}

		return $content;
	}

	/**
	 * Overrides the default values used for sorting and pagination
	 *
	 * @param $params An array of URL parameters
	 */
	protected function prepareParams( $params ) {
		global $wgMemc;

		if ( isset( $params['sort'] ) && isset( $this->sorting[ $params['sort'] ] ) ) {
			$this->sortingArray = $wgMemc->get( $this->getMemcKey( $params['sort'] ) );
		}

		$this->preparePaginationParams( $params );
	}

	/**
	 * The main method that assembles all data on articles that should be displayed
	 * on a given Insights subpage
	 *
	 * @return Mixed|null An array with data of articles i.e. title, url, metadata etc.
	 */
	public function fetchArticlesData() {
		$cacheKey = $this->getMemcKey( self::INSIGHTS_MEMC_ARTICLES_KEY );
		$articlesData = WikiaDataAccess::cache( $cacheKey, self::INSIGHTS_MEMC_TTL, function () {
			$res = $this->queryPageInstance->doQuery();

			if ( $res->numRows() > 0 ) {
				$articlesData = $this->prepareData( $res );

				if ( $this->arePageViewsRequired() ) {
					$articlesIds = array_keys( $articlesData );
					$pageViewsData = $this->getPageViewsData( $articlesIds );
					$articlesData = $this->assignPageViewsData( $articlesData, $pageViewsData );
				}
			}

			return $articlesData;
		} );

		return $articlesData;
	}

	/**
	 * Updates the cached articleData and sorting array
	 *
	 * @param int $articleId
	 */
	public function updateInsightsCache( $articleId ) {
		$this->updateArticleDataCache( $articleId );
		$this->updateSortingCache( $articleId );
	}

	/**
	 * Removes a fixed article from the articleData array
	 *
	 * @param int $articleId
	 */
	private function updateArticleDataCache( $articleId ) {
		global $wgMemc;

		$cacheKey = $this->getMemcKey( self::INSIGHTS_MEMC_ARTICLES_KEY );
		$articleData = $wgMemc->get( $cacheKey );

		if ( isset( $articleData[$articleId] ) ) {
			unset( $articleData[$articleId] );
			$wgMemc->set( $cacheKey, $articleData, self::INSIGHTS_MEMC_TTL );
		}
	}

	/**
	 * Removes a fixed article from the sorting arrays
	 *
	 * @param int $articleId
	 */
	private function updateSortingCache( $articleId ) {
		global $wgMemc;

		foreach ( $this->sorting as $key => $flag ) {
			$cacheKey = $this->getMemcKey( $key );
			$sortingArray = $wgMemc->get( $cacheKey );
			if ( is_array( $sortingArray ) ) {
				$key = array_search( $articleId, $sortingArray );

				if ( $key !== false && $key !== null ) {
					unset( $sortingArray[$key] );
					$wgMemc->set( $cacheKey, $sortingArray, self::INSIGHTS_MEMC_TTL );
				}
			}
		}
	}

	/**
	 * Sorts an array and sets it as a value in memcache. Article IDs are
	 * keys in the array.
	 *
	 * @param $sortingArray The input array with
	 * @param $key Memcache key
	 */
	public function createSortingArray( $sortingArray, $key ) {
		global $wgMemc;

		if ( isset( $this->sorting[ $key ]['sortFunction'] ) ) {
			usort( $sortingArray, $this->sorting[ $key ]['sortFunction'] );
		} else {
			arsort( $sortingArray, $this->sorting[ $key ]['sortType'] );
		}

		$cacheKey = $this->getMemcKey( $key );

		$wgMemc->set( $cacheKey, array_keys( $sortingArray ), self::INSIGHTS_MEMC_TTL );
	}

	/**
	 * Function for sorting list alphabetical
	 */
	public function sortInsightsAlphabetical( $a, $b ) {
		return strcasecmp( $a['link']['text'], $b['link']['text'] );
	}

	/**
	 * Calculates desirable results and aggregates them in an array.
	 * Then, it modifies the articles data array and returns it
	 * with the values assigned to the articles.
	 *
	 * For now the values are:
	 * * PVs from the last week
	 * * PVs from the last 4 weeks
	 * * Views growth from a penultimate week
	 *
	 * @param $articlesData
	 * @param $pageViewsData
	 * @return mixed
	 */
	public function assignPageViewsData( $articlesData, $pageViewsData ) {
		$sortingData = [];

		foreach ( $articlesData as $articleId => $data ) {

			$articlePV = [];

			foreach ( $pageViewsData as $dataPoint ) {
				if ( isset( $dataPoint[ $articleId ] ) ) {
					$articlePV[] = intval( $dataPoint[ $articleId ] );
				} else {
					$articlePV[] = 0;
				}
			}

			$pv28 = array_sum( $articlePV );
			if ( $articlePV[1] != 0 ) {
				$pvDiff = ( $articlePV[0] - $articlePV[1] ) / $articlePV[1];
				$pvDiff = round( $pvDiff, 2 ) * 100;
				$pvDiff .= '%';
			} else {
				$pvDiff = 'N/A';
			}

			$sortingData['pv7'][ $articleId ] = $articlePV[0];
			$articlesData[ $articleId ]['metadata']['pv7'] = $articlePV[0];

			$sortingData['pv28'][ $articleId ] = $pv28;
			$articlesData[ $articleId ]['metadata']['pv28'] = $pv28;

			$sortingData['pvDiff'][ $articleId ] = $pvDiff;
			$articlesData[ $articleId ]['metadata']['pvDiff'] = $pvDiff;

		}

		foreach ( $this->sorting as $key => $flag ) {
			if ( isset( $sortingData[$key] ) ) {
				$this->createSortingArray( $sortingData[ $key ], $key );
			}
		}

		return $articlesData;
	}

	/**
	 * Prepares a link to a Special:WhatLinksHere page
	 * for the article
	 * @param Title $title The target article's title object
	 * @param $result A number of referring links
	 * @param string $message A message key
	 * @return string A URL to the WLH page
	 * @throws MWException
	 */
	public function makeWlhLink( Title $title, $result ) {
		$wlh = SpecialPage::getTitleFor( 'Whatlinkshere', $title->getPrefixedText() );
		$label = wfMessage( $this->wlhLinkMessage() )->numParams( $result->value )->escaped();
		return Linker::link( $wlh, $label );
	}

	/**
	 * Removes an item from the querycache table if it has been fixed
	 *
	 * @param $type A qc_type value
	 * @param Title $title A Title object for the article
	 * @return bool
	 * @throws DBUnexpectedError
	 */
	public function removeFixedItem( $type, Title $title ) {
		$dbw = wfGetDB( DB_MASTER );
		$dbw->delete(
			'querycache',
			[
				'qc_type' => $type,
				'qc_namespace' => $title->getNamespace(),
				'qc_title' => $title->getDBkey(),
			],
			__METHOD__
		);

		$affectedRows = $dbw->affectedRows();
		$dbw->commit( __METHOD__ );

		return $affectedRows > 0;
	}

	/**
	 * Get data for the next element that a user can take care of.
	 *
	 * @param string $type A key of a QueryPage
	 * @param string $articleName A title of an article
	 * @return Array The next item's data
	 */
	public function getNextItem( $type, $articleName ) {
		$next = [];

		$dbr = wfGetDB( DB_SLAVE );
		$articleName = $dbr->strencode( $articleName );

		$res = $dbr->select(
			'querycache',
			'qc_title',
			[ 'qc_type' => ucfirst( $type ), "qc_title != '$articleName'" ],
			'DatabaseBase::select',
			[ 'LIMIT' => 1 ]
		);

		if ( $res->numRows() > 0 ) {
			$row = $dbr->fetchObject( $res );

			$title = Title::newFromText( $row->qc_title );
			$next['link'] = InsightsHelper::getTitleLink( $title, self::getUrlParams() );
		}

		return $next;
	}
}
