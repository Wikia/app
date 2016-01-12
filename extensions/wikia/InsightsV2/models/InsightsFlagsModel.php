<?php

/**
 * Data model specific to a subpage with a list of pages marked with flags
 * Note: Flags insights are are fetching flags only targeted at contributors
 */

class InsightsFlagsModel extends InsightsModel {

	const INSIGHT_TYPE = 'flags';

	private static $insightConfig = [
		InsightsConfig::PAGEVIEWS => true
	];

	public function __construct( $subtype = null ) {
		if ( is_null( $subtype ) ) {
			$subtype = $this->getDefaultType();
		}

		self::$insightConfig[InsightsConfig::SUBTYPE] = $subtype;
		$this->config = new InsightsConfig( self::INSIGHT_TYPE, self::$insightConfig );

		$this->config->setSubtypes( $this->getSubTypes() );
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
		return $this->getPagesByFlagType();
	}

	/**
	 * @return array
	 */
	private function getPagesByFlagType() {
		$app = F::app();
		$pages = [];
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
			[ 'flag_type_id' => $subtype ],
			true,
			WikiaRequest::EXCEPTION_MODE_THROW
		)->getData()['data'];

		foreach ( $flaggedPages as $pageId ) {
			$pages[] = [
				'pageId' => $pageId,
				'title' => Title::newFromID( $pageId )
			];
		}

		return $pages;
	}

	private function getSubTypes() {
		$subtypes = [];
		$app = F::app();

		$params = [ 'flag_targeting' => \Flags\Models\FlagType::FLAG_TARGETING_CONTRIBUTORS ];
		$flagTypes = $app->sendRequest(
			'FlagsApiController',
			'getFlagTypes',
			$params,
			true,
			WikiaRequest::EXCEPTION_MODE_THROW
		)->getData()['data'];

		foreach ( $flagTypes as $type ) {
			$subtypes[$type['flag_type_id']] = $type['flag_name'];
		}

		return $subtypes;
	}

	/**
	 * Select first type ID and use as default
	 */
	private function getDefaultType() {
		$app = F::app();
		$params = [ 'flag_targeting' => \Flags\Models\FlagType::FLAG_TARGETING_CONTRIBUTORS ];
		$flagTypes = $app->sendRequest(
			'FlagsApiController',
			'getFlagTypes',
			$params,
			true,
			WikiaRequest::EXCEPTION_MODE_THROW
		)->getData()['data'];
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
