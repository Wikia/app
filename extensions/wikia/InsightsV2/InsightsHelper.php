<?php

class InsightsHelper {

	const MAX_DISPLAY_COUNT = 999;

	/**
	 * Used to create the following messages:
	 *
	 * 'insights-list-subtitle-deadendpages',
	 * 'insights-list-subtitle-flags',
	 * 'insights-list-subtitle-templateswithouttype'
	 * 'insights-list-subtitle-uncategorizedpages',
	 * 'insights-list-subtitle-wantedpages'
	 * 'insights-list-subtitle-withoutimages',
	 */
	const INSIGHT_SUBTITLE_MSG_PREFIX = 'insights-list-subtitle-';

	/**
	 * Used to create the following messages:
	 *
	 * 'insights-list-description-deadendpages',
	 * 'insights-list-description-flags',
	 * 'insights-list-description-templateswithouttype',
	 * 'insights-list-description-uncategorizedpages',
	 * 'insights-list-description-wantedpages'
	 * 'insights-list-description-withoutimages',
	 */
	const INSIGHT_DESCRIPTION_MSG_PREFIX = 'insights-list-description-';

	/**
	 * Used to create the following messages:
	 *
	 * 'insights-notification-message-inprogress-flags',
	 * 'insights-notification-message-inprogress-uncategorizedpages',
	 * 'insights-notification-message-inprogress-withoutimages',
	 * 'insights-notification-message-inprogress-deadendpages',
	 * 'insights-notification-message-inprogress-wantedpages'
	 */
	const INSIGHT_INPROGRESS_MSG_PREFIX = 'insights-notification-message-inprogress-';

	/**
	 * Used to create the following messages:
	 *
	 * 'insights-notification-message-fixed-deadendpages',
	 * 'insights-notification-message-fixed-nonportableinfoboxes'
	 * 'insights-notification-message-fixed-uncategorizedpages',
	 * 'insights-notification-message-fixed-wantedpages'
	 * 'insights-notification-message-fixed-withoutimages',
	 */
	const INSIGHT_FIXED_MSG_PREFIX = 'insights-notification-message-fixed-';

	/**
	 * Used to create the following messages:
	 *
	 * 'insights-notification-next-item-deadendpages',
	 * 'insights-notification-next-item-nonportableinfoboxes'
	 * 'insights-notification-next-item-uncategorizedpages',
	 * 'insights-notification-next-item-wantedpages'
	 * 'insights-notification-next-item-withoutimages',
	 */
	const INSIGHT_NEXT_MSG_PREFIX = 'insights-notification-next-item-';

	private static $defaultInsights = [
		InsightsUncategorizedModel::INSIGHT_TYPE	=> 'InsightsUncategorizedModel',
		InsightsWithoutimagesModel::INSIGHT_TYPE	=> 'InsightsWithoutimagesModel',
		InsightsDeadendModel::INSIGHT_TYPE		=> 'InsightsDeadendModel',
		InsightsWantedpagesModel::INSIGHT_TYPE		=> 'InsightsWantedpagesModel'
	];


	/**
	 * Prepare array with all available insights pages
	 *
	 * @return array
	 */
	public static function getInsightsPages() {
		global $wgEnableInsightsInfoboxes, $wgEnableFlagsExt, $wgEnableTemplateClassificationExt,
			   $wgEnableInsightsPagesWithoutInfobox, $wgEnableInsightsTemplatesWithoutType;

		/* Order of inserting determines default order on insights entry points list */
		$insightsPages = [];

		/* Add TemplatesWithoutType insight */
		if ( !empty( $wgEnableTemplateClassificationExt ) && !empty( $wgEnableInsightsTemplatesWithoutType ) ) {
			$insightsPages[InsightsTemplatesWithoutTypeModel::INSIGHT_TYPE] = 'InsightsTemplatesWithoutTypeModel';
		}

		/* Add Infoboxes insight */
		if ( !empty( $wgEnableInsightsInfoboxes ) ) {
			$insightsPages[InsightsUnconvertedInfoboxesModel::INSIGHT_TYPE] = 'InsightsUnconvertedInfoboxesModel';
		}

		/* Add Flags insight */
		if ( !empty( $wgEnableFlagsExt ) ) {
			$insightsPages[InsightsFlagsModel::INSIGHT_TYPE] = 'InsightsFlagsModel';
		}

		/* Add default insights */
		$insightsPages = array_merge( $insightsPages, self::$defaultInsights );

		/* Add PagesWithoutInfobox insight */
		if ( !empty( $wgEnableTemplateClassificationExt ) && !empty( $wgEnableInsightsPagesWithoutInfobox ) ) {
			$insightsPages[InsightsPagesWithoutInfoboxModel::INSIGHT_TYPE] = 'InsightsPagesWithoutInfoboxModel';
		}

		return $insightsPages;

	}

	/**
	 * Get list of insights which should be highlighted in insights list (should have red dot)
	 *
	 * @return array
	 */
	public static function getHighlightedInsights() {
		global $wgEnableTemplateClassificationExt, $wgEnableInsightsInfoboxes, $wgEnableInsightsTemplatesWithoutType;

		$highlightedInsights = [];

		if ( !empty( $wgEnableInsightsInfoboxes ) ) {
			$highlightedInsights[] = InsightsUnconvertedInfoboxesModel::INSIGHT_TYPE;
		}

		if ( !empty( $wgEnableTemplateClassificationExt ) && !empty( $wgEnableInsightsTemplatesWithoutType ) ) {
			$highlightedInsights[] = InsightsTemplatesWithoutTypeModel::INSIGHT_TYPE;
		}

		return $highlightedInsights;
	}

	/**
	 * Returns a full URL for a known subpage and a NULL for an unknown one.
	 * @param string $subpage slug of subpage
	 * @param array $params params
	 * @return string|null
	 */
	public static function getSubpageLocalUrl( $subpage, Array $params = [] ) {
		$insightsPages = self::getInsightsPages();

		if ( isset( $insightsPages[$subpage] ) ) {
			return SpecialPage::getTitleFor( 'Insights', $subpage )->getLocalURL( $params );
		}
		return null;
	}

	/**
	 * Checks if a given subpage is known
	 *
	 * @param $subpage string|null A slug of a subpage
	 * @return bool
	 */
	public static function isInsightPage( $subpage ) {
		$insightsPages = self::getInsightsPages();
		return !empty( $subpage ) && isset( $insightsPages[$subpage] );
	}

	/**
	 * Returns a specific subpage model
	 * If it does not exist a user is redirected to the Special:Insights landing page
	 *
	 * @param $type string|null A slug of a type
	 * @param $subpage string|null A slug of a subpage
	 * @return InsightsModel|null
	 */
	public static function getInsightModel( $type, $subpage = null ) {
		if ( self::isInsightPage( $type ) ) {
			$insightsPages = self::getInsightsPages();
			$modelName = $insightsPages[$type];
			if ( class_exists( $modelName ) ) {
				return new $modelName( $subpage );
			}
		}

		return null;
	}

	/**
	 * Returns an array of basic messages keys associated with slugs of subpages
	 * (subtitle and description). Used mainly to generate navigation elements.
	 *
	 * @param int $limit Limit insights pages returned. No limit if 0.
	 * @return array
	 */
	public function prepareInsightsList( $limit = 0 ) {
		$insightsList = [];

		$insightsCountService = new InsightsCountService();
		$insightsPages = self::getInsightsPages();

		if ( $limit > 0 ) {
			$insightsPages = array_slice( $insightsPages, 0, $limit );
		}

		$highlightedInsighs = self::getHighlightedInsights();

		foreach ( $insightsPages as $key => $class ) {
			if ( class_exists( $class ) ) {
				$insightModel =  new $class();
				$count = $insightModel->getConfig()->getInsightUsage() == InsightsModel::INSIGHTS_USAGE_ACTIONABLE
					? $this->prepareCountDisplay( $insightsCountService->getCount( $key ) )
					: false;

				$insightsList[$key] = [
					'subtitle' => self::INSIGHT_SUBTITLE_MSG_PREFIX . $key,
					'description' => self::INSIGHT_DESCRIPTION_MSG_PREFIX . $key,
					'count' => $count,
					'highlighted' => in_array( $key, $highlightedInsighs )
				];
			}
		}
		return $insightsList;
	}

	private function prepareCountDisplay( $count ) {
		if ( $count > self::MAX_DISPLAY_COUNT ) {
			return self::MAX_DISPLAY_COUNT . '+';
		}

		return $count;
	}
}
