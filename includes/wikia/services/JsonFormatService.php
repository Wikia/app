<?php
/**
 * User: artur
 * Date: 27.05.13
 * Time: 16:10
 */

class JsonFormatService extends WikiaService {
	private $wikitextToJsonFormatParser;

	function __construct( $wikitextToJsonFormatParser = null ) {
		if( $wikitextToJsonFormatParser == null ) {
			$wikitextToJsonFormatParser = (new WikitextToJsonFormatParserFactory())->create();
		}
		$this->wikitextToJsonFormatParser = $wikitextToJsonFormatParser;
	}

	public function getJsonFormatForArticleId( $articleId ) {
		$article = Article::newFromID( $articleId );
		$content = $article->getContent();
		return $this->wikitextToJsonFormatParser->parse( $content );
	}
}
