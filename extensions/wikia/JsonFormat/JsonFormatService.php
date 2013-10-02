<?php
/**
 * User: artur
 * Date: 27.05.13
 * Time: 16:10
 */


class JsonFormatService extends \WikiaService {
	const CACHE_EXPIRATION = 3600;//1 hour

	private $htmlParser;
	private $requestContext;

	function __construct( $htmlParser = null ) {
		if( $htmlParser == null ) {
			$htmlParser = new Wikia\JsonFormat\HtmlParser();
		}
		$this->requestContext = new RequestContext();
		$this->htmlParser = $htmlParser;
	}

	public function getJsonFormatForArticleId( $articleId ) {

		$articleId = (int) $articleId;

		$article = Article::newFromID( $articleId );
		if ( !$article ) {
			throw new JsonFormatException("Cannot find article with id:" . $articleId);
		}

		$app = F::app();

		$cacheKey = wfMemcKey( "JsonFormat:".$articleId);

		$parsedHtml = $app->wg->memc->get($cacheKey);

		if($parsedHtml===false)
		{
			$html = $article->getPage()->getParserOutput( ParserOptions::newFromContext( $this->requestContext))->getText();

			$parsedHtml = $this->htmlParser->parse( $html );

			$app->wg->memc->set( $cacheKey, $parsedHtml, self::CACHE_EXPIRATION );

		}

		return $parsedHtml;
	}



}
