<?php
/**
 * Controller to fetch informations about wikis
 *
 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
 */

class WikiInfoController extends WikiaApiController {


	/**
	 * Get the top wikis by pageviews optionally filtering by vertical (hub) and language
	 *
	 * @requestParam string $hub [OPTIONAL] The name of the vertical (e.g. Gaming, Entertainment,
	 * Lifestyle, etc.) to use as a filter
	 * @requestParam string $lang [OPTIONAL] The language code (e.g. en, de, fr, es, it, etc.) to use as a filter
	 * @requestParam integer $limit [OPTIONAL] The maximum number of results to fetch, defaults to 10
	 *
	 * @responseParam array wikis The list of top wikis by pageviews matching the optional filtering
	 */
	public function getTopWikis(){
		$this->wf->profileIn( __METHOD__ );

		$hub = $this->request->getVal( 'hub', null );
		$limit = $this->request->getInt( 'limit', 10 );
		$lang = $this->getVal( 'lang', null );
		$memKey = $this->app->wf->SharedMemcKey( __METHOD__, $lang, $hub, $limit );
		$results = $this->app->wg->Memc->get( $memKey );

		if ( !is_array( $results ) ) {
			$results = array();
			//On devboxes use a 90-days span as DataMart
			//data is seldomly updated there
			$wikis = DataMartService::getTopWikisByPageviews( $limit, $lang, $hub, 1, ( $this->wg->DevelEnvironment ) ? 90 : 7 );

			foreach ( $wikis as $wikiId => $wiki ) {
				$result = array();
				$result['id'] =  $wikiId;
				$result['hub'] = WikiFactory::getCategory($wikiId)->cat_name;

				//fetching data from WikiFactory
				$result['language'] = WikiFactory::getVarValueByName( 'wgLanguageCode', $wikiId );
				$result['name'] = WikiFactory::getVarValueByName( 'wgSitename', $wikiId );
				$result['topic'] = WikiFactory::getVarValueByName( 'wgWikiTopics', $wikiId );
				$result['domain'] = str_replace( 'http://', '', WikiFactory::getVarValueByName( 'wgServer', $wikiId ) );
				$results[] = $result;
			}

			$this->app->wg->Memc->set( $memKey, $results, 86400 /* 24h */ );
		}

		$this->setVal( 'wikis', $results );
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
}