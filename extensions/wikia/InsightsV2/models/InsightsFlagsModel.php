<?php

/**
 * Data model specific to a subpage with a list of pages marked with flags
 * Note: Flags insights are are fetching flags only targeted at contributors
 */

class InsightsFlagsModel extends InsightsPageModel {

	const INSIGHT_TYPE = 'flags';

	private static $insightConfig = [
		'displayFixItMessage' => false
	];

	public function __construct( $subtype = null ) {
		if ( is_null( $subtype ) ) {
			$subtype = $this->getDefaultType();
		}

		self::$insightConfig[InsightsConfig::SUBTYPE] = $subtype;

		$this->config = new InsightsConfig( self::INSIGHT_TYPE, self::$insightConfig );
	}

	/**
	 * Get a type of a subpage and an edit parameter
	 * @return array
	 */
	public function getUrlParams() {
		return $this->getInsightParam();
	}

	/**
	 * Prepare data of articles - title, last revision, link etc.
	 * @return array
	 */
	public function fetchArticlesData() {
		$cacheKey = ( new InsightsCache( $this->getConfig() ) )->getMemcKey( InsightsCache::INSIGHTS_MEMC_ARTICLES_KEY );
		$articlesData = WikiaDataAccess::cache( $cacheKey, InsightsCache::INSIGHTS_MEMC_TTL, function () {
			$articlesData = [];

			$flaggedPages = $this->getPagesByFlagType();

			if ( count( $flaggedPages ) > 0 ) {
				$articlesData = $this->prepareData( $flaggedPages );

				if ( $this->getConfig()->showPageViews() ) {
					$articlesData = ( new InsightsPageViews( $this->getConfig() ) )->assignPageViewsData( $articlesData );
				}
			}

			return $articlesData;
		}, WikiaDataAccess::REFRESH_CACHE);

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
		$itemData = new InsightsItemData();

		foreach ( $pagesIds as $pageId ) {
			$article = [];

			$title = Title::newFromID( $pageId );

			if ( $title === null ) {
				$this->error( 'Flags Insights received reference to non existent page' );
				continue;
			}

			$params = $this->getUrlParams();
			$article['link'] = $itemData->getTitleLink( $title, $params );

			$article['metadata']['lastRevision'] = $itemData->prepareRevisionData( $title->getLatestRevID() );

			$data[ $title->getArticleID() ] = $article;
		}
		return $data;
	}

	/**
	 * @return array
	 */
	private function getPagesByFlagType() {
		$app = F::app();

		$subtype = $this->getConfig()->getInsightSubType();

		/* Select first type id by default */
		if ( empty( $subtype ) ) {
			$subtype = $this->getDefaultType();
		}

		/* If still empty (no flag types on wikia) return empty list */
		if ( empty( $subtype ) ) {
			return [];
		}

		/* Get to list of pages marked with flags */
		$flaggedPages = $app->sendRequest(
			'FlaggedPagesApiController',
			'getFlaggedPages',
			[ 'flag_type_id' => $subtype ]
		)->getData()['data'];

		return $flaggedPages;
	}

	/**
	 * Select first type ID and use as default
	 */
	private function getDefaultType() {
		$app = F::app();
		$params = [ 'flag_targeting' => \Flags\Models\FlagType::FLAG_TARGETING_CONTRIBUTORS ];
		$flagTypes = $app->sendRequest( 'FlagsApiController', 'getFlagTypes' , $params )->getData()['data'];
		return current( $flagTypes )['flag_type_id'];
	}

	/**
	 * Overrides Insights loop notification shown in view mode
	 * @return array
	 */
	public function getInProgressNotificationParams() {
		$controller = new InsightsController();
		$notificationMessageKey = InsightsHelper::INSIGHT_INPROGRESS_MSG_PREFIX . self::INSIGHT_TYPE;
		$params = [
			'notificationMessage' => wfMessage( $notificationMessageKey )->plain(),
			'customButtonText' => wfMessage( 'insights-notification-message-set-flags' )->plain(),
			'customButtonClass' => 'bn-flags-entry-point',
			'customButtonData' => 'edit-flags'
		];
		$params = array_merge(
			$params,
			$controller->getInsightListLinkParams( self::INSIGHT_TYPE )
		);
		return $params;
	}
}
