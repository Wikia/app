<?php

class InsightsHelper {
	/**
	 * covers messages:
	 *
	 * 'insights-list-subtitle-uncategorizedpages',
	 * 'insights-list-subtitle-withoutimages',
	 * 'insights-list-subtitle-deadendpages',
	 * 'insights-list-subtitle-wantedpages' 
	 */
	const INSIGHT_SUBTITLE_MSG_PREFIX		= 'insights-list-subtitle-';

	/**
	 * covers messages:
	 *
	 * 'insights-list-description-uncategorizedpages',
	 * 'insights-list-description-withoutimages',
	 * 'insights-list-description-deadendpages',
	 * 'insights-list-description-wantedpages'
	 */
	const INSIGHT_DESCRIPTION_MSG_PREFIX	= 'insights-list-description-';

	/**
	 * covers messages:
	 *
	 * 'insights-notification-message-inprogress-uncategorizedpages',
	 * 'insights-notification-message-inprogress-withoutimages',
	 * 'insights-notification-message-inprogress-deadendpages',
	 * 'insights-notification-message-inprogress-wantedpages'
	 */
	const INSIGHT_INPROGRESS_MSG_PREFIX		= 'insights-notification-message-inprogress-';

	/**
	 * covers messages:
	 *
	 * 'insights-notification-message-fixed-uncategorizedpages',
	 * 'insights-notification-message-fixed-withoutimages',
	 * 'insights-notification-message-fixed-deadendpages',
	 * 'insights-notification-message-fixed-wantedpages'
	 */
	const INSIGHT_FIXED_MSG_PREFIX			= 'insights-notification-message-fixed-';

	public static $insightsPages = [
		InsightsUncategorizedModel::INSIGHT_TYPE	=> 'InsightsUncategorizedModel',
		InsightsWithoutimagesModel::INSIGHT_TYPE	=> 'InsightsWithoutimagesModel',
		InsightsDeadendModel::INSIGHT_TYPE			=> 'InsightsDeadendModel',
		InsightsWantedpagesModel::INSIGHT_TYPE		=> 'InsightsWantedpagesModel'
	];

	/**
	 * Gets pageviews for given articles
	 * TODO: Are we going to show all pageviews or for some time pertiod?
	 *
	 * @param array $articleIds
	 * @param $wikiId
	 */
	public function getArticlesPageviews( Array $articleIds, $wikiId ) {
		global $wgStatsDBEnabled, $wgDatamartDB;

		$db = wfGetDB( DB_SLAVE, array(), $wgDatamartDB );

		$sql = ( new WikiaSQL() )->skipIf( empty( $wgStatsDBEnabled ) )
			->SELECT( 'namespace_id', 'article_id', 'pageviews as pv' )
			->FROM( 'rollup_wiki_article_pageviews' )
			->WHERE( 'time_id' )->EQUAL_TO( sql::RAW( 'CURDATE() - INTERVAL DAYOFWEEK(CURDATE()) - 1 DAY' ) )
			->AND_( 'article_id' )->IN( $articleIds )
			->AND_( 'period_id' )->EQUAL_TO( DataMartService::PERIOD_ID_WEEKLY )
			->AND_( 'wiki_id' )->EQUAL_TO( $wikiId );

		// TODO: Finish during work on dispalying page views
	}

	public static function getSubpageLocalUrl( $subpage ) {
		if ( isset( self::$insightsPages[$subpage] ) ) {
			return SpecialPage::getTitleFor( 'Insights', $subpage )->getLocalURL();
		}
		return null;
	}

	/**
	 * Check if given subpage exists as an insight page
	 *
	 * @param $category
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
	 * Returns specific data provider
	 * If it doesn't exists redirect to Special:Insights main page
	 *
	 * @param $subpage String Insights subpage name
	 * @return mixed
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

	public static function getTitleLink(Title $title, $params) {
		$data = [
			'text' => $title->getText(),
			'url' => $title->getFullURL( $params ),
			'title' => $title->getPrefixedText()
		];

		if ( !$title->exists() ) {
			$data['classes'] = 'new';
			$data['title'] = wfMessage( 'red-link-title', $title->getPrefixedText() )->escaped();
		}

		return $data;
	}
}
