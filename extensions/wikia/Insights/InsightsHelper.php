<?php

class InsightsHelper {
	/**
	 * Used to create the following messages:
	 *
	 * 'insights-list-subtitle-flags',
	 * 'insights-list-subtitle-uncategorizedpages',
	 * 'insights-list-subtitle-withoutimages',
	 * 'insights-list-subtitle-deadendpages',
	 * 'insights-list-subtitle-wantedpages'
	 */
	const INSIGHT_SUBTITLE_MSG_PREFIX = 'insights-list-subtitle-';

	/**
	 * Used to create the following messages:
	 *
	 * 'insights-list-description-deadendpages',
	 * 'insights-list-description-flags',
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

	public static $insightsPages = [
		InsightsUncategorizedModel::INSIGHT_TYPE	=> 'InsightsUncategorizedModel',
		InsightsWithoutimagesModel::INSIGHT_TYPE	=> 'InsightsWithoutimagesModel',
		InsightsDeadendModel::INSIGHT_TYPE			=> 'InsightsDeadendModel',
		InsightsWantedpagesModel::INSIGHT_TYPE		=> 'InsightsWantedpagesModel'
	];


	/**
	 * Prepare array with all available insights pages
	 *
	 * @return array
	 */
	public static function getInsightsPages() {
		global $wgEnableInsightsInfoboxes, $wgEnableFlagsExt;

		/* Add infoboxes insight */
		if ( !empty( $wgEnableInsightsInfoboxes )
			&& !isset( self::$insightsPages[InsightsUnconvertedInfoboxesModel::INSIGHT_TYPE] )
		) {
			self::$insightsPages = array_merge(
				[ InsightsUnconvertedInfoboxesModel::INSIGHT_TYPE => 'InsightsUnconvertedInfoboxesModel' ],
				self::$insightsPages
			);
		}

		/* Add flags insight */
		if ( !empty( $wgEnableFlagsExt )
			&& !isset( self::$insightsPages[InsightsFlagsModel::INSIGHT_TYPE] )
		) {
			self::$insightsPages = array_merge(
				[ InsightsFlagsModel::INSIGHT_TYPE => 'InsightsFlagsModel' ],
				self::$insightsPages
			);
		}

		return self::$insightsPages;
	}

	/**
	 * Returns a full URL for a known subpage and a NULL for an unknown one.
	 * @param $subpage A slug of subpage
	 * @return String|null
	 */
	public static function getSubpageLocalUrl( $subpage ) {
		$insightsPages = self::getInsightsPages();

		if ( isset( $insightsPages[$subpage] ) ) {
			return SpecialPage::getTitleFor( 'Insights', $subpage )->getLocalURL();
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
	 * Get param to show proper editor based on user preferences
	 *
	 * @return mixed
	 */
	public static function getEditUrlParams() {
		global $wgUser;

		if ( EditorPreference::isVisualEditorPrimary() && $wgUser->isLoggedIn() ) {
			$param['veaction'] = 'edit';
		} else {
			$param['action'] = 'edit';
		}

		return $param;
	}

	/**
	 * Returns a specific subpage model
	 * If it does not exist a user is redirected to the Special:Insights landing page
	 *
	 * @param $subpage string|null A slug of a subpage
	 * @return InsightsModel|null
	 */
	public static function getInsightModel( $subpage ) {
		if ( self::isInsightPage( $subpage ) ) {
			$insightsPages = self::getInsightsPages();
			$modelName = $insightsPages[$subpage];
			if ( class_exists( $modelName ) ) {
				return new $modelName();
			}
		}

		return null;
	}

	/**
	 * Prepare a data to create a link element
	 *
	 * @param Title $title A target article's Title object
	 * @param $params
	 * @return array
	 */
	public static function getTitleLink( Title $title, $params ) {
		$prefixedTitle = $title->getPrefixedText();

		$data = [
			'text' => $prefixedTitle,
			'url' => $title->getFullURL( $params ),
			'title' => $prefixedTitle,
			'classes' => '',
		];

		if ( !$title->exists() ) {
			$data['classes'] = 'new';
			$data['title'] = wfMessage( 'red-link-title', $prefixedTitle )->escaped();
		}

		return $data;
	}

	/**
	 * Returns an array of basic messages keys associated with slugs of subpages
	 * (subtitle and description). Used mainly to generate navigation elements.
	 *
	 * @return array
	 */
	public static function getMessageKeys() {
		$messageKeys = [];
		$insightsPages = self::getInsightsPages();
		foreach ( $insightsPages as $key => $class ) {
			$messageKeys[$key] = [
				'subtitle' => self::INSIGHT_SUBTITLE_MSG_PREFIX . $key,
				'description' => self::INSIGHT_DESCRIPTION_MSG_PREFIX . $key,
			];
		}
		return $messageKeys;
	}

	/**
	 * Returns an array of datetime entries for the last four Sundays
	 * (page views data is currently updated on every Sunday)
	 *
	 * @return array An array with dates of the last four Sundays
	 */
	public static function getLastFourTimeIds() {
		$lastTimeId = ( new DateTime() )->modify( 'last Sunday' );
		$format = 'Y-m-d H:i:s';
		return [
			$lastTimeId->format( $format ),
			$lastTimeId->modify( '-1 week' )->format( $format ),
			$lastTimeId->modify( '-2 week' )->format( $format ),
			$lastTimeId->modify( '-3 week' )->format( $format ),
		];
	}
}
