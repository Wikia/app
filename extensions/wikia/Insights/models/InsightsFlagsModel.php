<?php

/**
 * Data model specific to a subpage with a list of pages marked with flags
 */
class InsightsFlagsModel extends InsightsPageModel {
	const INSIGHT_TYPE = 'flags';

	public $loopNotificationConfig = [
		'displayFixItMessage' => false,
	];

	public function getInsightType() {
		return self::INSIGHT_TYPE;
	}

	/**
	 * A key of a message that wraps the number of pages referring to each item of the list.
	 *
	 * @return string
	 */
	public function wlhLinkMessage() {
		return 'insights-used-on';
	}

	public function arePageViewsRequired() {
		return false;
	}

	/**
	 * Get a type of a subpage only, we want a user to be directed to view.
	 * @return array
	 */
	public function getUrlParams() {
		return $this->getInsightParam();
	}

	/**
	 * Get list of articles related to the given QueryPage category
	 *
	 * @return array
	 */
	public function getContent( $params ) {
		$this->preparePaginationParams( $params );

		$articlesData = $this->fetchArticlesData();

		return $articlesData;
	}

	/**
	 * Prepare data of articles - title, last revision, link etc.
	 */
	public function fetchArticlesData() {
		$cacheKey = $this->getMemcKey( self::INSIGHTS_MEMC_ARTICLES_KEY );
		$articlesData = WikiaDataAccess::cache( $cacheKey, self::INSIGHTS_MEMC_TTL, function () {
			$res = $this->sendQuery();

			if ( count($res) > 0 ) {
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


	private function sendQuery() {
		/**
		 * Sends a request to the FlaggedPagesApiController to list of pages marked with flags
		 * with and without instances to display in the edit form.
		 * @return WikiaResponse
		 */
		$flaggedPages = F::app()->sendRequest( 'FlaggedPagesApiController', 'getFlaggedPages' )->getData()['data'];
		$this->setTotal( count( $flaggedPages ) );
		$flaggedPages = array_slice( $flaggedPages, $this->getOffset(), $this->getLimitResultsNum() );

		$result = [];
		foreach ( $flaggedPages as $pageId ) {
			$title = Title::newFromID( $pageId );
			$result[] = [
				InsightsFlagsModel::INSIGHT_TYPE,
				0,
				$title->getNamespace(),
				$title->getText()
			];
		}
		return $result;
	}
	public function prepareData( $res ) {
		$data = [];

		foreach ( $res as $resItem ) {
			$titleText = $resItem[3];
			$namespace = $resItem[2];
			if ( $titleText ) {
				$article = [];
				$params = $this->getUrlParams();

				$title = Title::newFromText( $titleText, $namespace );
				$article['link'] = InsightsHelper::getTitleLink( $title, $params );

				$lastRev = $title->getLatestRevID();
				$rev = Revision::newFromId( $lastRev );

				if ( $rev ) {
					$article['metadata']['lastRevision'] = $this->prepareRevisionData( $rev );
				}

//				if ( $this->arePageViewsRequired() ) {
//					$article['metadata']['pv7'] = 0;
//					$article['metadata']['pv28'] = 0;
//					$article['metadata']['pvDiff'] = 0;
//				}

				$data[ $title->getArticleID() ] = $article;
			}
		}
		return $data;
	}
}
