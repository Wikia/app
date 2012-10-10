<?php
/**
 * Model for the WikiInfo API controller
 *
 * @author Federico "Lox" Lucignano <federico.lox@gmail.com>
 */

class WikisModel extends WikiaModel {
	const CACHE_VERSION = '3';
	const MAX_RESULTS = 250;

	const FLAG_NEW = 1;
	const FLAG_HOT = 2;
	const FLAG_PROMOTED = 4;
	const FLAG_BLOCKED = 8;
	const FLAG_OFFICIAL = 16;

	/**
	 * Get the domain of a wiki by its' ID
	 *
	 * @param integer $wikiId The wiki's ID
	 *
	 * @return string The domain name, without protocol
	 */
	public function getDomainByWikiId( $wikiId ){
		$domain = WikiFactory::getVarValueByName( 'wgServer', $wikiId );
		$ret = null;

		if ( !empty( $domain ) ) {
			$ret = str_replace( 'http://', '',  $domain );
		}

		return $ret;
	}

	/**
	 * Get the vertical name for a wiki by its' ID
	 *
	 * @param integer $wikiId The wiki's ID
	 *
	 * @return string The name of the vertical (e.g. Gaming, Entertainment, etc.)
	 */
	public function getVerticalByWikiId( $wikiId ){
		$cat = WikiFactory::getCategory( $wikiId );
		$ret = null;

		if ( !empty( $cat ) ) {
			$ret =  $cat->cat_name;
		}

		return $ret;
	}

	/**
	 * Get the top wikis by pageviews optionally filtering by vertical (hub) and/or language
	 *
	 * @param string $hub [OPTIONAL] The name of the vertical (e.g. Gaming, Entertainment,
	 * Lifestyle, etc.) to use as a filter
	 * @param string $lang [OPTIONAL] The language code (e.g. en, de, fr, es, it, etc.) to use as a filter
	 *
	 * @return array A collection of results with id, name, hub, language, topic and domain
	 */
	public function getTopWikis($lang = null, $hub = null) {
		$this->wf->profileIn( __METHOD__ );

		$memKey = $this->wf->SharedMemcKey( __METHOD__, self::CACHE_VERSION, $lang, $hub );
		$results = $this->wg->Memc->get( $memKey );

		if ( !is_array( $results ) ) {
			$results = array();
			$wikis = DataMartService::getTopWikisByPageviews( DataMartService::PERIOD_ID_WEEKLY, self::MAX_RESULTS, $lang, $hub, 1 /* only pubic */ );

			foreach ( $wikis as $wikiId => $wiki ) {
				//fetching data from WikiFactory
				//the table is indexed and values cached separately
				//so making one query for all of them or a few small
				//separate ones doesn't make any big difference while
				//this respects WF's data abstraction layer
				$name = WikiFactory::getVarValueByName( 'wgSitename', $wikiId );
				$hubName = ( !empty( $hub ) ) ? $hub : $this->getVerticalByWikiId( $wikiId );
				$langCode = WikiFactory::getVarValueByName( 'wgLanguageCode', $wikiId );
				$topic = WikiFactory::getVarValueByName( 'wgWikiTopics', $wikiId );
				$domain = $this->getDomainByWikiId( $wikiId );

				$results[] = array(
					'id' => $wikiId,
					'name' => ( !empty( $name ) ) ? $name : null,
					'hub' => $hubName,
					'language' => ( !empty( $langCode ) ) ? $langCode : null,
					'topic' => ( !empty( $topic ) ) ? $topic : null,
					'domain' => $domain
				);
			}

			$this->wg->Memc->set( $memKey, $results, 86400 /* 24h */ );
		}

		$this->wf->profileOut( __METHOD__ );
		return $results;
	}
}