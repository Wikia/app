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
		$this->flagTypeId = $params['flagTypeId'];
		return $this->fetchArticlesData();
	}

	/**
	 * Prepare data of articles - title, last revision, link etc.
	 */
	public function fetchArticlesData() {
		$cacheKey = $this->getMemcKey( self::INSIGHTS_MEMC_ARTICLES_KEY, $this->flagTypeId );
		$articlesData = WikiaDataAccess::cache(
			$cacheKey,
			self::INSIGHTS_MEMC_TTL,
			[ $this, 'fetchArticlesDataCacheCallback' ]
		);

		return $articlesData;
	}

	/**
	 * Callback method that retrieves and prepares pages data to be cached
	 * @return array
	 */
	public function fetchArticlesDataCacheCallback() {
		$articlesData = [];
		$flaggedPages = $this->sendFlaggedPagesRequest();

		if ( count($flaggedPages) > 0 ) {
			$articlesData = $this->prepareData( $flaggedPages );

			if ( $this->arePageViewsRequired() ) {
				$articlesIds = array_keys( $articlesData );
				$pageViewsData = $this->getPageViewsData( $articlesIds );
				$articlesData = $this->assignPageViewsData( $articlesData, $pageViewsData );
			}
		}

		return $articlesData;
	}

	/**
	 * @return array
	 */
	private function sendFlaggedPagesRequest() {
		$app = F::app();

		/* Select first type id by default */
		if ( empty( $this->flagTypeId ) ) {
			$flagTypes = $app->sendRequest( 'FlagsApiController', 'getFlagTypes' )->getData()['data'];
			$this->flagTypeId = current($flagTypes)['flag_type_id'];
		}

		/* Get to list of pages marked with flags */
		$flaggedPages = $app->sendRequest(
			'FlaggedPagesApiController',
			'getFlaggedPages',
			[ 'flagTypeId' => $this->flagTypeId ]
		)->getData()['data'];

		$this->setTotal( count( $flaggedPages ) );
		$flaggedPages = array_slice( $flaggedPages, $this->getOffset(), $this->getLimitResultsNum() );

		return $flaggedPages;
	}

	/**
	 * @param array $pagesIds Array of pages Ids
	 * @return array
	 * e.g. result
	 * [
	 * 	{page_id} => [
	 * 		'link' => {link_to_page},
	 * 		'metadata' => ['lastRevision'=>{array_with_revision_data} ] @see \InsightsPageModel::prepareRevisionData
	 * 	]
	 * ]
	 * @throws MWException
	 */
	public function prepareData( $pagesIds ) {
		$data = [];

		foreach ( $pagesIds as $pageId ) {
			$article = [];

			$title = Title::newFromID( $pageId );
			$params = $this->getUrlParams();
			$article['link'] = InsightsHelper::getTitleLink( $title, $params );

			$lastRev = $title->getLatestRevID();
			$rev = Revision::newFromId( $lastRev );
			if ( $rev ) {
				$article['metadata']['lastRevision'] = $this->prepareRevisionData( $rev );
			}

			$data[ $title->getArticleID() ] = $article;
		}
		return $data;
	}
}
