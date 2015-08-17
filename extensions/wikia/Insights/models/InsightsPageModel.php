<?php
/**
 * Abstract class that defines necessary set of methods for Insights page models
 */
use Wikia\Logger\Loggable;

abstract class InsightsPageModel extends InsightsModel {
	use Loggable;

	const
		INSIGHTS_MEMC_PREFIX = 'insights',
		INSIGHTS_MEMC_VERSION = '1.2',
		INSIGHTS_MEMC_TTL = 259200, // Cache for 3 days
		INSIGHTS_MEMC_ARTICLES_KEY = 'articlesData',
		INSIGHTS_LIST_MAX_LIMIT = 100,
		INSIGHTS_DEFAULT_SORTING = 'pv7';

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
		];

	private
		$template = 'subpageList',
		/** @var int Counted shift based on pagination page number and limit of items per page */
		$offset = 0,
		/** @var int Number of items per pagination page */
		$limit = self::INSIGHTS_LIST_MAX_LIMIT,
		/** @var int Number of all items in model - used for pagination */
		$total = 0,
		/** @var int Number of current pagination page */
		$page = 0,
		$sortingArray;


	public function getTotalResultsNum() {
		return $this->total;
	}

	public function getLimitResultsNum() {
		return $this->limit;
	}

	public function getOffset() {
		return $this->offset;
	}

	public function getPage() {
		return $this->page;
	}

	public function getPaginationUrlParams() {
		return [];
	}

	/**
	 * @return string A name of the page's template
	 */
	public function getTemplate() {
		return $this->template;
	}

	/**
	 * Set size of full data set of model
	 * @param int $total
	 */
	public function setTotal( $total) {
		$this->total = $total;
	}

	public function getDefaultSorting() {
		return self::INSIGHTS_DEFAULT_SORTING;
	}

	/**
	 * @return bool
	 */
	public function arePageViewsRequired() {
		return true;
	}

	public function hasAltAction() {
		return false;
	}

	public function getAltAction( Title $title ) {
		return [];
	}

	/**
	 * Tells whether link to Special:WhatLinksHere should be displayed for insight type
	 * @return bool
	 */
	public function isWlhLinkRequired() {
		return false;
	}

	public function purgeCacheAfterUpdateTask() {
		return true;
	}

	/**
	 * Returns an array of boolean values that you can use
	 * to toggle columns of a subpage's table view
	 * (e.g. turn the column with number of views on or off)
	 *
	 * @return array An array of boolean values
	 */
	public function getViewData() {
		$data['display'] = [
			'pageviews'	=> $this->arePageViewsRequired(),
			'altaction'	=> $this->hasAltAction(),
		];
		return $data;
	}

	/**
	 * Get list of articles related to the given QueryPage category
	 *
	 * @return array
	 */
	public function getContent( $params ) {
		global $wgMemc;

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
	 * Overrides the default values used for pagination
	 *
	 * @param $params An array of URL parameters
	 */
	protected function preparePaginationParams( $params ) {
		if ( isset( $params['limit'] ) ) {
			if ( $params['limit'] <= self::INSIGHTS_LIST_MAX_LIMIT ) {
				$this->limit = intval( $params['limit'] );
			} else {
				$this->limit = self::INSIGHTS_LIST_MAX_LIMIT;
			}
		}

		if ( isset( $params['page'] ) ) {
			$page = intval( $params['page'] );
			$this->page = --$page;
			$this->offset = $this->page * $this->limit;
		}
	}

	/**
	 * Fetches page views data for a given set of articles. The data includes
	 * number of views for the last four time ids (data points).
	 *
	 * @param $articlesIds An array of IDs of articles to fetch views for
	 * @return array An array with views for the last four time ids
	 */
	public function getPageViewsData( array $articlesIds ) {
		global $wgCityId;

		$pvData = [];
		if ( empty( $articlesIds ) ) {
			return $pvData;
		}

		/**
		 * Get pv for the last 4 Sundays
		 */
		$pvTimes = InsightsHelper::getLastFourTimeIds();

		foreach ( $pvTimes as $timeId ) {
			$pvData[] = DataMartService::getPageViewsForArticles( $articlesIds, $timeId, $wgCityId );
		}

		return $pvData;
	}

	/**
	 * Prepares all data in a format that is easy to use for display.
	 *
	 * @param $res Results to display
	 * @return array
	 * @throws MWException
	 */
	public function prepareData( $res ) {
		$data = [];
		$dbr = wfGetDB( DB_SLAVE );
		while ( $row = $dbr->fetchObject( $res ) ) {
			if ( $row->title ) {
				$article = [];
				$params = $this->getUrlParams();

				$title = Title::newFromText( $row->title, $row->namespace );
				if ( $title === null ) {
					$this->error( 'InsightsPageModel received reference to non existent page' );
					continue;
				}
				$article['link'] = InsightsHelper::getTitleLink( $title, $params );

				$lastRev = $title->getLatestRevID();
				$rev = Revision::newFromId( $lastRev );

				if ( $rev ) {
					$article['metadata']['lastRevision'] = $this->prepareRevisionData( $rev );
				}

				if ( $this->isWlhLinkRequired() ) {
					$article['metadata']['wantedBy'] = $this->makeWlhLink( $title, $row );
				}

				if ( $this->arePageViewsRequired() ) {
					$article['metadata']['pv7'] = 0;
					$article['metadata']['pv28'] = 0;
					$article['metadata']['pvDiff'] = 0;
				}

				if ( $this->hasAltAction() ) {
					$article['altaction'] = $this->getAltAction( $title );
				}

				$data[ $title->getArticleID() ] = $article;
			}
		}

		return $data;
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

		foreach ( $this->sorting as $key => $item ) {
			if ( isset( $sortingData[$key] ) ) {
				$this->createSortingArray( $sortingData[ $key ], $key );
			}
		}

		return $articlesData;
	}

	/**
	 * Sorts an array and sets it as a value in memcache. Article IDs are
	 * keys in the array.
	 *
	 * @param $sortingArray The input array with
	 * @param string $key Memcache key
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
	 * Get data about revision
	 * Who and when made last edition
	 *
	 * @param Revision $rev
	 * @return mixed
	 */
	public function prepareRevisionData( Revision $rev ) {
		$data['timestamp'] = wfTimestamp( TS_UNIX, $rev->getTimestamp() );

		$user = $rev->getUserText();

		if ( $rev->getUser() ) {
			$userpage = Title::newFromText( $user, NS_USER )->getFullURL();
		} else {
			$userpage = SpecialPage::getTitleFor( 'Contributions', $user )->getFullUrl();
		}

		$data['username'] = $user;
		$data['userpage'] = $userpage;

		return $data;
	}

	/**
	 * Get a type of a subpage and an edit parameter
	 * @return array
	 */
	public function getUrlParams() {
		$params = array_merge(
			InsightsHelper::getEditUrlParams(),
			$this->getInsightParam()
		);

		return $params;
	}

	/**
	 * Insights loop notification shown in view mode
	 * @return string
	 */
	public function getInProgressNotificationParams() {
		return '';
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

		foreach ( $this->sorting as $key => $item ) {
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

	public function purgeInsightsCache() {
		global $wgMemc;

		$cacheKey = $this->getMemcKey( self::INSIGHTS_MEMC_ARTICLES_KEY );

		$wgMemc->delete( $cacheKey );
	}

	/**
	 * Get memcache key for insights
	 *
	 * @param String $params
	 * @return String
	 */
	protected function getMemcKey( $params ) {
		return wfMemcKey(
			self::INSIGHTS_MEMC_PREFIX,
			$this->getInsightType(),
			$this->getInsightCacheParams(),
			$params,
			self::INSIGHTS_MEMC_VERSION
		);
	}
}
