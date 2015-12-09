<?php
/**
 * Abstract class that defines necessary set of methods for Insights page models
 */
use Wikia\Logger\Loggable;

abstract class InsightsPageModel extends InsightsModel {
	use Loggable;

	private $template = 'subpageList';
	private $insightsSorting;

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
	public function getContent( $params, $offset, $limit ) {


		$content = [];

		/**
		 * 1. Prepare data of articles - title, last revision, link etc.
		 */
		$articlesData = $this->fetchArticlesData();

		if ( !empty( $articlesData ) ) {

			/**
			 * 2. Slice a sorting table to retrieve a page
			 */

			$data = ( new InsightsSorting() )->getSortedData( $articlesData, $params );
			$ids = array_slice( $data, $offset, $limit, true );

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
	 * Fetches page views data for a given set of articles. The data includes
	 * number of views for the last four time ids (data points).
	 *
	 * @param array $articlesIds An array of IDs of articles to fetch views for
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
					$article['metadata']['wantedBy'] = [
						'message' => $this->wlhLinkMessage(),
						'value' => (int)$row->value,
						'url' => $this->getWlhUrl( $title ),
					];
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

		//( new InsightsSorting() )->createSortingArrays();

		return $articlesData;
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
	 * Returns a link to a WhatLinksHere page for the given Title.
	 * @param Title $title The target article's title object
	 * @return string
	 */
	public function getWlhUrl( Title $title ) {
		return SpecialPage::getTitleFor( 'Whatlinkshere', $title->getPrefixedText() )->getFullUrl();
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
}
