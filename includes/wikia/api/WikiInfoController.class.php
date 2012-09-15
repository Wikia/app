<?php
/**
 *
 */
class WikiInfoController extends WikiaApiController {


	public function getTopWikis(){

		$this->response->setCacheValidity(604800, 604800, array(WikiaResponse::CACHE_TARGET_VARNISH));

		$hub = $this->request->getInt("hub", 2);
		$limit = $this->request->getInt("limit", 10) * 3;
		$lang = $this->getVal("lang", null);

		$memKey = $this->app->wf->SharedMemcKey( __METHOD__, $hub, $limit, $lang );
		$results = $this->app->wg->Memc->get( $memKey );

		if (!is_array($results) ) {
			$results = array();
			$wikis = DataMartService::getTopWikisByPageviews( $limit, $lang, 1 );

			foreach($wikis as $wikiId => $wiki){
				if($hub == WikiFactoryHub::getInstance()->getCategoryId($wikiId)){
					$result = array();
					$result['id'] =  $wikiId;
					$result['name'] = WikiFactory::getVarValueByName( 'wgSitename', $wikiId );
					$result['topic'] = WikiFactory::getVarValueByName( 'wgWikiTopics', $wikiId );
					$result['domain'] = str_replace('http://', '', WikiFactory::getVarValueByName( 'wgServer', $wikiId ));
					$results[] = $result;
				}
			}
			$this->app->wg->Memc->set( $memKey, $results, 86400 );
		}

		//print_r($wikis);

		$this->setVal( 'results', $results );

	}

}
