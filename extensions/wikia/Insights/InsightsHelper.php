<?php

class InsightsHelper {

	public static $insightsMessageKeys = [
		'uncategorized' => [
			'subtitle' => 'insights-list-uncategorized-subtitle',
			'description' => 'insights-list-uncategorized-description',
		],
		'withoutimages' => [
			'subtitle' => 'insights-list-withoutimages-subtitle',
			'description' => 'insights-list-withoutimages-description',
		],
		'wantedpages' => [
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
}
