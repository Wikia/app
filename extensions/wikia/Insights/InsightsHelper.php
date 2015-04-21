<?php

class InsightsHelper {

	public static $insightsPages = [
		InsightsUncategorizedModel::INSIGHT_TYPE	=> 'InsightsUncategorizedModel',
		InsightsWithoutimagesModel::INSIGHT_TYPE	=> 'InsightsWithoutimagesModel',
		InsightsDeadendModel::INSIGHT_TYPE			=> 'InsightsDeadendModel',
		InsightsWantedpagesModel::INSIGHT_TYPE		=> 'InsightsWantedpagesModel'
	];

	public static $insightsMessageKeys = [
		InsightsUncategorizedModel::INSIGHT_TYPE => [
			'subtitle' => 'insights-list-uncategorized-subtitle',
			'description' => 'insights-list-uncategorized-description',
		],
		InsightsWithoutimagesModel::INSIGHT_TYPE => [
			'subtitle' => 'insights-list-withoutimages-subtitle',
			'description' => 'insights-list-withoutimages-description',
		],
		InsightsDeadendModel::INSIGHT_TYPE => [
			'subtitle' => 'insights-list-deadend-subtitle',
			'description' => 'insights-list-deadend-description',
		],
		InsightsWantedpagesModel::INSIGHT_TYPE => [
			'subtitle' => 'insights-list-wantedpages-subtitle',
			'description' => 'insights-list-wantedpages-description',
		],
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

	public static function getSubpageLocalUrl( $key ) {
		if ( isset( self::$insightsMessageKeys[$key] ) ) {
			return SpecialPage::getTitleFor( 'Insights', $key )->getLocalURL();
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
}
