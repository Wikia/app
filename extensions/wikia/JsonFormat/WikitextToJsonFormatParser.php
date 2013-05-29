<?php
/**
 * User: artur
 * Date: 21.05.13
 * Time: 14:23
 */

class WikitextToJsonFormatParser {
	/**
	 * @var WikitextToHtmlParser
	 */
	private $wikitextToHtmlParser;
	/**
	 * @var HtmlToJsonFormatParser
	 */
	private $htmlToJsonFormatParser;

	function __construct($wikitextToHtmlParser, $htmlToJsonFormatParser) {
		$this->wikitextToHtmlParser = $wikitextToHtmlParser;
		$this->htmlToJsonFormatParser = $htmlToJsonFormatParser;
	}

	/**
	 * @param $wikitext
	 * @return JsonFormatNode
	 */
	public function parse( $wikitext ) {
		$html =  $this->wikitextToHtmlParser->parse( $wikitext );
		return $this->htmlToJsonFormatParser->parse($html);
	}
}
