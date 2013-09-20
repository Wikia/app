<?php
/**
 * Model for Wikia-specific information about wikis
 *
 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
 * @author Artur Klajnerok <arturk@wikia-inc.com>
 */

class WikisModel extends WikiaModel {
	const CACHE_VERSION = '4';
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
	private function getDomainByWikiId( $wikiId ){
		//this has its' own cache layer
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
	private function getVerticalByWikiId( $wikiId ){
		//this has its' own cache layer
		$cat = WikiFactory::getCategory( $wikiId );
		$ret = null;

		if ( !empty( $cat ) ) {
			$ret =  $cat->cat_name;
		}

		return $ret;
	}

	/**
	 * Get the top wikis by weekly pageviews optionally filtering by vertical (hub) and/or language
	 *
	 * @param string $hub [OPTIONAL] The name of the vertical (e.g. Gaming, Entertainment,
	 * Lifestyle, etc.) to use as a filter
	 * @param string $lang [OPTIONAL] The language code (e.g. en, de, fr, es, it, etc.) to use as a filter
	 *
	 * @return array A collection of results with id, name, hub, language, topic and domain
	 */
	public function getTop( Array $langs = null, $hub = null ) {
		wfProfileIn( __METHOD__ );

		$cacheKey = wfSharedMemcKey( __METHOD__, self::CACHE_VERSION, implode( ',', $langs ), $hub );
		$results = $this->wg->Memc->get( $cacheKey );

		if ( !is_array( $results ) ) {
			$results = array();
			$wikis = DataMartService::getTopWikisByPageviews( DataMartService::PERIOD_ID_WEEKLY, self::MAX_RESULTS, $langs, $hub, 1 /* only pubic */ );

			foreach ( $wikis as $wikiId => $wiki ) {
				//fetching data from WikiFactory
				//the table is indexed and values cached separately
				//so making one query for all of them or a few small
				//separate ones doesn't make any big difference while
				//this respects WF's data abstraction layer
				//also: WF data is heavily cached
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

			$this->wg->Memc->set( $cacheKey, $results, 86400 /* 24h */ );
		}

		wfProfileOut( __METHOD__ );
		return $results;
	}

	/**
	 * Finds wikis which name, domain or topic match a string optionally filtering by vertical (hub) and/or language
	 *
	 * @param string $string search term
	 * @param mixed $hub [OPTIONAL] The name of the vertical as a string(e.g. Gaming, Entertainment,
	 * Lifestyle, etc.) or it's related numeric ID to use as a filter
	 * @param string $lang [OPTIONAL] The language code (e.g. en, de, fr, es, it, etc.) to use as a filter
	 * @param bool [OPTIONAL] Include the domain name in the search, defaults to false
	 *
	 * @return array A collection of results with id, name, hub, language, topic, domain
	 */
	public function getByString( $string, Array $langs = null, $hub = null, $includeDomain = false ) {
		wfProfileIn( __METHOD__ );

		$wikis = [];

		if ( !empty( $string ) ) {
			$hubId = null;

			if ( !empty( $hub ) ) {
				if ( is_string( $hub ) ) {
					//this has it's own memcache layer (24h)
					$hubData = WikiFactoryHub::getInstance()->getCategoryByName( $hub );

					if ( is_array( $hubData ) ) {
						$hubId = $hubData['id'];
					}
				} elseif ( is_integer( $hub ) ) {
					$hubId = $hub;
				}
			}

			if ( empty( $hub ) || ( !empty( $hub ) && is_integer( $hubId ) ) ) {
				$cacheKey = wfSharedMemcKey( __METHOD__, self::CACHE_VERSION,  md5( strtolower( $string ) ), $hubId, implode( ',', $langs ), ( ( !empty( $includeDomain ) ? 'includeDomain' : null ) ) );
				$wikis = $this->app->wg->Memc->get( $cacheKey );

				if ( !is_array( $wikis ) ) {
					$db = $this->getSharedDB();

					$string = $db->addQuotes( "%{$string}%" );
					$varId = (int) WikiFactory::getVarByName( 'wgWikiTopics', null )->cv_variable_id;
					$tables = array(
						'city_list',
						'city_variables'
					);

					$clause = array( "city_list.city_title LIKE {$string}" );

					if ( !empty( $includeDomain ) ) {
						$clause[] = "city_list.city_url LIKE {$string}";
					}

					$clause[] = "city_variables.cv_value LIKE {$string}";

					$where = array(
						'city_list.city_public' => 1,
						'(' . implode( ' OR ', $clause ) . ')'
					);

					$join = array(
						'city_variables' => array(
							'LEFT JOIN',
							"city_list.city_id = city_variables.cv_city_id AND city_variables.cv_variable_id = {$varId}"
						)
					);

					if ( !empty( $langs ) ) {
						$langs = $db->makeList($langs);
						$where[] = 'city_list.city_lang IN (' . $langs . ')';
					}

					if ( is_integer( $hubId ) ) {
						$tables[] = 'city_cat_mapping';
						$where['city_cat_mapping.cat_id'] = $hubId;
						$join['city_cat_mapping'] = array(
							'LEFT JOIN',
							'city_list.city_id = city_cat_mapping.city_id'
						);
					}

					$rows = $db->select(
						$tables,
						array(
							'city_list.city_id',
							'city_list.city_lang',
							'city_list.city_title',
							'city_variables.cv_value'
						),
						$where,
						__METHOD__,
						array(
							'LIMIT' => self::MAX_RESULTS
						),
						$join
					);

					while ( $row = $db->fetchObject( $rows ) ) {
						$wikis[] = array(
							'id' => $row->city_id,
							'name' => $row->city_title,
							//getting this as a separate query since it would require
							//a double join, that would complicate the situation with
							//the query's performance
							'hub' => ( !empty( $hub ) && is_string( $hub ) ) ? $hub : $this->getVerticalByWikiId( $row->city_id ),
							'language' => $row->city_lang,
							//WF stores strings as serialized data
							'topic' => ( !empty( $row->cv_value ) ) ? unserialize( $row->cv_value ) : null,
							//getting this as a separate query since it would require
							//a double join, that would complicate the situation with
							//the query's performances
							'domain' => $this->getDomainByWikiId( $row->city_id )
						);
					}

					$this->wg->Memc->set( $cacheKey, $wikis, 43200 /* 12h */ );
				}
			}
		}

		wfProfileOut( __METHOD__ );
		return $wikis;
	}

	/**
	 * Get details about one or more wikis
	 *
	 * @param Array $wikiIds An array of one or more wiki ID's
	 *
	 * @return Array A collection of results, the index is the wiki ID and each item has a name,
	 * url, lang, hubId, headline, desc, image and flags index.
	 */
	public function getDetails( Array $wikiIds = null ) {
		wfProfileIn(__METHOD__);

		$results = array();

		if ( !empty( $wikiIds ) ) {
			$notFound = array();

			foreach ( $wikiIds as $index => $val ) {
				$val = (int) $val;

				if ( !empty( $val ) ) {
					$cacheKey = wfSharedMemcKey( __METHOD__, self::CACHE_VERSION, $val );
					$item = $this->wg->Memc->get( $cacheKey );

					if ( is_array( $item ) ) {
						$results[$val] = $item;
					}else {
						$notFound[] = $val;
					}
				}
			}

			$wikiIds = $notFound;
		}

		if ( !empty( $wikiIds ) ) {
			$db = $this->getSharedDB();

			$rows = $db->select(
				array(
					'city_visualization',
					'city_list'
				),
				array(
					'city_list.city_id',
					'city_list.city_title',
					'city_list.city_url',
					'city_visualization.city_lang_code',
					'city_visualization.city_vertical',
					'city_visualization.city_headline',
					'city_visualization.city_description',
					'city_visualization.city_main_image',
					'city_visualization.city_flags',
				),
				array(
					'city_list.city_public' => 1,
					'city_list.city_id IN (' . implode( ',', $wikiIds ) . ')',
					'((city_visualization.city_flags & ' . self::FLAG_BLOCKED . ') != ' . self::FLAG_BLOCKED . ' OR city_visualization.city_flags IS NULL)'
				),
				__METHOD__,
				array(),
				array(
					'city_visualization' => array(
						'LEFT JOIN',
						'city_list.city_id = city_visualization.city_id'
					)
				)
			);

			while( $row = $db->fetchObject( $rows ) ) {
				$item = array(
					'name' => $row->city_title,
					'url' => $row->city_url,
					'lang' => $row->city_lang_code,
					'hubId' => $row->city_vertical,
					'headline' => $row->city_headline,
					'desc' => $row->city_description,
					//this is stored in a pretty peculiar format,
					//see extensions/wikia/CityVisualization/models/CityVisualization.class.php
					'image' => $row->city_main_image,
					'flags' => array(
						'new' => ( ( $row->city_flags & self::FLAG_NEW ) == self::FLAG_NEW ),
						'hot' => ( ( $row->city_flags & self::FLAG_HOT ) == self::FLAG_HOT ),
						'official' => ( ( $row->city_flags & self::FLAG_OFFICIAL ) == self::FLAG_OFFICIAL ),
						'promoted' => ( ( $row->city_flags & self::FLAG_PROMOTED ) == self::FLAG_PROMOTED )
					)
				);

				$cacheKey = wfSharedMemcKey( __METHOD__, self::CACHE_VERSION, $row->city_id );
				$this->wg->Memc->set( $cacheKey, $item, 43200 /* 12h */ );
				$results[$row->city_id] = $item;
			}
		}

		wfProfileOut(__METHOD__);
		return $results;
	}
}