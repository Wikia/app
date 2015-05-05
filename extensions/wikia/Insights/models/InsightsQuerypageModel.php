<?php

/**
 * Class QueryPagesModel
 *
 * A base model for subpages that extend the QueryPage class
 */
abstract class InsightsQuerypageModel extends InsightsModel {
	const
		INSIGHTS_MEMC_PREFIX = 'insights',
		INSIGHTS_MEMC_VERSION = '1.0',
		INSIGHTS_MEMC_ARTICLES_KEY = 'articlesData',
		INSIGHTS_LIST_MAX_LIMIT = 100;

	private
		$queryPageInstance,
		$template = 'subpageList',
		$cacheTtl,
		$offset = 0,
		$limit = 100,
		$total = 0,
		$page = 0,
		$sortingArray;

	public
		$sorting = [
			'pv7' => SORT_NUMERIC,
			'pv28' => SORT_NUMERIC,
			'pvDiff' => SORT_NUMERIC,
		];

	abstract function getDataProvider();
	abstract function isItemFixed( Title $title );
	abstract function getInsightType();

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

	/**
	 * @return QueryPage An object of a QueryPage's child class
	 */
	protected function getQueryPageInstance() {
		return $this->queryPageInstance;
	}

	/**
	 * @return string A name of the page's template
	 */
	public function getTemplate() {
		return $this->template;
	}

	/**
	 * @return bool
	 */
	public function arePageViewsRequired() {
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
		];
		return $data;
	}

	/**
	 * Get list of articles related to the given QueryPage category
	 *
	 * @return array
	 */
	public function getContent( $params ) {
		$this->queryPageInstance = $this->getDataProvider();
		$content = [];

		/**
		 * 1. Prepare data of articles - title, last revision, link etc.
		 */
		$articlesData = $this->fetchArticlesData();

		if ( !empty( $articlesData ) ) {
			$this->total = count( $articlesData );

			/**
			 * 2. Slice a sorting table to retrieve a page
			 */
			$this->prepareParams( $params );
			if ( !isset( $this->sortingArray ) ) {
				$this->sortingArray = array_keys( $articlesData );
			}
			$ids = array_slice( $this->sortingArray, $this->offset, $this->limit, true );

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
	private function prepareParams( $params ) {
		global $wgMemc;

		if ( isset( $params['sort'] ) && isset( $this->sorting[ $params['sort'] ] ) ) {
			$this->sortingArray = $wgMemc->get( $this->getMemcKey( $params['sort'] ) );
		}

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
	 * The main method that assembles all data on articles that should be displayed
	 * on a given Insights subpage
	 *
	 * @return Mixed|null An array with data of articles i.e. title, url, metadata etc.
	 */
	public function fetchArticlesData() {
		$cacheKey = $this->getMemcKey( self::INSIGHTS_MEMC_ARTICLES_KEY );
		$this->cacheTtl = 259200; // Cache for 3 days
		$articlesData = WikiaDataAccess::cache( $cacheKey, $this->cacheTtl, function () {
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
			$wgMemc->set( $cacheKey, $articleData, $this->cacheTtl );
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

			if ( $key = array_search( $articleId, $sortingArray ) !== false ) {
				unset( $sortingArray[$key] );
				$wgMemc->set( $cacheKey, $sortingArray, $this->cacheTtl );
			}
		}
	}

	/**
	 * Fetches page views data for a given set of articles. The data includes
	 * number of views for the last four time ids (data points).
	 *
	 * @param $articlesIds An array of IDs of articles to fetch views for
	 * @return array An array with views for the last four time ids
	 */
	public function getPageViewsData( $articlesIds ) {
		global $wgCityId;
		/**
		 * Get pv for the last 4 Sundays
		 */
		$pvTimes = InsightsHelper::getLastFourTimeIds();

		$pvData = [];

		foreach( $pvTimes as $timeId ) {
			$pvData[] = DataMartService::getPageViewsForArticles( $articlesIds, $timeId, $wgCityId );
		}

		return $pvData;
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

		arsort( $sortingArray, $this->sorting[ $key ] );
		$cacheKey = $this->getMemcKey( $key );

		$wgMemc->set( $cacheKey, array_keys( $sortingArray ), $this->cacheTtl );
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
			$this->createSortingArray( $sortingData[ $key ], $key );
		}

		return $articlesData;
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

				$title = Title::newFromText( $row->title );
				$article['link'] = InsightsHelper::getTitleLink( $title, $params );

				$lastRev = $title->getLatestRevID();
				$rev = Revision::newFromId( $lastRev );

				if ( $rev ) {
					$article['metadata']['lastRevision'] = $this->prepareRevisionData( $rev );
				}

				if ( $this->arePageViewsRequired() ) {
					$article['metadata']['pv7'] = 0;
					$article['metadata']['pv28'] = 0;
					$article['metadata']['pvDiff'] = 0;
				}

				$data[ $title->getArticleID() ] = $article;
			}
		}

		return $data;
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
	 * @param string $type A key of a Querypage
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

	/**
	 * Get memcache key for insights
	 *
	 * @param String $params
	 * @return String
	 */
	private function getMemcKey( $params ) {
		return wfMemcKey(
			self::INSIGHTS_MEMC_PREFIX,
			$this->getInsightType(),
			$params,
			self::INSIGHTS_MEMC_VERSION
		);
	}
}
