<?php

/**
 * Data model specific to a subpage with a list of pages marked with flags
 */
class InsightsFlagsModel extends InsightsPageModel {
	const INSIGHT_TYPE = 'flags';

	public
		$flagTypeId,
		$loopNotificationConfig = [
			'displayFixItMessage' => false,
		];

	public function getInsightType() {
		return self::INSIGHT_TYPE;
	}

	public function getInsightCacheParams() {
		return $this->flagTypeId;
	}

	public function getPaginationUrlParams() {
		if ( $this->flagTypeId ) {
			return [ 'flagTypeId' => $this->flagTypeId ];
		}
		return [];
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
		return true;
	}

	public function initModel( $params ) {
		$this->flagTypeId = $params['flagTypeId'];
	}

	/**
	 * Prepare data of articles - title, last revision, link etc.
	 * @return array
	 */
	public function fetchArticlesData() {
		$cacheKey = $this->getMemcKey( self::INSIGHTS_MEMC_ARTICLES_KEY );

		$articlesData = WikiaDataAccess::cache( $cacheKey, self::INSIGHTS_MEMC_TTL, function () {
			$articlesData = [];

			$flaggedPages = $this->getPagesByFlagType();

			if ( count( $flaggedPages ) > 0 ) {
				$articlesData = $this->prepareData( $flaggedPages );

				if ( $this->arePageViewsRequired() ) {
					$articlesIds = array_keys( $articlesData );
					$pageViewsData = $this->getPageViewsData( $articlesIds );
					$articlesData = $this->assignPageViewsData( $articlesData, $pageViewsData );
				}
			}

			return $articlesData;
		});

		return $articlesData;
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

	/**
	 * @return array
	 */
	private function getPagesByFlagType() {
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
			[ 'flag_type_id' => $this->flagTypeId ]
		)->getData()['data'];

		return $flaggedPages;
	}
}
