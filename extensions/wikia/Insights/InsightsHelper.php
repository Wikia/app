<?php

class InsightsHelper {
	/**
	 * Used to create the following messages:
	 *
	 * 'insights-list-subtitle-uncategorizedpages',
	 * 'insights-list-subtitle-withoutimages',
	 * 'insights-list-subtitle-deadendpages',
	 * 'insights-list-subtitle-wantedpages' 
	 */
	const INSIGHT_SUBTITLE_MSG_PREFIX = 'insights-list-subtitle-';

	/**
	 * Used to create the following messages:
	 *
	 * 'insights-list-description-uncategorizedpages',
	 * 'insights-list-description-withoutimages',
	 * 'insights-list-description-deadendpages',
	 * 'insights-list-description-wantedpages'
	 */
	const INSIGHT_DESCRIPTION_MSG_PREFIX = 'insights-list-description-';

	/**
	 * Used to create the following messages:
	 *
	 * 'insights-notification-message-inprogress-uncategorizedpages',
	 * 'insights-notification-message-inprogress-withoutimages',
	 * 'insights-notification-message-inprogress-deadendpages',
	 * 'insights-notification-message-inprogress-wantedpages'
	 */
	const INSIGHT_INPROGRESS_MSG_PREFIX = 'insights-notification-message-inprogress-';

	/**
	 * Used to create the following messages:
	 *
	 * 'insights-notification-message-fixed-uncategorizedpages',
	 * 'insights-notification-message-fixed-withoutimages',
	 * 'insights-notification-message-fixed-deadendpages',
	 * 'insights-notification-message-fixed-wantedpages'
	 */
	const INSIGHT_FIXED_MSG_PREFIX = 'insights-notification-message-fixed-';

	public static $insightsPages = [
		InsightsUncategorizedModel::INSIGHT_TYPE	=> 'InsightsUncategorizedModel',
		InsightsWithoutimagesModel::INSIGHT_TYPE	=> 'InsightsWithoutimagesModel',
		InsightsDeadendModel::INSIGHT_TYPE			=> 'InsightsDeadendModel',
		InsightsWantedpagesModel::INSIGHT_TYPE		=> 'InsightsWantedpagesModel'
	];

	/**
	 * Returns a full URL for a known subpage and a NULL for an unknown one.
	 * @param $subpage A slug of subpage
	 * @return String|null
	 */
	public static function getSubpageLocalUrl( $subpage ) {
		if ( isset( self::$insightsPages[$subpage] ) ) {
			return SpecialPage::getTitleFor( 'Insights', $subpage )->getLocalURL();
		}
		return null;
	}

	/**
	 * Checks if a given subpage is known
	 *
	 * @param $subpage A slug of a subpage
	 * @return bool
	 */
	public static function isInsightPage( $subpage ) {
		return !empty( $subpage ) && isset( self::$insightsPages[$subpage] );
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
	 * @param $subpage A slug of a subpage
	 * @return InsightsModel|null
	 */
	public static function getInsightModel( $subpage ) {
		if ( self::isInsightPage( $subpage ) ) {
			$modelName = self::$insightsPages[$subpage];
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
		$data = [
			'text' => $title->getText(),
			'url' => $title->getFullURL( $params ),
			'title' => $title->getPrefixedText(),
			'classes' => '',
		];

		if ( !$title->exists() ) {
			$data['classes'] = 'new';
			$data['title'] = wfMessage( 'red-link-title', $title->getPrefixedText() )->escaped();
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
		foreach ( self::$insightsPages as $key => $class ) {
			$messageKeys[$key] = [
				'subtitle' => self::INSIGHT_SUBTITLE_MSG_PREFIX . $key,
				'description' => self::INSIGHT_DESCRIPTION_MSG_PREFIX . $key,
			];
		}
		return $messageKeys;
	}

	public static function getLastFourTimeIds() {
		return [
			( new DateTime() )->modify( 'last Sunday' )->format( 'Y-m-d H:i:s' ),
			( new DateTime() )->modify( '-1 week' )->modify( 'last Sunday' )->format( 'Y-m-d H:i:s' ),
			( new DateTime() )->modify( '-2 week' )->modify( 'last Sunday' )->format( 'Y-m-d H:i:s' ),
			( new DateTime() )->modify( '-3 week' )->modify( 'last Sunday' )->format( 'Y-m-d H:i:s' ),
		];
	}
}
