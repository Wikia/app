<?php

class JsonFormatService extends \WikiaService {

	const SIMPLE_JSON_SCHEMA_VERSION = 1;
	const SIMPLE_JSON_CACHE_EXPIRATION = 14400; //4 hour

	private $htmlParser;
	private $requestContext;

	function __construct( $htmlParser = null ) {
		if( $htmlParser == null ) {
			$htmlParser = new Wikia\JsonFormat\HtmlParser();
		}
		$this->requestContext = new RequestContext();
		$this->htmlParser = $htmlParser;
		parent::__construct();
	}

	/**
	 * @param int $articleId
	 * @return JsonFormatNode
	 * @throws JsonFormatException
	 */
	public function getJsonFormatForArticleId( $articleId ) {

		$articleId = (int) $articleId;

		$article = \Article::newFromID( $articleId );
		if ( !$article ) {
			throw new JsonFormatException( "Cannot find article with id:" . $articleId );
		}

		return $this->getJsonFormatForArticle( $article );
	}

	/**
	 * @param \Article $article
	 * @return JsonFormatNode
	 */
	public function getJsonFormatForArticle( \Article $article ) {
		$measurement = \Wikia\Measurements\Time::start(["JsonFormatService", "getJsonFormatForArticle"]);

		$html = $article->getPage()->getParserOutput( \ParserOptions::newFromContext( $this->requestContext))->getText();

		$measurement->stop();
		return $this->htmlParser->parse( $html );
	}

	/**
	 *
	 */
	public function getSimpleFormatForArticle( \Article $article ) {
		$measurement = \Wikia\Measurements\Time::start(["JsonFormatService", "getSimpleFormatForArticle"]);

		$cacheKey = wfMemcKey( "SimpleJson", $article->getPage()->getId(), self::SIMPLE_JSON_SCHEMA_VERSION );
		$jsonSimple = $this->app->wg->memc->get( $cacheKey );
		if ( $jsonSimple === false ) {
			$jsonFormatRootNode = $this->getJsonFormatForArticle( $article );

			$simplifier = new Wikia\JsonFormat\JsonFormatSimplifier;
			$jsonSimple = $simplifier->getJsonFormat( $jsonFormatRootNode, $article->getTitle()->getText() );

			$this->app->wg->memc->set( $cacheKey, $jsonSimple, self::SIMPLE_JSON_CACHE_EXPIRATION );
		}

		$measurement->stop();
		return $jsonSimple;
	}
}
