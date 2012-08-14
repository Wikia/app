<?php

/**
 * This controller is used to render JavaScript or CSS code from a list of articles
 * on this wiki or other Wikia wikis.
 *
 * TODO: Document the parameters and what format they need to be passed in, to make this
 * work correctly.
 * Example:
 * type=js&articles=MediaWiki:Chat.js,w:glee:User:Test/MyPage.js
 */

class ArticlesAsResourcesController extends WikiaController {

	// cache responses for a week
	const CACHE_TIME = 604800;

	/**
	 * @brief This function gets messages from given list of packages
	 */
	public function getArticles() {
		$this->app->wf->ProfileIn(__METHOD__);

		// is this JS or CSS?
		$type = $this->request->getVal('type');
		
		// get list of requested articles
		$articles = explode(',', $this->request->getVal('articles'));
		
		// TODO: GET THE CONTENTS OF ALL OF THE ARTICLES
		
		if($type == ArticlesAsResources::TYPE_JS){
			// this should be handled as JS script
			$this->response->setHeader('Content-type', 'application/javascript; charset=utf-8');
			$this->response->setContentType('text/javascript; charset=utf-8');
			
			// TODO: Minify the JS
			
		} else if($type == ArticlesAsResources::TYPE_CSS){

		
			// TODO: Minify the CSS
		}

		// cache it well :)
		if ( !$this->request->isInternal() ) {
			$this->response->setCacheValidity(self::CACHE_TIME, self::CACHE_TIME, array(
				WikiaResponse::CACHE_TARGET_BROWSER,
				WikiaResponse::CACHE_TARGET_VARNISH
			));
		}
		
		$this->app->wf->ProfileOut(__METHOD__);
	}

}
