<?php

class JsonFormatService extends \WikiaService {

	const SIMPLE_JSON_SCHEMA_VERSION = 3;
	const SIMPLE_JSON_CACHE_EXPIRATION = 14400; //4 hour

	private $htmlParser;
	private $requestContext;
	private $profile;

	function __construct( $htmlParser = null, $profile = true ) {
		if( $htmlParser == null ) {
			$htmlParser = new Wikia\JsonFormat\HtmlParser($profile);
		}
		$this->requestContext = new RequestContext();
		$this->htmlParser = $htmlParser;
		$this->profile = $profile;
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
		if( $this->profile ) {
			$measurement = \Wikia\Measurements\Time::start([__CLASS__, __METHOD__]);
		}

		$html = $article->getPage()->getParserOutput( \ParserOptions::newFromContext( $this->requestContext))->getText();

		if( $this->profile ) {
			$measurement->stop();
		}
		return $this->htmlParser->parse( $html );
	}

	/**
	 *
	 */
	public function getSimpleFormatForArticle( \Article $article ) {
		if( $this->profile ) {
			$measurement = \Wikia\Measurements\Time::start([__CLASS__, __METHOD__]);
		}

		$cacheKey = wfMemcKey( "SimpleJson", $article->getPage()->getId(), self::SIMPLE_JSON_SCHEMA_VERSION );
		$jsonSimple = $this->app->wg->memc->get( $cacheKey );
		if ( $jsonSimple === false ) {
			$jsonFormatRootNode = $this->getJsonFormatForArticle( $article );

			$simplifier = new Wikia\JsonFormat\JsonFormatSimplifier;
			$jsonSimple = $simplifier->simplify( $jsonFormatRootNode, $article->getTitle()->getText() );

			$this->app->wg->memc->set( $cacheKey, $jsonSimple, self::SIMPLE_JSON_CACHE_EXPIRATION );
		}

		if( $this->profile ) {
			$measurement->stop();
		}
		return $jsonSimple;
	}

	public function getSimpleFormatForHtml( $html ) {
		$jsonSimple = $this->htmlParser->parse( $html );
		$simplifier = new Wikia\JsonFormat\JsonFormatSimplifier($this->profile);
		$text = $simplifier->simplifyToSnippet( $jsonSimple );
		return $text;
	}
}
