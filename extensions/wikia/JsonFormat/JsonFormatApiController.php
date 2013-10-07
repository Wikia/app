<?php
/**
 * User: artur
 * Date: 31.05.13
 * Time: 12:58
 */

/**
 * Class JsonFormatApiController
 * !! Beta !!
 * simplified representation of wiki article
 */
class JsonFormatApiController extends WikiaApiController {

	const CACHE_EXPIRATION = 14400; //4 hour

	const VARNISH_CACHE_EXPIRATION = 86400; //24 hours

	const SIMPLE_JSON_SCHEMA_VERSION = 1;

	const ARTICLE_CACHE_ID = "article";

	const CACHE_BUSTER_VALUE =  2; // value to bust mem cache

	/**
	 * @throws InvalidParameterApiException
	 */
	public function getJsonFormat() {
		$articleId = $this->getRequest()->getInt("article", NULL);
		if( empty($articleId) ) {
			throw new InvalidParameterApiException( self::ARTICLE_CACHE_ID );
		}
		$jsonFormatService = new \JsonFormatService();
		$json = $jsonFormatService->getJsonFormatForArticleId( $articleId );

		$this->getResponse()->setVal( "jsonFormat" , $json->toArray() );
	}

	public function getSimpleJsonFormat() {
		$articleId = (int) $this->getRequest()->getInt("article", NULL);
		if( empty($articleId) ) {
			throw new InvalidParameterApiException( self::ARTICLE_CACHE_ID );
		}

		$article = Article::newFromID( $articleId );
		if( empty($articleId) ) {
			throw new WikiaApiQueryError( "Article not found. Id:" . $articleId );
		}

	    $cacheKey = wfMemcKey( "SimpleJson:".$articleId, self::SIMPLE_JSON_SCHEMA_VERSION, self::CACHE_BUSTER_VALUE );

	    $jsonSimple = $this->app->wg->memc->get( $cacheKey );

	    if( $jsonSimple===false ){

		    $jsonFormatService = new JsonFormatService();
		    $json = $jsonFormatService->getJsonFormatForArticleId( $articleId );

		    $simplifier = new Wikia\JsonFormat\JsonFormatSimplifier;
		    $jsonSimple = $simplifier->getJsonFormat( $json, $article->getTitle()->getText() );

		    $this->app->wg->memc->set( $cacheKey, $jsonSimple, self::CACHE_EXPIRATION );
	    }
		$response = $this->getResponse();
	    $response->setCacheValidity(self::VARNISH_CACHE_EXPIRATION, self::VARNISH_CACHE_EXPIRATION,
		                            [WikiaResponse::CACHE_TARGET_VARNISH,
			                         WikiaResponse::CACHE_TARGET_BROWSER ]);

	    $response->setFormat("json");
	    $response->setData( $jsonSimple );
    }
}
