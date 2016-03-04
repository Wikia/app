<?php
namespace Wikia\ExactTarget;

class ExactTargetWikiHooksHelper {

	/**
	 * Returns wiki data required in update requests
	 * @param int $wikiId
	 * @return array
	 */
	public function prepareWikiData( $wikiId ) {
		/* Get wikidata from master */
		$oWiki = \WikiFactory::getWikiById( $wikiId, true );

		return [
			'city_path' => $oWiki->city_path,
			'city_dbname' => $oWiki->city_dbname,
			'city_sitename' => $oWiki->city_sitename,
			'city_url' => $oWiki->city_url,
			'city_created' => $oWiki->city_created,
			'city_founding_user' => $oWiki->city_founding_user,
			'city_adult' => $oWiki->city_adult,
			'city_public' => $oWiki->city_public,
			'city_title' => $oWiki->city_title,
			'city_founding_email' => $oWiki->city_founding_email,
			'city_lang' => $oWiki->city_lang,
			'city_special' => $oWiki->city_special,
			'city_umbrella' => $oWiki->city_umbrella,
			'city_ip' => $oWiki->city_ip,
			'city_google_analytics' => $oWiki->city_google_analytics,
			'city_google_search' => $oWiki->city_google_search,
			'city_google_maps' => $oWiki->city_google_maps,
			'city_indexed_rev' => $oWiki->city_indexed_rev,
			'city_lastdump_timestamp' => $oWiki->city_lastdump_timestamp,
			'city_factory_timestamp' => $oWiki->city_factory_timestamp,
			'city_useshared' => $oWiki->city_useshared,
			'ad_cat' => $oWiki->ad_cat,
			'city_flags' => $oWiki->city_flags,
			'city_cluster' => $oWiki->city_cluster,
			'city_last_timestamp' => $oWiki->city_last_timestamp,
			'city_founding_ip' => $oWiki->city_founding_ip,
			'city_vertical' => $oWiki->city_vertical,
		];
	}

}
