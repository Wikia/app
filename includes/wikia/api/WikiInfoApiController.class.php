<?php
/**
 * Controller to fetch informations about wikis
 *
 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
 */

class WikiInfoApiController extends WikiaApiController {
	const MAX_RESULTS = 250;
	const ITEMS_PER_BATCH = 25;

	/**
	 * Get the top wikis by pageviews optionally filtering by vertical (hub) and/or language
	 *
	 * @requestParam string $hub [OPTIONAL] The name of the vertical (e.g. Gaming, Entertainment,
	 * Lifestyle, etc.) to use as a filter
	 * @requestParam string $lang [OPTIONAL] The language code (e.g. en, de, fr, es, it, etc.) to use as a filter
	 * @requestParam integer $limit [OPTIONAL] The maximum number of results to fetch, defaults to 25
	 *
	 * @responseParam array $items The list of top wikis by pageviews matching the optional filtering
	 * @responseParam integer $total The total number of results
	 * @responseParam integer $currentBatch The index of the current batch/page
	 * @responseParam integer $batches The total number of batches/pages
	 * @responseParam integer $next The amount of items in the next batch/page
	 */
	public function getTopWikis(){
		$this->wf->profileIn( __METHOD__ );

		$hub = trim( $this->request->getVal( 'hub', null ) );
		$lang = trim( $this->getVal( 'lang', null ) );
		$limit = $this->request->getInt( 'limit', self::ITEMS_PER_BATCH );
		$batch = $this->request->getInt( 'batch', 1 );
		$memKey = $this->app->wf->SharedMemcKey( __METHOD__, $this->getVersion(), $hub, $lang, $limit );
		$results = $this->app->wg->Memc->get( $memKey );

		if ( !is_array( $results ) ) {
			$results = array();
			//On devboxes use a 90-days span as DataMart
			//data is seldomly updated there
			$wikis = DataMartService::getTopWikisByPageviews( self::MAX_RESULTS, $lang, $hub, 1 /* only pubic */, ( $this->wg->DevelEnvironment ) ? 90 : 7 );

			foreach ( $wikis as $wikiId => $wiki ) {
				$results[] = array(
					'id' => $wikiId,
					//fetching data from WikiFactory
					//the table is indexed and values cached separately
					//so making one query for all of them or many small
					//separate one doesn't make any big difference while
					//this respects WF's data abstraction layer
					'name' => WikiFactory::getVarValueByName( 'wgSitename', $wikiId ),
					'hub' => ( !empty( $hub ) ) ? $hub : $this->getWikiHubById( $wikiId ),
					'language' => WikiFactory::getVarValueByName( 'wgLanguageCode', $wikiId ),
					'topic' => WikiFactory::getVarValueByName( 'wgWikiTopics', $wikiId ),
					'domain' => $this->getWikiDomainById( $wikiId )
				);
			}

			$this->app->wg->Memc->set( $memKey, $results, 86400 /* 24h */ );
		}

		foreach ( $this->wf->PaginateArray( $results, $limit, $batch ) as $name => $value ) {
			$this->response->setVal( $name, $value );
		}

		$this->response->setCacheValidity(
			604800 /* 1 week */,
			604800 /* 1 week */,
			array(
				WikiaResponse::CACHE_TARGET_BROWSER,
				WikiaResponse::CACHE_TARGET_VARNISH
			)
		);

		$this->wf->profileOut( __METHOD__ );
	}

	/**
	 * Finds wikis which name or topic match a keyword optionally filtering by vertical (hub) and/or language,
	 * the total amount of results is limited to 250 items
	 *
	 * @requestParam string $keyword search term
	 * @requestParam string $hub [OPTIONAL] The name of the vertical (e.g. Gaming, Entertainment,
	 * Lifestyle, etc.) to use as a filter
	 * @requestParam string $lang [OPTIONAL] The language code (e.g. en, de, fr, es, it, etc.) to use as a filter
	 * @requestParam integer $limit [OPTIONAL] The number of items per each batch/page, defaults to 25
	 * @requestParam integer $batch [OPTIONAL] The batch/page index to retrieve, defaults to 1
	 *
	 * @responseParam array $items The list of wikis matching the keyword and the optional filtering
	 * @responseParam integer $total The total number of results
	 * @responseParam integer $currentBatch The index of the current batch/page
	 * @responseParam integer $batches The total number of batches/pages
	 * @responseParam integer $next The amount of items in the next batch/page
	 */
	public function searchWikis(){
		$this->wf->profileIn( __METHOD__ );

		$keyword = trim( $this->request->getVal( 'keyword', '' ) );
		$hub = trim( $this->request->getVal( 'hub', null ) );
		$lang = trim( $this->getVal( 'lang', null ) );
		$limit = $this->request->getInt( 'limit', self::ITEMS_PER_BATCH );
		$batch = $this->request->getInt( 'batch', 1 );
		$hubId = null;
		$wikis = array();

		if ( !empty( $keyword ) ) {
			if ( !empty( $hub ) ) {
				//this has it's own memcache layer (24h)
				$hubData = WikiFactoryHub::getInstance()->getCategoryByName( $hub );

				if ( is_array( $hubData ) ) {
					$hubId = $hubData['id'];
				}
			}

			if ( empty( $hub ) || ( !empty( $hub ) && is_integer( $hubId ) ) ) {
				$memKey = $this->app->wf->SharedMemcKey( __METHOD__, $this->getVersion(),  str_replace( ' ', '_', $keyword ), $hub, $lang );
				$wikis = $this->app->wg->Memc->get( $memKey );

				if ( !is_array( $wikis ) ) {
					$this->wf->profileIn( $memKey );

					$db = $this->wf->GetDB( DB_SLAVE, array(), $this->wg->ExternalSharedDB );

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
							'hub' => ( !empty( $hub ) ) ? $hub : $this->getWikiHubById( $row->id ),
							'language' => $row->lang,
							//WF stores strings as serialized data
							'topic' => ( !empty( $row->topic ) ) ? unserialize( $row->topic ) : null,
							//getting this as a separate query since it would require
							//a double join, that would complicate the situation with
							//the query's performances
							'domain' => $this->getWikiDomainById( $row->id )
						);
					}

					$this->app->wg->Memc->set( $memKey, $wikis, 86400 /* 24h */ );
					$this->wf->profileOut( $memKey );
				}
			}
		}

		foreach ( $this->wf->PaginateArray( $wikis, $limit, $batch ) as $name => $value ) {
			$this->response->setVal( $name, $value );
		}

		//store only for 24h to allow new wikis
		//to appear in a reasonable amount of time in the search
		//results
		$this->response->setCacheValidity(
			86400 /* 24h */,
			86400 /* 24h */,
			array(
				WikiaResponse::CACHE_TARGET_BROWSER,
				WikiaResponse::CACHE_TARGET_VARNISH
			)
		);

		$this->wf->profileOut( __METHOD__ );
	}

	private function getWikiDomainById( $wikiId ){
		return str_replace( 'http://', '', WikiFactory::getVarValueByName( 'wgServer', $wikiId ) );
	}

	private function getWikiHubById( $wikiId ){
		return WikiFactory::getCategory( $wikiId )->cat_name;
	}
}