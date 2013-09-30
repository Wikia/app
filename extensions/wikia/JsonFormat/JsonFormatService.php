<?php
/**
 * User: artur
 * Date: 27.05.13
 * Time: 16:10
 */

class JsonFormatService extends WikiaService {
	private $htmlParser;
	private $requestContext;

	function __construct( $htmlParser = null ) {
		if( $htmlParser == null ) {
			$htmlParser = new HtmlParser();
		}
		$this->requestContext = new RequestContext();
		$this->htmlParser = $htmlParser;
	}

	public function getJsonFormatForArticleId( $articleId ) {
		$article = Article::newFromID( $articleId );
		if ( !$article ) {
			throw new JsonFormatException("Cannot find article with id:" . $articleId);
		}
		$html = $article->getPage()->getParserOutput( ParserOptions::newFromContext( $this->requestContext))->getText();

		return $this->htmlParser->parse( $html );
	}
}
