<?php
/**
 * Abstract class that defines necessary set of methods for Insights page models
 */
abstract class InsightsPageModel extends InsightsModel {
	const
		INSIGHTS_MEMC_PREFIX = 'insights',
		INSIGHTS_MEMC_VERSION = '1.1',
		INSIGHTS_MEMC_TTL = 259200, // Cache for 3 days
		INSIGHTS_MEMC_ARTICLES_KEY = 'articlesData',
		INSIGHTS_LIST_MAX_LIMIT = 100,
		INSIGHTS_DEFAULT_SORTING = 'pv7';

	private
		$template = 'subpageList',
		/** @var int Counted shift based on pagination page number and limit of items per page */
		$offset = 0,
		/** @var int Number of items per pagination page */
		$limit = self::INSIGHTS_LIST_MAX_LIMIT,
		/** @var int Number of all items in model - used for pagination */
		$total = 0,
		/** @var int Number of current pagination page */
		$page = 0;

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

	public function purgeInsightsCache() {
		global $wgMemc;

		// @TODO Fix purging per flag type
		$cacheKey = $this->getMemcKey( self::INSIGHTS_MEMC_ARTICLES_KEY );

		$wgMemc->delete( $cacheKey );
	}

	/**
	 * Get memcache key for insights
	 *
	 * @param String $params
	 * @param null|int $flagTypeId
	 * @return String
	 */
	protected function getMemcKey( $params ) {
		return wfMemcKey(
			self::INSIGHTS_MEMC_PREFIX,
			$this->getInsightType(),
			$params,
			self::INSIGHTS_MEMC_VERSION
		);
	}
}
