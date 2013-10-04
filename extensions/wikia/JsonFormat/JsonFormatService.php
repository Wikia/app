<?php

class JsonFormatService extends \WikiaService {

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
	 * @param Article $article
	 * @return JsonFormatNode
	 */
	public function getJsonFormatForArticle( \Article $article ) {
		$html = $article->getPage()->getParserOutput( \ParserOptions::newFromContext( $this->requestContext))->getText();

		return $this->htmlParser->parse( $html );
	}
}
