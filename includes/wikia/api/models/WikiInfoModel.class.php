<?php
/**
 * Model for the WikiInfo API controller
 *
 * @author Federico "Lox" Lucignano <federico.lox@gmail.com>
 */

class WikiInfoModel extends WikiaModel {
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
		return str_replace( 'http://', '', WikiFactory::getVarValueByName( 'wgServer', $wikiId ) );
	}

	/**
	 * Get the vertical name for a wiki by its' ID
	 *
	 * @param integer $wikiId The wiki's ID
	 *
	 * @return string The name of the vertical (e.g. Gaming, Entertainment, etc.)
	 */
	public function getVerticalByWikiId( $wikiId ){
		return WikiFactory::getCategory( $wikiId )->cat_name;
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
				$results[] = array(
					'id' => $wikiId,
					//fetching data from WikiFactory
					//the table is indexed and values cached separately
					//so making one query for all of them or many small
					//separate ones doesn't make any big difference while
					//this respects WF's data abstraction layer
					'name' => WikiFactory::getVarValueByName( 'wgSitename', $wikiId ),
					'hub' => ( !empty( $hub ) ) ? $hub : $this->getVerticalByWikiId( $wikiId ),
					'language' => WikiFactory::getVarValueByName( 'wgLanguageCode', $wikiId ),
					'topic' => WikiFactory::getVarValueByName( 'wgWikiTopics', $wikiId ),
					'domain' => $this->getDomainByWikiId( $wikiId )
				);
			}

			$this->wg->Memc->set( $memKey, $results, 86400 /* 24h */ );
		}

		$this->wf->profileOut( __METHOD__ );
		return $results;
	}

	/**
	 * Finds wikis which name or topic match a keyword optionally filtering by vertical (hub) and/or language
	 *
	 * @param string $keyword search term
	 * @param mixed $hub [OPTIONAL] The name of the vertical as a string(e.g. Gaming, Entertainment,
	 * Lifestyle, etc.) or it's related numeric ID to use as a filter
	 * @param string $lang [OPTIONAL] The language code (e.g. en, de, fr, es, it, etc.) to use as a filter
	 *
	 * @return array A collection of results with id, name, hub, language, topic, domain
	 */
	public function getWikisByKeyword( $keyword, $lang = null, $hub = null ) {
		$this->wf->profileIn( __METHOD__ );

		$wikis = array();

		if ( !empty( $keyword ) ) {
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
				$memKey = $this->wf->SharedMemcKey( __METHOD__, self::CACHE_VERSION,  md5( $keyword ), $hubId, $lang );
				$wikis = $this->app->wg->Memc->get( $memKey );

				if ( !is_array( $wikis ) ) {
					$db = $this->getSharedDB();

					$keyword = mysql_real_escape_string( $keyword );
					$varId = (int) WikiFactory::getVarByName( 'wgWikiTopics', null )->cv_variable_id;

					$queryParts = array( "SELECT  cl.city_id AS id, cl.city_lang AS lang, cl.city_title AS name ,cv.cv_value AS topic FROM city_list AS cl LEFT JOIN city_variables AS cv ON cl.city_id = cv.cv_city_id AND cv.cv_variable_id = {$varId}" );

					if ( is_integer( $hubId ) ) {
						$queryParts[] = "LEFT JOIN city_cat_mapping AS ccm ON cl.city_id = ccm.city_id";
					}

					$queryParts[] = "WHERE cl.city_public = 1";

					if ( !empty( $lang ) ) {
						$lang = mysql_real_escape_string( $lang );
						$queryParts[] = "AND cl.city_lang = '{$lang}'";
					}

					$queryParts[] = "AND (cl.city_title LIKE '%{$keyword}%' OR cv.cv_value LIKE '%{$keyword}%')";

					if ( is_integer( $hubId ) ) {
						$queryParts[] = "AND ccm.cat_id = {$hubId}";
					}

					$queryParts[] = 'ORDER BY cl.city_title LIMIT ' . self::MAX_RESULTS;


					//manual query as the DataBase class doesn't allow for LEFT JOIN
					//which is required in this specific case
					$rows = $db->query( implode( ' ', $queryParts ), __METHOD__ );

					while ( $row = $db->fetchObject( $rows ) ) {
						$wikis[] = array(
							'id' => $row->id,
							'name' => $row->name,
							//getting this as a separate query since it would require
							//a double join, that would complicate the situation with
							//the query's performance
							'hub' => ( !empty( $hub ) && is_string( $hub ) ) ? $hub : $this->getVerticalByWikiId( $row->id ),
							'language' => $row->lang,
							//WF stores strings as serialized data
							'topic' => ( !empty( $row->topic ) ) ? unserialize( $row->topic ) : null,
							//getting this as a separate query since it would require
							//a double join, that would complicate the situation with
							//the query's performances
							'domain' => $this->getDomainByWikiId( $row->id )
						);
					}

					$this->wg->Memc->set( $memKey, $wikis, 86400 /* 24h */ );
				}
			}
		}

		$this->wf->profileOut( __METHOD__ );
		return $wikis;
	}

	public function getPromotionData( $wikiIds = null, $lang = null, $hub = null ) {
		$this->wf->ProfileIn(__METHOD__);

		$md5 = null;

		if ( !empty( $wikiIds ) && is_array( $wikiIds ) ) {
			$md5 = md5( implode( '', $wikiIds ) );
		}

		$memKey = $this->wf->SharedMemcKey( __METHOD__, self::CACHE_VERSION, $md5, $lang, $hub );
		$results = $this->wg->Memc->get( $memKey );

		if ( !is_array( $results ) ) {
			$db = $this->getSharedDB();
			$where = array(
				'cv.city_id = cl.city_id',
				'cl.city_public' => 1,
				'cv.city_main_image IS NOT NULL',
				'(cv.city_flags & ' . self::FLAG_BLOCKED . ') != ' . self::FLAG_BLOCKED,
			);

			if ( !empty( $wikiIds ) && is_array( $wikiIds ) ) {
				$list = '';
				$count = count( $wikiIds ) - 1;

				foreach ( $wikiIds as $index => $id ) {
					$id = ((int) $id);

					if ( $id > 0 ) {
						$list .= ((int) $id) . ( ( $index < $count ) ? ',' : '');
					}
				}

				if ( !empty( $list ) ) {
					$where[] = 'cv.city_id IN (' . $list . ')';
				}
			}

			if ( !empty( $hub ) ) {
				$hubId = null;

				if ( is_string( $hub ) ) {
					//this has it's own memcache layer (24h)
					$hubData = WikiFactoryHub::getInstance()->getCategoryByName( $hub );

					if ( is_array( $hubData ) ) {
						$hubId = $hubData['id'];
					}
				} elseif ( is_integer( $hub ) ) {
					$hubId = $hub;
				}

				$where['cv.city_vertical'] = $hubId;
			}

			if ( !empty( $lang ) ) {
				$where['cv.city_lang_code'] = mysql_real_escape_string( $lang );
			}

			$rows = $db->select(
				array( 'city_visualization AS cv', 'city_list AS cl' ),
				array(
					'cv.city_id AS id',
					'cv.city_vertical AS hub_id',
					'cv.city_main_image AS main_image',
					'cv.city_description AS description',
					'cv.city_headline AS headline',
					'cl.city_title AS title',
					'cl.city_url AS url',
					'cv.city_flags AS flags',
				),
				$where,
				__METHOD__
			);

			while( $row = $db->fetchObject( $rows ) ) {
				$results[$row->id] = array(
					'hubId' => $row->hub_id,
					'mainImage' => $row->main_image,
					'description' => $row->description,
					'headline' => $row->headline,
					'title' => $row->title,
					'url' => $row->url,
					'flags' => $row->flags
				);
			}

			$this->wg->Memc->set( $memKey, $results, 86400 /* 24h */ );
		}

		$this->wf->ProfileOut(__METHOD__);
		return $results;
	}
}